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
use App\Mail\TestAdmin;

class SettingsController extends Controller
{
    use CrudTrait;

    protected $appLayout = "admin";
    protected $appName = "admin";

    protected $module = "Settings";
    protected $pageTitle = "Ajustes";
    protected $model = "Setting";

    protected $allowed_types_regular_expression = '/(\.jpg|\.jpeg|\.png)$/';
    protected $allowed_types = [ 'jpg', 'jpeg', 'png' ];
    protected $path = 'settings';

    public function editSettings()
    {
        $item = $this->repository->find(1);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $engine_image = ($item->engine_image) ? 'upload/'.$this->path.'/' . $item->engine_image : '' ;
        $google_image = ($item->google_image) ? 'upload/'.$this->path.'/' . $item->google_image : '' ;
        $twitter_image = ($item->twitter_image) ? 'upload/'.$this->path.'/' . $item->twitter_image : '' ;

        return view("admin.{$this->module}.edit", compact('item',
            'engine_image',
            'google_image',
            'twitter_image'));
    }

    public function updateSettings()
    {
        $post = request()->all();
        $repository = $this->repository;
        $item = $repository->find(1);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $validator = Validator::make($post, $this->getModelRules());

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("admin.{$this->module}.edit"))->withErrors($validator)->withInput();
        }

        
            $instance = $repository->update($post, $item->id);

            if($instance){

                $instance->save();

                if (cache()->has('setting')) {
                    cache()->forget('setting');
                }

                cache()->rememberForever('setting', function () {
                    return \DB::table('settings')->first();
                });
            }
            try{
        } catch (\Exception $e) {
            return redirect(route("admin.{$this->module}.edit"))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("admin.{$this->module}.edit"))->with('alert_success', 'El registro ha sido actualizado con &eacute;xito');
    }

    public function emailTest(){

        try {
            Mail::to(setting('email_notification'))->send(new TestAdmin());
        } catch (\Exception $e) {
            return back()->with("alert_error", "Ocurrio un error en el envio del correo...");
        }

        return back()->with("alert_success", "El mensaje ha sido enviado con exito...");
    }
}