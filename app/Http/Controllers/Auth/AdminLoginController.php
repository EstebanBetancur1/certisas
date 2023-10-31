<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Rules\JustAdminRule;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function show()
    {
        if(auth("admin")->check()){
            return response()->redirectTo(route("admin.dashboard.index"));
        }

        return view('auth.login_admin');
    }

    public function login(Request $request)
    {

        $post = request()->all();
        $remember = false;
        
        $validator = $this->validateLogin($post);

        if ($validator) {
            return redirect(route('auth.admin.login.show'))->with("alert_error", "Por favor, verifique los datos del formulario")->withErrors($validator) ->withInput();
        }

        if(array_key_exists('remember', $post) && $post['remember'] === 'on'){
            $remember = true;
        }
        
        if (Auth::guard('admin')->attempt(['email' => $post['email'], 'password' => $post['password'], 'status' => 1, 'is_admin' => 1], $remember)) {
            $adminProfile = Auth::guard('admin')->user();

            if($adminProfile){
                request()->session()->flash('alert_success', "Bienvenido {$adminProfile->full_name}!");
            }

            return redirect(route('admin.dashboard.index'));
        }

        if (Auth::attempt(['email' => $post['email'], 'password' => $post['password'], 'status' => 1], $remember)) {
            $profile = Auth::user();

            // Pregunta si tiene permiso para iniciar en el panel
            if($profile->hasPermissionTo('login-panel')){
                request()->session()->flash('alert_success', "Bienvenido {$profile->full_name}!");
                Auth::guard('admin')->login($profile);
                return redirect(route('admin.dashboard.index'));
            }else{
                Auth::logout();
            }
        }

        return redirect(route('auth.admin.login.show'))->with('alert_error', 'Usuario o Contrase&ntilde;a no v&aacute;lida');
    }

    public function logout()
    {
        $user = Auth::user();

        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        }else{
            Auth::logout();
        }

        session()->flush();

        request()->session()->flash('alert_success', "Hasta pronto!");

        return response()->redirectTo(route('auth.admin.login.show'));
    }

    protected function validateLogin($post)
    {
        $validator = Validator::make($post, [
            'email'    => ['required','email', new JustAdminRule()],
            'password' => 'required',
            'remember' => 'in:on',
        ]);

        if ($validator->fails()) {
            return $validator;
        }

        return null;
    }
}
