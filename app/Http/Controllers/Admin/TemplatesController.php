<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\CrudTrait;

use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRequest;

use App\Imports\TemplatesImport;
use Maatwebsite\Excel\Validators\ValidationException;

class TemplatesController extends Controller
{
    use CrudTrait;

    protected $appLayout = "admin";
    protected $appName = "admin";

    protected $module = "Templates";
    protected $pageTitle = "Plantillas";
    protected $model = "TemplateItem";
    protected $textCreateBtn = "Importar plantillas";

    protected $fields = [
        'nit'           => 'Nit',
        'name'          => 'Nombre',
        'doc'           => 'Documento',
        'company_id'    => 'Empresa'
    ];

    public function index()
    {               
        $templateRepository = Repository("Template");
        $companyRepository = Repository("Company");

        $post = request()->all();

        $conditions = [];

        $repository = Repository("TemplateItem");

        if(request()->input("nit")){
            $conditions[] = ["nit", "=", request()->input("nit")];
        }

        if(request()->input("name")){
            $conditions[] = ["name", "like", '%'.request()->input("name").'%'];
        }

        if(request()->input("doc")){
            $conditions[] = ["doc", "=", request()->input("doc")];
        }

        if(request()->input("date")){
            $conditions[] = ["date", "=", request()->input("date")];
        }

        if(request()->input("template")){
            $conditions[] = ["template_id", "=", request()->input("template")];
        }

        if(request()->input("company")){
            $conditions[] = ["company_id", "=", request()->input("company")];
        }

        if(array_key_exists("action", $post) && $post["action"] === "delete"){
            
            $update_template_items = DB::table('template_items')->where('template_id', '=', $post["template"])->delete();
            
            $templates = DB::table('templates')->where('id', '=', $post["template"])->delete();


            if(! $templates){
                return back()->with("alert_error", "Registro no encontrado.");
            }
            
            
            return redirect(route("admin.templates.index"))->with("alert_success", "Los registros ha sido eliminados con &eacute;xito");
        }

        $items = $repository->scopeQuery(function($query) use ($conditions){

            foreach($conditions as $where){
                $query = $query->where($where[0], $where[1], $where[2]);
            }

            return $query->orderBy('id','desc');

        })->paginate(30);

        $templates = $templateRepository->findWhere(["status" => 1]);
        $templates = convertToArray($templates, "id", "title");

        $companies = $companyRepository->findWhere(["status" => 1]);
        $companies = convertToArray($companies, "id", "name");

        return $this->view("index", compact('items', 'templates', 'companies'));
    }

    public function import()
    {
        return view('admin.templates.import');
    }

    public function create()
    {
        $companyRepository = Repository("Company");
        $cityRepository = Repository("City");

        $items = $companyRepository->all();
        $companies = [];

        foreach($items as$item){
            $companies[$item->id] = "{$item->nit} - {$item->name}";
        }

        $cities = $cityRepository->all();
        $cities = convertToArray($cities, "id", "name");

        return $this->view("create", compact('companies', 'cities'));
    }

    public function store()
    {
        $errors = [];

        $post = request()->all();
        $file = request()->file('file');
 
        if(! $file) {
            return back()->with('alert_error', 'Debe adjuntar el archivo de de excel con las facturas y numero DEX asociados');
        }

        $this->validator($post)->validate();

        $post["user_id"] = auth("admin")->user()->id;

        $templateRepository = Repository("Template");


            $template = $templateRepository->create([
                'title'         => $post["title"],
                'type'          => $post["type"],
                'status'        => 1,
                'company_id'    => $post["company_id"],
                'user_id'       => $post["user_id"],
                'type_template' => $post["type_template"],
                'city_id'       => ((int)$post["type"] === 2)?$post["city_id"]:null,
            ]);
        try {
        } catch (\Exception $e) {
            return back()->with('alert_error', 'Ocurrio un error, por favor intente más tarde.');
        }

        $import = new TemplatesImport($post, $template);


            $import->import($file,'local', \Maatwebsite\Excel\Excel::XLSX);
        try {
        } catch (ValidationException $e) {
             $failures = $e->failures();

            foreach ($failures as $failure) {
                $errors[] = [
                    'row'       => $failure->row(),
                    'field'     => $failure->attribute(),
                    'message'   => $failure->errors()[0],
                    'fields'    => $failure->values(),
                ];
            }
        }

        if(count($errors)){
            return back()->with('errors', $errors)->with('alert_error', 'Se encontraron algunos errores en las filas');
        }

        return back()->with('alert_success', 'La plantilla han sido cargadas con &eacute;xito');
    }

    public function edit($id)
    {
        $repository = Repository("TemplateItem");
        $cityRepository = Repository("City");

        $item = $repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $cities = $cityRepository->all();
        $cities = convertToArray($cities, "id", "name");

        return $this->view("edit", compact('item', 'cities'));     
    }

    public function update($id)
    {
        $post = $this->prepareForUpdateValidation();

        $repository = Repository("TemplateItem");
        $item = $repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $validator = Validator::make($post, $this->getModelRules());

        if ($validator->fails()) {
            // $validator->errors()->all();
                    echo "<pre>";
                    var_dump($validator->errors()->all());
                    exit;
                    
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->withErrors($validator)->withInput();
        }

        try{
            $instance = $repository->update($post, $item->id);
        } catch (\Exception $e) {
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("{$this->appName}.{$this->module}.index"))->with('alert_success', 'El registro ha sido actualizado con &eacute;xito');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'         => 'required|string',
            'company_id'    => 'required|integer',
            'type'          => 'required|in:1,2,3',
            'file'          => 'required',
        ]);
    }
}