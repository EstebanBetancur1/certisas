<?php

namespace App\Http\Controllers\Backoffice;

use App\Exports\TemplateExport;
use App\Models\Company;
use App\Models\Template;
use App\Models\TemplateItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;
use App\Traits\CrudTrait;

use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRequest;

use App\Imports\TemplatesImport;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class TemplatesController extends Controller
{
    use CrudTrait;

    protected $appLayout = "backoffice";
    protected $appName = "backoffice";

    protected $module = "Templates";
    protected $pageTitle = "Plantillas";
    protected $model = "TemplateItem";
    protected $textCreateBtn = "Importar plantillas";

    protected $fields = [
        'nit'           => 'Nit',
        'name'          => 'Nombre',
        'doc'           => 'Documento',
        'concept'       => 'Concepto'
    ];

    public function index()
    {
        $templateRepository = Repository("Template");
        $companyRepository = Repository("Company");
        $repository = Repository("TemplateItem");
        $cityRepository = Repository("City");

        $post = request()->all();

        $conditions = [];

        if(request()->input("year")){
            $conditions[] = ["year_process", "=", request()->input("year")];
        }

        if(request()->input("type")){
            $conditions[] = ["type", "=", request()->input("type")];
        }

        if(request()->input("template")){
            $conditions[] = ["template_id", "=", request()->input("template")];
        }

        if(count($conditions)){

            $conditions[] = ["company_id", "=", session("companyID")];

            if(array_key_exists("action", $post) && $post["action"] === "delete"){

                $items = $repository->deleteWhere($conditions);

                $where = array_filter($post, function($a){
                     return ($a);
                });

                if(array_key_exists("template", $post)){
                    $templateRepository->delete($post["template"]);
                }

                return redirect(route("backoffice.templates.index"))->with("alert_success", "Los registros ha sido eliminados con &eacute;xito");
            }

            $items = $repository->scopeQuery(function($query) use ($conditions){

                foreach($conditions as $where){
                    $query = $query->where($where[0], $where[1], $where[2]);
                }

                return $query->orderBy('id','desc');

            })->paginate(30);

        }else{

            $items = $repository->scopeQuery(function($query){
                return $query->where("id", "=", "-1");
            })->paginate(30);
        }

        $templates = $templateRepository->findWhere(["status" => 1, "company_id" => session("companyID")]);
        $templates = convertToArray($templates, "id", "title");

        $years = getYears();


        //
        $comps = $companyRepository->all();
        $companies = [];
        foreach($comps as $item){
            $companies[$item->id] = "{$item->nit} - {$item->name}";
        }

        $_cities = $cityRepository->all();
        foreach($_cities as $_city){
            $cities[$_city->id] = "{$_city->code} - {$_city->name} - {$_city->state->name}";
        }


        return $this->view("index", compact('items', 'templates', 'years', 'companies', 'cities'));
    }

    public function import()
    {
        return view('backoffice.templates.import');
    }

    public function templates(Request $request) {
       
        session()->put('companyID', $request->company);

        if ($request->has('data')) {
            return Template::select(['id','title as nombre'])->from('templates')->where('status',1)->where('company_id', $request->company)->get()->toJson();
        } else {

            Validator::make($request->all(), [
                'template'  => ['nullable', 'numeric', Rule::in(Template::array())],
                'type'      => ['required', 'numeric'],
                'year'      => ['required', 'numeric', Rule::in(getYears())],
                'company'   => ['required', 'numeric', Rule::in(Company::array())],
            ])->validate();

            $query = TemplateItem::select(['ti.id as id', 'ti.name as nombre','ti.nit as nit','ti.concept as concepto','ti.doc as documento','ti.date as fecha']);
            $query = $query->from('template_items as ti');

            if($request->template){
                $query = $query->where('template_id', $request->template);
            }

            $query = $query->where('type',$request->type);
            $query = $query->where('year_process',$request->year);
            $query = $query->where('company_id',$request->company);

            $query = $query->get();

            return $query->toJson();

        }
    }
    
    
    

    public function export(){

        $type = request()->input("type");
        $year = request()->input("year");
        $template = request()->input("template");

        $company = session("companyID");

        $query = TemplateItem::select(['ti.*']);
        $query = $query->from('template_items as ti');

        if($template){
            $query = $query->where('template_id', $template);
        }

        $query = $query->where('type', $type);
        $query = $query->where('year_process', $year);
        $query = $query->where('company_id', $company);

        $items = $query->get();

        $data = new TemplateExport($items);

        return Excel::download($data, 'template.xlsx');
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

        $_cities = $cityRepository->all();

        foreach($_cities as $_city){
            $cities[$_city->id] = "{$_city->code} - {$_city->name} - {$_city->state->name}";
        }

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

        $post["user_id"] = auth()->user()->id;

        $templateRepository = Repository("Template");

        try {

            $template = $templateRepository->create([
                'title'         => $post["title"],
                'type'          => $post["type"],
                'status'        => 1,
                'company_id'    => session("companyID"),
                'user_id'       => $post["user_id"],
                'period_type'   => $post["period_type"],
                'city_id'       => ((int)$post["type"] === 3)?$post["city_id"]:null,
            ]);

        } catch (\Exception $e) {
            return back()->with('alert_error', 'Ocurrio un error, por favor intente más tarde.');
        }

        $import = new TemplatesImport($post, $template);

        try {
            $import->import($file,'local', \Maatwebsite\Excel\Excel::XLSX);
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

        $registros = $import->getRowCount();
        $duplicados = $import->getDuplicateRows();

        $total = $registros + $duplicados;

        if ($registros == 0) {
            $templateRepository->delete($template->id);
        }
        return response()->redirectTo(route("backoffice.templates.index"))->with('alert_success', 'Plantilla creada con '.$registros.' registros de '.$total.' posibles.');
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


        $months = [];

        $months[1] = "Enero";
        $months[2] = "Febrero";
        $months[3] = "Marzo";
        $months[4] = "Abril";
        $months[5] = "Mayo";
        $months[6] = "Junio";
        $months[7] = "Julio";
        $months[8] = "Agosto";
        $months[9] = "Septiembre";
        $months[10] = "Octubre";
        $months[11] = "Noviembre";
        $months[12] = "Diciembre";

        return $this->view("edit", compact('item', 'cities', 'months'));
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
            'type'          => 'required|in:1,2,3',
            'file'          => 'required',
        ]);
    }

    public function delete(Request $request) {
        if (!$request->has('templates')) {
            return new JsonResponse(['error' => __('No record to delete.')],402);
        } else {
            $i = 0;
            foreach ($request->templates as $id) {
                $item = TemplateItem::find($id);
                if ($item) {
                    if ($item->delete()) $i++;
                }
            }
            return new JsonResponse(['message' => __(':number records has been deleted.',['number' => $i])]);
        }
    }
}
