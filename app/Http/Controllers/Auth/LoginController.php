<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $companyRepository = repository("Company");
        $companyUserRepository = repository("CompanyUser");

        $user = User::where('email',$request->email)->first();
        if ($user) {
            if (Hash::check($request->password,$user->password)) {
                Auth::login($user,$request->filled('remember'));
                session()->flash('alert_success', __('Welcome :username !',['username' => $user->full_name]));
                $myCompanies = [];
                $companies = $companyUserRepository->findWhere(["user_id" => $user->id, "status" => 1]);
                foreach($companies as $company){
                    $myCompanies[$company->company->id] = [
                        'id'      => $company->company->id,
                        'name'    => $company->company->name
                    ];
                }
                if(count($myCompanies)) session()->put('myCompanies', $myCompanies);
                session(['totalCompanies' => DB::table("companies")->count()]);
                session(['totalUsers' => DB::table("users")->count()]);
                session(['totalEmissions' => DB::table("emissions")->count()]);

                return redirect(route('backoffice.templates.index'));
            } else throw ValidationException::withMessages(['password' => __('auth.password')]);
        } else throw ValidationException::withMessages(['email' => __('auth.failed')]);
    }

    public function logout()
    {
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
            session()->flush();
            request()->session()->flash('alert_success', __("See you soon!"));
            return response()->redirectTo(route('auth.user.login.show'));
        } else Auth::logout();

        session()->flush();

        request()->session()->flash('alert_success', __("See you soon!"));

        return response()->redirectTo("/");
    }
}
