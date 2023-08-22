<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Traits\CrudTrait;

class PermissionsController extends Controller
{
    use CrudTrait;

    protected $appLayout = "admin";
    protected $appName = "admin";

    protected $module = "permissions";
    protected $pageTitle = "Permisos";
    protected $classModelName = null;

    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return $this->view("index", compact('roles', 'permissions'));
    }

    public function store()
    {
        $post = request()->all();
        $repository = $this->repository;

        $validator = Validator::make($post, [
            'title' => 'required|string',
            'name'  => 'required|string',
        ]);

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("admin.{$this->module}.create"))->withErrors($validator)->withInput();
        }

        try{
            $instace = Permission::create(['name' => str_slug($post['name']), 'title' => $post['title']]);
        } catch (\Exception $e) {
            return redirect(route("admin.{$this->module}.create"))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("admin.{$this->module}.index"))->with('alert_success', 'Su registro ha sido creado con &eacute;xito');
    }

    public function edit($id)
    {
        $item = Permission::find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        return $this->view("edit", compact('item'));
    }

    public function update($id)
    {
        $post = request()->all();
        $item = Permission::find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $validator = Validator::make($post, [
            'title' => 'required|string',
            'name'  => 'required|string',
        ]);

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("admin.{$this->module}.edit", ['id' => $item->id]))->withErrors($validator)->withInput();
        }

        try{
            $item->title = $post['title'];
            $item->name = str_slug($post['name']);
            $item->save();
        } catch (\Exception $e) {
            return redirect(route("admin.{$this->module}.edit", ['id' => $item->id]))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("admin.{$this->module}.index"))->with('alert_success', 'El registro ha sido actualizado con &eacute;xito');
    }

    public function destroy($id)
    {
        $item = Permission::find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $item->delete();

        return redirect(route("admin.{$this->module}.index"))->with('alert_success', 'El registro ha sido eliminado con &eacute;xito');
    }

    public function status($role, $permission)
    {
        $role = Role::find($role);
        $permission = Permission::find($permission);

        if(! $role || ! $permission){
            return response('Registro no encontrado', 404);
        }

        if($role->hasPermissionTo($permission->name)){
            $role->revokePermissionTo($permission);
        }else{
            $role->givePermissionTo($permission);
        }

        return redirect(route("admin.{$this->module}.index"))->with('alert_success', 'El permiso ha sido actualizado con &eacute;xito');
    }
}