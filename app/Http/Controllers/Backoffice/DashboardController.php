<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        return view('backoffice.index', compact("user"));
    }

    public function switchCompany(){

        $companyRepository = repository("Company");
        $companyUserRepository = repository("CompanyUser");

        $id = session("companyID", null);

        if(! $id){
            return back()->with("alert_error", "La empresa no existe o no tiene permisos de acceso");
        }

        $item = $companyRepository->findWhere(['id' => $id])->first();

        if(! $item){
            return back()->with("alert_error", "La empresa no existe o no tiene permisos de acceso");
        }

        session()->put('companyUserType', 1);
        session()->put('companyID', $item->id);
        session()->put('companyName', $item->name);
        session()->put('companyLogo', $item->logo);

        /*
        if(auth()->user()->type === 33){
            $item = $companyRepository->findWhere(['id' => $id])->first();

            if(! $item){
                return back()->with("alert_error", "La empresa no existe o no tiene permisos de acceso");
            }

            session()->put('companyUserType', 1);
            session()->put('companyID', $item->id);
            session()->put('companyName', $item->name);

        }else{
            $item = $companyUserRepository->findWhere([
                'user_id'       => auth()->user()->id,
                'company_id'    => $id,
                'status'        => 1,
            ])->first();


            if(! $item){
                return back()->with("alert_error", "La empresa no existe o no tiene permisos de acceso");
            }

            session()->put('companyUserType', $item->type);
            session()->put('companyID', $item->company->id);
            session()->put('companyName', $item->company->name);
        }
        */

        return response()->redirectTo(route("backoffice.company.show"));
    }
}
