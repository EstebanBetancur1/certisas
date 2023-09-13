<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Models\User;
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

use App\Imports\TemplatesImport;
use Maatwebsite\Excel\Validators\ValidationException;

use PDF;

use Illuminate\Support\Facades\Validator;

class DeclarationsController extends Controller
{
    protected $appLayout = "backoffice";
    protected $appName = "backoffice";
    protected $module = "Declarations";
    protected $pageTitle = "Declaraciones";
    protected $model = "Doc";
    protected $textCreateBtn = "";

    public function index(){
        $periods = [];
        $periods_bimestral = [];
        $items = [];

        $where_1 = ['company_id' => session("companyID"), 'type' => 1];
        $where_2 = ['company_id' => session("companyID"), 'type' => 2];
        $where_3 = ['company_id' => session("companyID"), 'type' => 3];

        $years = [];
        $now = Carbon::now(config('app.timezone'));
        $yearStart = $now->year;
        $y = 0;

        $bankRepository = Repository("Bank");
        $declarationRepository = Repository("Declaration");
        $municipalityRepository = Repository("Municipality");

        $banks = $bankRepository->all();
        $banks = convertToArray($banks, "id", "name");

        $municipalities = $municipalityRepository->all();
        $municipalities = convertToArray($municipalities, "id", "name");

        for($i = 6; $i > 0; $i--){
            $years[$yearStart - $y] = $yearStart - $y;
            $y++;
        }

        $type = (int)request()->input("type", 1);

        $periods["1"] = "Enero";
        $periods["2"] = "Febrero";
        $periods["3"] = "Marzo";
        $periods["4"] = "Abril";
        $periods["5"] = "Mayo";
        $periods["6"] = "Junio";
        $periods["7"] = "Julio";
        $periods["8"] = "Agosto";
        $periods["9"] = "Septiembre";
        $periods["10"] = "Octubre";
        $periods["11"] = "Noviembre";
        $periods["12"] = "Diciembre";

        $periods_bimestral["1"] = "Enero - Febrero";
        $periods_bimestral["2"] = "Marzo - Abril";
        $periods_bimestral["3"] = "Mayo - Junio";
        $periods_bimestral["4"] = "Julio - Agosto";
        $periods_bimestral["5"] = "Septiembre - Octubre";
        $periods_bimestral["6"] = "Noviembre - Diciembre";

        if(request()->input("tab") === "s1"){
            if(request()->input("year")){
                $where_1 = array_merge($where_1, ['year' => request()->input("year")]);
            }

            if(request()->input("period")){
                $where_1 = array_merge($where_1, ['period' => request()->input("period")]);
            }
        }

        if(request()->input("tab") === "s2"){
            if(request()->input("year")){
                $where_2 = array_merge($where_2, ['year' => request()->input("year")]);
            }

            if(request()->input("period")){
                $where_2 = array_merge($where_2, ['period' => request()->input("period")]);
            }
        }

        if(request()->input("tab") === "s3"){
            if(request()->input("year")){
                $where_3 = array_merge($where_3, ['year' => request()->input("year")]);
            }

            if(request()->input("period")){
                $where_3 = array_merge($where_3, ['period' => request()->input("period")]);
            }
        }

        $items_1 = $declarationRepository->orderBy("id", "desc")->findWhere($where_1);
        $items_2 = $declarationRepository->orderBy("id", "desc")->findWhere($where_2);
        $items_3 = $declarationRepository->orderBy("id", "desc")->findWhere($where_3);

        return view('backoffice.declarations.index', compact("years", "periods", "municipalities", "periods_bimestral", "banks", "items_1", "items_2", "items_3"));
    }

  

    public function store(){
        $declarationRepository = Repository("Declaration");
        $post = request()->all();
        if(request()->input("tab")){
            $tab = request()->input("tab");
        }else{
            return back()->with("alert_error", 'Ocurrio un error, por favor intente nuevamente.');
        }

        

        if($tab === "s1"){
            $validator = $this->validatorType_1($post);
        }elseif($tab === "s2"){
            $validator = $this->validatorType_2($post);
        }elseif($tab === "s3"){
            $validator = $this->validatorType_3($post);
        }

        if ($validator && $validator->fails()) {
            return response()->redirectTo(route("backoffice.declarations.index", ["tab" => $tab]))->with("alert_error", "Ocurrio un error, por favor verifique los campos del formulario")->withInput();
        }

        try {

            if($tab === "s3"){
                $declaration = $declarationRepository->create([
                    'type'              => $post["type"],
                    'period_type'       => $post["period_type"],
                    'year'              => $post["year"],
                    'period'            => $post["period"],
                    'declaration'       => $post["declaration"],
                    'municipality_id'   => $post["municipality_id"],
                    'bank_id'           => $post["bank_id"],
                    'date_payment'      => $post["date_payment"],
                    'date_emission'     => datetimeFormat(null, 'Y-m-d'),
                    'company_id'        => session("companyID")
                ]);
            }else{
                $declaration = $declarationRepository->create([
                    'type'          => $post["type"],
                    'period_type'   => $post["period_type"],
                    'year'          => $post["year"],
                    'period'        => $post["period"],
                    'form'          => $post["form"],
                    'nro'           => $post["nro"],
                    'bank_id'       => $post["bank_id"],
                    'date_payment'  => $post["date_payment"],
                    'date_emission' => datetimeFormat(null, 'Y-m-d'),
                    'company_id'    => session("companyID")
                ]);
            }
        } catch (\Exception $e) {
            return response()->redirectTo(route("backoffice.declarations.index", ["tab" => $tab]))->with("alert_error", "Ocurrio un error, por favor intente nuevamente.")->withInput();
        }

        if($declaration){
            return response()->redirectTo(route("backoffice.declarations.index", ["tab" => $tab]))->with("alert_success", "La declaraci&oacute;n ha sido almacenada con &eacute;xito.");
        }

        return response()->redirectTo(route("backoffice.declarations.index", ["tab" => $tab]))->with("alert_error", "Ocurrio un error, por favor intente nuevamente.");
    }




protected function validatorType_1($post){
    $validator = Validator::make($post, [
        'type'              => 'required|in:1',
        'year'              => 'required',
        'period_type'       => 'required|in:1',
        'period'            => 'required|integer',
        'form'              => 'required|string',
        'nro'               => 'required|string',
        'bank_id'           => 'required|integer',
        'date_payment'      => 'required|date',
    ]);

    if ($validator->fails()) {
        return $validator;
    }

    return null;
}

protected function validatorType_2($post){
    $validator = Validator::make($post, [
        'type'              => 'required|in:2',
        'year'              => 'required',
        'period_type'       => 'required|in:1',
        'period'            => 'required|integer',
        'form'              => 'required|string',
        'nro'               => 'required|string',
        'bank_id'           => 'required|integer',
        'date_payment'      => 'required|date',
    ]);

    if ($validator->fails()) {
        return $validator;
    }

    return null;
}

protected function validatorType_3($post){

    $validator = Validator::make($post, [
        'type'              => 'required|in:3',
        'year'              => 'required',
        'period_type'       => 'required|in:1,2,3',
        'period'            => 'required|integer',
        'declaration'       => 'required|string',
        'municipality_id'   => 'required|integer',
        'bank_id'           => 'required|integer',
        'date_payment'      => 'required|date',
    ]);

    if ($validator->fails()) {
        return $validator;
    }

    return null;
}
}