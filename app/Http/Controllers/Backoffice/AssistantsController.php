<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Traits\CrudTrait;
use Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActive;
use App\Mail\WelcomeAssistant;

class AssistantsController extends Controller
{
    use CrudTrait;

    protected $appLayout = "backoffice";
    protected $appName = "backoffice";

    protected $module = "Assistants";
    protected $pageTitle = "Usuarios";
    protected $model = "User";
    protected $textCreateBtn = "Crear usuario";

    protected $fields = [
        'full_name'     => 'Nombre completo',
        'email'         => 'Correo Electr&oacute;nico',
        'status'        => 'Estado'
    ];

    public function index()
    {
        $items = $this->repository->findWhere([
            ['is_admin', '<>', 1],
            ['type', '=', 1]
        ]);

        $items = $this->repository->scopeQuery(function($query){

            $query = $query->join('company_users', 'users.id', '=', 'company_users.user_id');

            $query = $query->where("users.is_admin", "<>", 1);
            $query = $query->where("users.id", "<>", auth()->user()->id);
            $query = $query->where("users.type", "=", 1);
            $query = $query->where("company_users.company_id", "=", session("companyID"));

            $query = $query->select("users.*", "company_users.status as company_user_status");

            return $query->orderBy('users.id','desc');

        })->all();

        return $this->view("index", compact('items'));
    }

    public function create()
    {
        $rolesItems = Role::all();
        $roles = [];

        foreach($rolesItems as $roleItem){
            $roles[$roleItem->name] = $roleItem->title;
        }

        return $this->view("create", compact("roles"));
    }

    public function store()
    {
        $post = $this->prepareForStoreValidation();

        $repository = $this->repository;

        $rules = $this->getModelRules();

        $password = randomPassword(6);

        $rules['password'] = 'required|alpha_num';

        $post["password"] = $password;

        $validator = Validator::make($post, $rules);

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("backoffice.{$this->module}.create"))->withErrors($validator)->withInput();
        }

        $post['password'] = bcrypt($post['password']);

        try{
            $instance = $repository->create($post);

            if($instance){
                
                repository("CompanyUser")->create([
                    'user_id'       => $instance->id,
                    'company_id'    => session("companyID"),
                    'type'          => 0,
                    'status'        => 1,
                ]);

                try {
                    Mail::to($instance->email)->send(new WelcomeAssistant($instance, session('companyName'), $password));
                } catch (\Exception $e) {}
            }

        } catch (\Exception $e) {
            return redirect(route("backoffice.{$this->module}.create"))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("backoffice.{$this->module}.index"))->with('alert_success', 'Su registro ha sido creado con &eacute;xito');
    }

    public function edit($id)
    {
        $item = $this->repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $rolesItems = Role::all();
        $roles = [];

        foreach($rolesItems as $roleItem){
            $roles[$roleItem->name] = $roleItem->title;
        }

        $roleSelected = null;

        if($item->roles->count()){
            $roleSelected = $item->roles->first();
        }

        $image = ($item->image) ? $item->image : '';

        return $this->view("edit", compact('item', 'image', 'roles', 'roleSelected'));     
    }

    public function update($id)
    {
        $repository = $this->repository;
        $item = $repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        return back()->with("alert_error", "No tiene permisos para actualizar un usuario.");
    }

    public function destroy($id)
    {
        $repository = repository("CompanyUser");

        $item = $repository->findWhere([
            'user_id' => $id,
            'company_id' => session("companyID"),
        ])->first();

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $repository->delete($item->id);

        return redirect(route("{$this->appName}.{$this->module}.index"))->with('alert_success', 'El registro ha sido eliminado con &eacute;xito');
    }

    public function status($id, $status)
    {
        $repository = repository("CompanyUser");

        $item = $repository->findWhere([
            'user_id' => $id,
            'company_id' => session("companyID"),
        ])->first();

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $item->status = $status;
        $item->save();

        if((int)$status === 1){
            Mail::to($item->user->email)->send(new AccountActive($item->user, $item->company));
        }

        return redirect(route("{$this->appName}.{$this->module}.index"))->with("alert_success", "El estado de registro ha sido actualizado con &eacute;xito");
    }

    protected function prepareForStoreValidation()
    {
        $post = request()->all();

        $post["email_confirmed"] = 1;
        $post["type"] = 1;

        return $post;
    }

    protected function prepareForUpdateValidation($user = null)
    {
        $post = request()->all();

        $post["type"] = 1;
        
        return $post;
    }
}
