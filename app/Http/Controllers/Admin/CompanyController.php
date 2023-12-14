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

use App\Http\Controllers\Controller;
use App\Traits\CrudTrait;

class CompanyController extends Controller
{
    use CrudTrait;

    protected $appLayout = "admin";
    protected $appName = "admin";

    protected $module = "Company";
    protected $pageTitle = "Empresas";
    protected $model = "Company";
    protected $textCreateBtn = "Crear emrpresa";

    protected $fields = [
        'name'          => 'Empresa',
        'nit'           => 'Rut',
        'status'        => 'Estado'
    ];

    protected $allowedTypesRegularExpression = '/(\.pdf)$/';
    protected $allowedTypes = ['pdf'];
    protected $pathUpload = "rut";

    public function create()
    {
        $responsibilityRepository = repository("Responsibility");
        $responsibilities = $responsibilityRepository->all();

        $sectionalRepository = repository("Sectional");
        $sectionals = convertToArray($sectionalRepository->all(), 'code', 'title');

        return $this->view("create", compact("responsibilities", "sectionals"));
    }

    public function store()
    {
        $post = $this->prepareForStoreValidation();

        $responsibilities = (array_key_exists("responsibilities", $post))?$post["responsibilities"]:[];
        unset($post["responsibilities"]);

        $repository = $this->repository;

        $rules = $this->getModelRules();

        $validator = Validator::make($post, $rules);

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("admin.{$this->module}.create"))->withErrors($validator)->withInput();
        }

        try{
            $instance = $repository->create($post);

            if($instance){
                
                array_walk($responsibilities, function(&$element, $key){          
                    $element = (int)$element;
                });

                $instance->responsibilities()->sync($responsibilities);
            }

        } catch (\Exception $e) {
            return redirect(route("admin.{$this->module}.create"))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("admin.{$this->module}.index"))->with('alert_success', 'Su registro ha sido creado con &eacute;xito');
    }

    public function edit($id)
    {
        $item = $this->repository->find($id);

        if(! $item){
            return back()->with("alert_error", "Registro no encontrado.");
        }

        $responsibilityRepository = repository("Responsibility");
        $responsibilities = $responsibilityRepository->all();

        $sectionalRepository = repository("Sectional");
        $sectionals = convertToArray($sectionalRepository->all(), 'code', 'title');

        $responsibilitiesSelected = convertToArray($item->responsibilities()->get(), "id", "title");

        return $this->view("edit", compact('item', 'responsibilities', 'responsibilitiesSelected', 'sectionals'));
    }

    public function update($id)
    {
        $post = $this->prepareForUpdateValidation();

        $responsibilities = (array_key_exists("responsibilities", $post))?$post["responsibilities"]:[];

        unset($post["responsibilities"]);

        $repository = $this->repository;
        $item = $repository->find($id);

        if(! $item){
            return back()->with("alert_error", "Registro no encontrado.");
        }

        $rules = $this->getModelRules();

        $rules['email'] = [
            'required',
            Rule::unique('companies')->ignore($item->id),
        ];

         $rules['nit'] = [
            'required',
            Rule::unique('companies')->ignore($item->id),
        ];

        $validator = Validator::make($post, $rules);

        if ($validator->fails()) {
            // $validator->errors()->all();                    
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->withErrors($validator)->withInput();
        }

        try{
            $instance = $repository->update($post, $item->id);

            array_walk($responsibilities, function(&$element, $key){          
                $element = (int)$element;
            });

            $instance->responsibilities()->sync($responsibilities);

        } catch (\Exception $e) {
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("{$this->appName}.{$this->module}.index"))->with('alert_success', 'El registro ha sido actualizado con &eacute;xito');
    }

    public function download($id){
        $companyRepository = repository("Company");

        $item = $companyRepository->findWhere(["id" => $id])->first();

        if(! $item){
            return back()->with("alert_error", "Registro no encontrado.");
        }

        if($item->file){
            if($item->file && is_file(public_path() . '/upload/rut/' . $item->file)){
                return response()->download(public_path() . '/upload/rut/' . $item->file);
            }
        }

        return back()->with("alert_error", "Ocurrio un error al descargar el archivo.");
    }

    public function uploadRut($id){

        $companyRepository = repository("Company");

        $item = $companyRepository->findWhere(["id" => $id])->first();

        if(! $item){
            return back()->with("alert_error", "Registro no encontrado.");
        }

        return $this->view("upload_rut", compact('item'));     
    }

    public function updateRut($id){
        $post = request()->all();

        $files = $this->uploadFile("rut");

        if(array_key_exists("status", $files) && $files["status"] === true){

            $path = public_path();

            $parser = new \Smalot\PdfParser\Parser();
            $pdf    = $parser->parseFile($path.$files["preview"]);
             
            $text = $pdf->getText();
            
            $data = parsePdf($text);

            if(array_key_exists("nit", $data) && $data["nit"]){

                $companyRepository = Repository("Company");

                $company = $companyRepository->findWhere(["id" => $id, "nit" => $data["nit"]])->first();

                if(! $company){
                    return back()->with("alert_error", "Este rut no se encuentra asociado a esta empresa.");
                }

                $company->dv                = $data["dv"];
                $company->sectional         = $data["sectional"];
                $company->type              = $data["type"];
                $company->name              = $data["name"];
                $company->city              = $data["city"];
                $company->address           = $data["address"];
                $company->email             = $data["email"];
                $company->responsibilities  = $data["responsibilities"];
                $company->date              = $data["date"];
                $company->file              = $files["name"];

                $company->save();

                $responsibilities = ($company->responsibilities)?json_decode($company->responsibilities, true):[];
                $responsibilities = array_keys($responsibilities);

                array_walk($responsibilities, function(&$element, $key){          
                    $element = (int)$element;
                });
                
                $company->responsibilities()->sync($responsibilities);
                        
                return back()->with("alert_success", "La empresa ha sido actualizada con &eacute;xito.");
            }
        }

        return back()->with("alert_error", "Ocurrio un error, por favor intente nuevamente");
    }

    public function removePermissions($id, $user){
        $repository = repository("CompanyUser");

        $item = $repository->findWhere(["company_id" => $id, "user_id" => $user])->first();

        if(! $item){
            return back()->with("alert_error", "Registro no encontrado, por favor intente m&aacute;s tarde.");
        }

        $repository->delete($item->id);

        return back()->with("alert_success", "El permiso fue eliminado con &eacute;xito.");
    }

    public function searchFromRut(){

        $userRepository = repository("User");

        $users = $userRepository->findWhere(["status" => 1]);
        $users = convertToArray($users, 'id', 'full_name');

        return $this->view("search_from_rut", compact('users'));
    }

    public function updateFromRut(){
        $post = request()->all();

        if (!array_key_exists("user", $post) && !array_key_exists("rut", $post)) {
            return back()->with("alert_error", "Debe seleccionar un usuario y un archivo.");
        }
    
        // Verificar si no se recibió usuario
        if (!array_key_exists("user", $post)) {
            return back()->with("alert_error", "Debe seleccionar un usuario.");
        }
    
        // Verificar si no se recibió rut
        if (!array_key_exists("rut", $post)) {
            return back()->with("alert_error", "Debe seleccionar un archivo.");
        }

        $company = null;

        $userRepository = repository("User");
        $companyUserRepository = repository("CompanyUser");

        $user_id = array_key_exists('user', $post) ? $post['user'] : -1;
        $user = $userRepository->find($user_id);
        
        if (!$user) {
            return back()->with("alert_error", "Usuario no encontrado, por favor intente nuevamente.");
        }
    

        $file = $this->uploadFile("rut");

        if(! $file){
            return back()->with("alert_error", "Debe seleccionar un archivo.");
        }

        if(array_key_exists("status", $file) && $file["status"] === true){

            $path = public_path();

            $parser = new \Smalot\PdfParser\Parser();
            $pdf    = $parser->parseFile($path.$file["preview"]);

            $text = $pdf->getText();

            $data = parsePdf($text);

            if(array_key_exists("nit", $data) && $data["nit"]){

                $companyRepository = Repository("Company");

                $company = $companyRepository->findWhere(["nit" => $data["nit"]])->first();

                if($company){
                    $company->dv                = $data["dv"];
                    $company->sectional         = $data["sectional"];
                    $company->type              = $data["type"];
                    $company->name              = $data["name"];
                    $company->city              = $data["city"];
                    $company->phone             = $data["phone"];
                    $company->address           = $data["address"];
                    $company->email             = $data["email"];
                    $company->activities        = $data["activities"];
                    $company->responsibilities  = $data["responsibilities"];
                    $company->date              = $data["date"];
                    $company->file              = $file["name"];

                    $company->save();

                }else{

                    $companyRepository = Repository("Company");

                    $company = $companyRepository->create([
                        'nit'               => $data["nit"],
                        'dv'                => $data["dv"],
                        'sectional'         => $data["sectional"],
                        'type'              => $data["type"],
                        'name'              => $data["name"],
                        'city'              => $data["city"],
                        'phone'             => $data["phone"],
                        'address'           => $data["address"],
                        'email'             => $data["email"],
                        'activities'        => $data["activities"],
                        'responsibilities'  => $data["responsibilities"],
                        'date'              => $data["date"],
                        'file'              => $file["name"],
                        'status'            => 1,
                    ]);
                }

                if($company){

                    $responsibilities = json_decode($company['responsibilities'], true);
                    $responsibilities = array_keys($responsibilities);

                    array_walk($responsibilities, function(&$element, $key){
                        $element = (int)$element;
                    });

                    $company->responsibilities()->sync($responsibilities);

                    if($user){
                        $userCompany = $companyUserRepository->findWhere(["user_id" => $user->id, 'company_id' => $company->id])->first();

                        if(! $userCompany){
                            $userCompany = $companyUserRepository->create([
                                'user_id'       => $user->id,
                                'company_id'    => $company->id,
                                'type'          => 0,
                                'status'        => 1,
                            ]);
                        }

                    }

                    return response()->redirectTo(route("admin.company.edit", $company->id))->with("alert_success", "La empresa ha sido actualizada con exito");
                }
            }
        }

        return back()->with("alert_error", "Ocurrio un error, por favor intente nuevamente");
    }

    private function uploadFile($field)
    {
        $public_path = public_path();

        $allowed_types = $this->allowedTypes;
        $max_size = config('app.max_size_image');

        Storage::disk('upload')->makeDirectory($this->pathUpload);

        $files = request()->allFiles();   

        if(count($files) == 0){
            return null;
        }

        $UploadedFile = (array_key_exists($field, $files)) ? $files[$field] : [ ];

        if ($UploadedFile && $UploadedFile instanceof UploadedFile) {

            $originalName = $UploadedFile->getClientOriginalName();
            $extension = strtolower($UploadedFile->getClientOriginalExtension());
            

            if ( ! in_array($extension, $allowed_types)) {
                return [
                    'status' => false,
                    'message' => 'El tipo de archivo seleccinado no es v&aacute;lido.'
                ];
            }


            // Sustituye todo lo que no sea alfanumerico por guion
            $newName = preg_replace('/[^\.a-zA-Z0-9]+/', '-', strtolower($originalName));
            $newName = preg_replace('/[^0-9]+/', '', Carbon::now()->format('Y-m-d H:i:s')).'-'.$newName;

            $pathAbsolute = $public_path.'/upload/'.$this->pathUpload;

            try {
                $target = $UploadedFile->move($pathAbsolute, $newName);
            } catch (\Exception $e) {
                return [
                    'status' => false,
                    'message' => 'Ocurrio un error al cargar la imagen, por favor intente nuevamente'
                ];
            }

            if ($target) {
                return [
                    'status' => true,
                    'preview' => config('app.base_url').'/upload/'.$this->pathUpload.'/'.$newName,
                    'path'    => $this->pathUpload,
                    'name'    => $newName
                ];
            }
        }

        return [
            'status' => false,
            'message' => 'Ocurrio un error, por favor intente mas tarde.'
        ];
    }
}