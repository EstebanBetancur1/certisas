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

use Illuminate\Support\Facades\Mail;
use App\Mail\NewCompany;
use App\Mail\RegisterRequest;
use Illuminate\Support\Facades\Validator;

use Smalot\PdfParser\Parser;

class RequestController extends Controller
{
    protected $allowedTypesRegularExpression = '/(\.pdf)$/';
    protected $allowedTypes = ['pdf'];
    protected $pathUpload = "rut";

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function access()
    {
        $post = request()->all();
        $this->validator($post)->validate();

        if(array_key_exists("rut", $post) && $post["rut"]){

            $files = $this->uploadFile("rut");

            if(array_key_exists("status", $files) && $files["status"] === true){

                $path = public_path();

                $parser = new \Smalot\PdfParser\Parser();
                $pdf    = $parser->parseFile($path.$files["preview"]);
                 
                $text = $pdf->getText();
                
                $data = parsePdf($text);


                if(array_key_exists("nit", $data) && $data["nit"]){

                    $requestRepository = repository("Request");
                    $companyRepository = Repository("Company");

                    $company = $companyRepository->findWhere(["nit" => $data["nit"]])->first();

                    if($company){
                        
                        $companyUserRepository = Repository("CompanyUser");

                        $companyUser = $companyUserRepository->findWhere(["user_id" => auth()->user()->id, 'company_id' => $company->id])->first();

                        if($companyUser){
                            return back()->with("alert_error", "Usted ya se encuentra relacionado a esta empresa.");
                        }
                                
                        $companyUser = $companyUserRepository->create([
                            'user_id'       => auth()->user()->id,
                            'company_id'    => $company->id,
                            'type'          => 0,
                            'status'        => 0,
                        ]);

                        if($companyUser){

                            $mainUser = $companyUserRepository->findWhere([
                                'company_id'    => $company->id,
                                'type'          => 1,
                                'status'        => 1,
                            ])->first();

                            if($mainUser){
                                try {
                                    Mail::to($mainUser->user->email)->send(new RegisterRequest(auth()->user(), $company));
                                } catch (\Exception $e) {}
                            }

                            try {
                                Mail::to(setting('email_notification'))->send(new RegisterRequest(auth()->user(), $company));
                            } catch (\Exception $e) {}

                        }

                        return back()->with("alert_success", "Su solicitud de acceso a sido enviada con &eacute;xito.");
                    }


                    try {

                        $instance = $requestRepository->create([
                            'nit'               => $data["nit"],
                            'dv'                => $data["dv"],
                            'sectional'         => $data["sectional"],
                            'type'              => $data["type"],
                            'name'              => $data["name"],
                            'city'              => $data["city"],
                            'address'           => $data["address"],
                            'email'             => $data["email"],
                            'email_user'        => auth()->user()->email,
                            'user_request'      => auth()->user()->id,
                            'phone'             => $data["phone"],
                            'activities'        => $data["activities"],
                            'responsibilities'  => $data["responsibilities"],
                            'file'              => $files["name"],
                            'status'            => 0,
                            'email_status'      => 1,
                        ]);

                        if($instance){

                            try {
                                Mail::to(setting('email_notification'))->send(new NewCompany($instance));
                            } catch (\Exception $e) {}

                            return back()->with("alert_success", "Su solicitud de acceso a sido enviada con &eacute;xito.");
                        }

                    } catch (\Exception $e) {
                        return back()->with("alert_error", "Ocurrio un error, por favor intente nuevamente.");
                    }
                }
            }
        }

        if(array_key_exists("nit", $post) && $post["nit"]){

            $companyRepository = Repository("Company");
            $company = $companyRepository->findWhere(["nit" => $post["nit"]])->first();

            if(! $company){
                return back()->with("alert_error", "La empresa no fue encontrada.");
            }


            $companyUserRepository = Repository("CompanyUser");

            $companyUser = $companyUserRepository->findWhere(["user_id" => auth()->user()->id, 'company_id' => $company->id])->first();

            if($companyUser){
                return back()->with("alert_error", "Usted ya se encuentra relacionado a esta empresa.");
            }
                    
            $companyUserRepository->create([
                'user_id'       => auth()->user()->id,
                'company_id'    => $company->id,
                'type'          => 0,
                'status'        => 0,
            ]);

            $mainUser = $companyUserRepository->findWhere([
                'company_id'    => $company->id,
                'type'          => 1,
                'status'        => 1,
            ])->first();

            if($mainUser){
                Mail::to($mainUser->user->email)->send(new RegisterRequest(auth()->user(), $company));
            }

            Mail::to(setting('email_notification'))->send(new RegisterRequest(auth()->user(), $company));

            return back()->with("alert_success", "Su solicitud de acceso a sido enviada con &eacute;xito.");
        }

        return back()->with("alert_error", "Ocurrio un error, por favor intente nuevamente");
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nit'     => 'nullable|string'
        ]);
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
            $size = $UploadedFile->getClientSize();

            if ( ! in_array($extension, $allowed_types)) {
                return [
                    'status' => false,
                    'message' => 'El tipo de archivo seleccinado no es v&aacute;lido.'
                ];
            }

            if ($size > (int) $max_size * 1024) {
                return [
                    'status' => false,
                    'message' => 'La imagen no puede ser mayor a ('.$max_size.')Kb.'
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
