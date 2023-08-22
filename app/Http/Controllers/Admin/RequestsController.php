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

use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRequest;

class RequestsController extends Controller
{
    use CrudTrait;

    protected $appLayout = "admin";
    protected $appName = "admin";

    protected $module = "Requests";
    protected $pageTitle = "Solicitudes";
    protected $model = "Request";

    protected $fields = [
        'nit'           => 'Nit',
        'name'          => 'Nombre',
        'email_status'  => 'Estatus E-mail',
        'status'        => 'Estado',
    ];

    protected $statusOptions = [
        0 => 'Pendiente',
        1 => 'Verificado'
    ];

    public function download($id){
        $requestRepository = repository("Request");

        $item = $requestRepository->findWhere(["id" => $id])->first();

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

    public function status($id, $status)
    {
        $repository = $this->repository;
        $item = $repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        if((int)$status === 1){

            $companyRepository = repository("Company");
            $userRepository = repository("User");
            $companyUserRepository = repository("CompanyUser");

            try {
                $company = $companyRepository->create([
                    'nit'               => $item->nit,
                    'dv'                => $item->dv,
                    'sectional'         => $item->sectional,
                    'type'              => $item->type,
                    'name'              => $item->name,
                    'city'              => $item->city,
                    'address'           => $item->address,
                    'email'             => $item->email,
                    'phone'             => $item->phone,
                    'file'              => $item->file,
                    'date'              => $item->date,
                    'activities'        => $item->activities,
                    'responsibilities'  => $item->responsibilities,
                    'status'            => 1,
                ]);
            } catch (\Exception $e) {
                return back()->with("alert_success", "Ocurrio error 1001, por favor intente mas tarde.");
            }

            if($company){

                $responsibilities = ($item->responsibilities)?json_decode($item->responsibilities, true):[];
                $responsibilities = array_keys($responsibilities);

                array_walk($responsibilities, function(&$element, $key){
                    $element = (int)$element;
                });

                $company->responsibilities()->sync($responsibilities);

                // Este valor existe cuadno solicito tener acceso auna empresa desde mi cuenta.
                if($item->user_request){

                    $user = $userRepository->findWhere(["id" => $item->user_request])->first();

                    if($user){

                        $userCompany = $companyUserRepository->create([
                            'user_id'       => $user->id,
                            'company_id'    => $company->id,
                            'type'          => 0,
                            'status'        => 1,
                        ]);

                        try {
                            Mail::to($user->email)->send(new ConfirmRequest($user, $company));
                        } catch (\Exception $e) {}

                        $item->status = $status;
                        $item->save();

                        return back()->with("alert_success", "El estado de la solicitud ha sido actualizado con &eacute;xito");
                    }
                }

                try {
                    $user = $userRepository->create([
                        'full_name'             => 'New User',
                        'email'                 => $item->email_user,
                        'full_name'             => 'New User',
                        'password'              => bcrypt($item->nit),
                        'status'                => 1,
                        'type'                  => 1,
                        'token_pre_register'    => sha1(datetimeToken())
                    ]);
                } catch (\Exception $e) {
                    return back()->with("alert_error", "Ocurrio error 1002, por favor intente mas tarde.");
                }

                if($user){

                    try {
                        $userCompany = $companyUserRepository->create([
                            'user_id'       => $user->id,
                            'company_id'    => $company->id,
                            'type'          => 1,
                        ]);
                    } catch (\Exception $e) {
                        return back()->with("alert_success", "Ocurrio error 1003, por favor intente mas tarde.");
                    }

                    if($userCompany){
                        try {
                            Mail::to($user->email)->send(new ConfirmRequest($user, $company));
                        } catch (\Exception $e) {}
                    }
                }
            }
        }

        $item->status = $status;
        $item->save();

        return back()->with("alert_success", "El estado de registro ha sido actualizado con &eacute;xito");
    }
}
