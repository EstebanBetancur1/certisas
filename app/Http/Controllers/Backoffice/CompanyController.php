<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\UpdateMyAccountRequest;
use App\Repositories\UserRepository;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Image;

class CompanyController extends Controller
{
    protected $allowed_types_regular_expression = '/(\.jpg|\.jpeg|\.png)$/';
    protected $allowed_types = [ 'jpg', 'jpeg', 'png' ];
    protected $path = 'companies';

    protected $allowedTypesRegularExpression = '/(\.pdf)$/';
    protected $allowedTypes = ['pdf'];
    protected $pathUpload = "rut";

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $companyRepository = repository("Company");
        $sectionalRepository = repository("Sectional");

        $item = $companyRepository->findWhere(["id" => session("companyID")])->first();

        if(! $item){
            return back()->with("alert_error", "Debes seleccionar una empresa para poder continuar.");
        }

        $sectionalID = $item->sectional;

        if(strlen($sectionalID) === 1){
            $sectionalID = "0{$sectionalID}";
        }

        $sectional = $sectionalRepository->findWhere(['code' => $sectionalID])->first();

        $logo = ($item->logo) ? $item->logo : null;

        return view('backoffice.company.show', compact("item", "sectional", "logo"));
    }

    public function download(){
        $requestRepository = repository("Request");

        $item = $requestRepository->findWhere(["id" => session("companyID")])->first();

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

    public function updateLogo(){

        $companyRepository = repository("Company");

        $item = $companyRepository->findWhere(["id" => session("companyID")])->first();

        if(! $item){
            abort(404);
        }

        if(count(request()->allFiles()) > 0){
            $upload = $this->uploadLogo();
            $logo = $item->logo;

            if(is_array($upload)){
                if($upload['status']){
                    $item->logo = $upload['name'];
                }else{

                    return back()->with("alert_error", $upload['message']);
                }

                $item->save();
            }

            $this->destroyFile($logo);
        }

        return back()->with("alert_success", "El logo ha sido actualizado con éxito.");
    }

    private function uploadLogo($field = 'image'){

        $public_path = public_path();

        $allowed_types = $this->allowed_types;
        $max_size = config('app.max_size_image');

        Storage::disk('upload')->makeDirectory($this->path);

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

            $pathAbsolute = $public_path.'/upload/'.$this->path;

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
                    'preview' => config('app.base_url').'/upload/'.$this->path.'/'.$newName,
                    'path'    => $this->path,
                    'name'    => $newName
                ];
            }
        }

        return [
            'status' => false,
            'message' => 'Ocurrio un error, por favor intente mas tarde.'
        ];
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
                $company->phone             = $data["phone"];

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
            // $size = $UploadedFile->getClientSize();

            if ( ! in_array($extension, $allowed_types)) {
                return [
                    'status' => false,
                    'message' => 'El tipo de archivo seleccinado no es v&aacute;lido.'
                ];
            }

            // if ($size > (int) $max_size * 1024) {
            //     return [
            //         'status' => false,
            //         'message' => 'La imagen no puede ser mayor a ('.$max_size.')Kb.'
            //     ];
            // }

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

    private function destroyFile($image){
        $public_path = public_path();
        $pathAbsolute = $public_path.'/upload/'.$this->path;

        if(is_file($pathAbsolute.'/'.$image)){
            unlink($pathAbsolute.'/'.$image);
        }
    }
}
