<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Traits\CrudTrait;
use Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActive;

class UsersController extends Controller
{
    use CrudTrait;

    protected $appLayout = "admin";
    protected $appName = "admin";

    protected $module = "Users";
    protected $pageTitle = "Usuarios";
    protected $model = "User";
    protected $textCreateBtn = "Crear usuario";

    protected $fields = [
        'full_name'     => 'Nombre completo',
        'email'         => 'Correo Electr&oacute;nico',
        'status'        => 'Estado'
    ];

    private $fileFields = ["image"];
    private $pathUpload = "users";

    public function index()
    {
        $items = $this->repository->findWhere([
            ['is_admin', '<>', 1],
            ['type', '=', 1],
        ]);

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

        $rules['password'] = 'required|alpha_num|confirmed|min:6';

        $validator = Validator::make($post, $rules);

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("admin.{$this->module}.create"))->withErrors($validator)->withInput();
        }

        $post['password'] = bcrypt($post['password']);  

        try{
            $instance = $repository->create($post);

            if($instance){
                if(array_key_exists('role', $post)){
                    $instance->syncRoles($post['role']);
                }

                if($this->hasFiles){
                    $this->processFiles($instance);
                }
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
        $post = $this->prepareForUpdateValidation();

        $repository = $this->repository;
        $item = $repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $rules = $this->getModelRules();

        $rules['email'] = [
            'required',
            Rule::unique('users')->ignore($item->id),
        ];

        $validator = Validator::make($post, $rules);

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->withErrors($validator)->withInput();
        }

        if(
            array_key_exists('password', $post) && 
            array_key_exists('password_confirmation', $post) && 
            $post["password"] && 
            $post["password_confirmation"]
        ){
            $post['password'] = bcrypt($post['password']);
        }else{
            unset($post['password']);
        }

        try{
            $instance = $repository->update($post, $item->id);

            if($instance && $this->hasFiles){
                $this->processFiles($item, true);
            }

        } catch (\Exception $e) {
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        if((int)$item->is_admin === 1){
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->with('alert_success', 'El registro ha sido actualizado con &eacute;xito');
        }

        return redirect(route("{$this->appName}.{$this->module}.index"))->with('alert_success', 'El registro ha sido actualizado con &eacute;xito');
    }

    public function companyAccess($id, $company){

        $repository = repository("CompanyUser");

        $item = $repository->findWhere([
            'user_id' => $id,
            'company_id' => $company,
        ])->first();

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $item->status = 1;
        $item->save();

        try{
            Mail::to($item->user->email)->send(new AccountActive($item->user, $item->company));
        } catch (\Exception $e) {}

        return back()->with("alert_success", "El acceso a la empresa ha sido confirmado con &eacute;xito");     
    }

    protected function prepareForStoreValidation()
    {
        $post = request()->all();

        $post["email_confirmed"] = 1;
        $post["type"] = 1;

        return $post;
    }

    protected function prepareForUpdateValidation()
    {
        $post = request()->all();

        $post["type"] = 1;

        return $post;
    }
}


