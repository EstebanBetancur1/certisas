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
use App\Mail\Alert;

use App\Exports\DocsExport;
use App\Exports\DocsExportAll;

use App\Imports\TemplatesImport;
use Maatwebsite\Excel\Validators\ValidationException;

use PDF;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

class EmissionsController extends Controller
{
    protected $appLayout = "backoffice";
    protected $appName = "backoffice";

    protected $module = "Templates";
    protected $pageTitle = "Plantillas";
    protected $model = "TemplateItem";
    protected $textCreateBtn = "Importar plantillas";

    public function index()
    {               
        $templateItemRepository = Repository("TemplateItem");
        $bankRepository = Repository("Bank");

        $periodsType = [];
        $periods = [];
        $items = [];

        $years = [];
        $now = Carbon::now(config('app.timezone'));
        $yearStart = $now->year;
        $y = 0;

        $providers = [];

        for($i = 6; $i > 0; $i--){
            $years[$yearStart - $y] = $yearStart - $y;
            $y++;
        }

        if((int)request()->input("type") === 1){
            $periodsType["2"] = "Bimestral";
            $periodsType["3"] = "Anual";
        }elseif((int)request()->input("type") === 2){
            $periodsType["1"] = "Mensual";
            $periodsType["3"] = "Anual";
        }elseif((int)request()->input("type") === 3){
            $periodsType["2"] = "Bimestral";
            $periodsType["3"] = "Anual";
        }

        if((int)request()->input("period_type") === 1){
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
        }else if((int)request()->input("period_type") === 2){
            $periods["1"] = "Enero - Febrero";
            $periods["2"] = "Marzo - Abril";
            $periods["3"] = "Mayo - Junio";
            $periods["4"] = "Julio - Agosto";
            $periods["5"] = "Septiembre - Octubre";
            $periods["6"] = "Noviembre - Diciembre";
        }

        $banks = $bankRepository->all();
        $banks = convertToArray($banks, "id", "name");

        $post = request()->all();

        if(request()->input("action") === "emit"){

            $validate = $this->validateEmissionRequest();

            if($validate){
                return back()->with("alert_error", $validate);
            }

            return response()->redirectTo(route("backoffice.emissions.generate", [
                'type'              => request()->input("type"),
                'year'              => request()->input("year"),
                'period_type'       => request()->input("period_type"),
                'period'            => request()->input("period"),
                'date_emission'     => request()->input("date_emission"),
                'city'              => request()->input("city"),
                'provider'          => request()->input("provider"),
            ]));

        }

        $options = [];

        if(request()->input("year") && request()->input("type") && request()->input("period_type")){

            $y = request()->input("year");
            $t = request()->input("type");
            $pt = (int)request()->input("period_type");
            $p = (int)request()->input("period");
            $c = (request()->input("city"))?(int)request()->input("city"):-1;

            $items = $this->getItems($y, $t, $pt, $p, $c);

            $_providers = [];

            foreach($items as $item){
                $_providers[$item->nit] = $item->name;
            }

            $providers = $_providers;

            $options["all"] = "Todos (" . count($providers) . ")";

            $t = 0;

            foreach($providers as $nit => $provider){

                foreach($items as $item){
                    if((int)$item->nit === (int)$nit){
                        $t++;
                    }
                }

                $options[$nit] = "{$provider} ($t)";

                $t = 0;
            }

        }else{

            $items = $templateItemRepository->scopeQuery(function($query){
                $query = $query->where("id", "=", "-1");
                return $query;
            })->all(); 
        }

        $cityRepository = Repository("City");
        $cities = $cityRepository->all();

        $itemsCities = [];

        foreach($cities as $city){
            $itemsCities[$city->id] = "{$city->code} - {$city->name}"; 
        }

        $cities = $itemsCities;

        return view('backoffice.emissions.index', compact("years", "periodsType", "periods", "providers", "options", "banks", "cities"));
    }

    public function sendAlertAll(Request $request) {
        \Log::info('sendAlertAll: Inicio del proceso');
        $successEmailCount = 0;
        $failedEmailCount = 0;

        if (!$request->has('data')) {
            \Log::error('sendAlertAll: La petición no contiene el array "data".');
            return response()->json([
                'status' => 'error',
                'message' => 'No se recibieron los datos necesarios.'
            ]);
        }

        $data = $request->input('data');
        $ids = [];

        foreach ($data as $item) {
            if (isset($item['id'])) {
                $ids[] = $item['id'];
                \Log::info("sendAlertAll: ID recolectado - {$item['id']}");
            }
        }

        if (empty($ids)) {
            \Log::warning('sendAlertAll: No se encontraron IDs para procesar.');
            return response()->json([
                'status' => 'warning',
                'message' => 'No hay IDs para procesar.'
            ]);
        }

        foreach ($ids as $id) {
            try {
                \Log::info("sendAlertAll: Procesando ID - $id");
                $this->sendAlert($id);
                $successEmailCount++;
            } catch (\Exception $e) {
                \Log::error("sendAlertAll: Error al procesar ID $id - " . $e->getMessage());
                $failedEmailCount++;
            }
        }

        if ($failedEmailCount > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Algunas alertas no se pudieron enviar.',
                'successEmailCount' => $successEmailCount,
                'failedEmailCount' => $failedEmailCount,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'successEmailCount' => $successEmailCount,
            'failedEmailCount' => $failedEmailCount,
        ]);
    }


    private function sendEmailAlerts($alerts) {
        try {
            $this->sendAlerts($alerts);
        } catch (\Exception $e) {
            return back()->with("alert_error", "Ocurrio un error al enviar las alertas, por favor intente más tarde.");
        }
    }
    

    public function generate(){
        $templateItemRepository = Repository("TemplateItem");
        $companyRepository = Repository("Company");
        $emissionRepository = Repository("Emission");

        $providers = [];

        $y = request()->input("year");
        $t = request()->input("type");
        $pt = (int)request()->input("period_type");
        $p = (int)request()->input("period");
        $de = request()->input("date_emission");
        $c = request()->input("city");
        $pr = request()->input("provider");
            
        $items = $this->getItems($y, $t, $pt, $p, $c);

        $_companies = [];

        if($pr === "all"){
            foreach($items as $item){
                $hash = sha1(trim($item->concept));
                $providers[$item->nit][$hash][] = $item;
                $_companies[$item->nit] = $item->name;
            }

        }else{

            foreach($items as $item){
                if((string)$pr === (string)$item->nit){
                    $hash = sha1(trim($item->concept));
                    $providers[$item->nit][$hash][] = $item;
                    $_companies[$item->nit] = $item->name;
                }
            }
        }

        // Busca la empresa y si no la encuentra la registra con el nit, nombre y estatus.
        foreach($_companies as $_nit => $_name){
            $_company = $companyRepository->findWhere(["nit" => $_nit])->first();

            if(! $_company){
                $companyRepository->create([
                    'nit'       => $_nit,
                    'name'      => $_name,
                    'status'    => 1,
                ]);
            }
        }

        $emissions = [];
        $agent = getAgent();
        $transactionAmount = 0;
        $taxAmount = 0;
        $amountWithheld = 0;

        $alerts = [];

        foreach($providers as $nit => $concepts){
            $provider = $companyRepository->findWhere(["nit" => $nit])->first();
            $concept = null;

            $transactionAmount = 0;
            $taxAmount = 0;
            $amountWithheld = 0;

            if($provider){

                if($provider->email){
                    $alerts[$provider->nit] = [
                        'name'          => $provider->name,
                        'nit'           => $provider->nit,
                        'email'         => $provider->email,
                        'agent_name'    => $agent->name,
                        'agent_nit'     => $agent->nit,
                    ];
                }

                $conceptsJson = [];
                $months = [];
                $itemsExcel = [];

                $totalTransactionAmount = 0;
                $totalTaxAmount = 0;
                $totalAmountWithheld = 0;

                foreach($concepts as $docs){

                    $concept = null;
                    $transactionAmount = 0;
                    $taxAmount = 0;
                    $amountWithheld = 0;

                    $months = array_replace($months, $this->getMonthshUsed($docs));

                    foreach($docs as $doc){

                        $concept = $doc->concept;
                                
                        $transactionAmount += round(($doc->base/$doc->rate))*100;
                        $taxAmount += $doc->base;
                        $amountWithheld += $doc->tax;

                        $itemsExcel[] = $doc->id;
                    }

                    if($concept){
                        $conceptsJson[] = [
                            'name'              => $concept,
                            'transactionAmount' => $transactionAmount,
                            'taxAmount'         => $taxAmount,
                            'amountWithheld'    => $amountWithheld,
                        ];

                        $totalTransactionAmount += $transactionAmount;
                        $totalTaxAmount         += $taxAmount;
                        $totalAmountWithheld    += $amountWithheld;
                    }
                }
                $numeroFormateado = (int)preg_replace('/[^0-9]/', '', $itemsExcel[0]);

                $emissions[] = [
                    'agent_name'                => $agent->name,
                    'agent_nit'                 => $agent->nit,
                    'agent_dv'                  => $agent->dv,
                    'agent_sectional'           => $agent->sectional,
                    'agent_phone'               => $agent->phone,
                    'agent_city'                => $agent->city,
                    'agent_address'             => $agent->address,

                    'provider_name'             => $provider->name,
                    'provider_nit'              => $provider->nit,
                    'provider_dv'               => $provider->dv,
                    'provider_sectional'        => $provider->sectional,
                    'provider_phone'            => $provider->phone,
                    'provider_city'             => $provider->city,
                    'provider_address'          => $provider->address,

                    'date_emission'             => $de,

                    'concepts'                  => json_encode($conceptsJson),
                  
                    'docs'                      => json_encode($numeroFormateado),

                    'months'                    => implode(",", $months),
                    'year'                      => request()->input("year"),
                    'type'                      => request()->input("type"),
                    'period_type'               => request()->input("period_type"),
                    'period'                    => ((string)request()->input("period") === "all")?-1:request()->input("period", -1),
                    'total_transaction_amount'  => $totalTransactionAmount,
                    'total_tax_amount'          => $totalTaxAmount,
                    'total_amount_withheld'     => $totalAmountWithheld,

                    'company_id'                => $agent->id,
                    'provider_id'               => $provider->id,
                    'city_id'                   => ((int)$t === 3)?$c:null,

                    'status'                    => 1,
                    'user_id'                   => auth()->user()->id,
                ];
            }                    
        } 

    
        $insertedCount = 0;
        $rejectedCount = 0;

        foreach($emissions as $emission){
            $existingEmission = $emissionRepository->findWhere([
                'provider_id'   => $emission['provider_id'],
                'type'          => $emission['type'],
                'period_type'   => $emission['period_type'],
                'period'        => $emission['period'],
                'year'          => $emission['year'],
            ])->first();

            if (!$existingEmission) {
                $emissionRepository->create($emission);
                $insertedCount++;
            } else {
                $rejectedCount++;
            }
        }

        $this->sendEmailAlerts($alerts);
    
        $successMessage = "La generación de emisiones se completó exitosamente. ";
        $successMessage .= "Se han insertado un total de $insertedCount líneas. ";
        $successMessage .= "No se insertaron $rejectedCount líneas, ya que estas ya existían previamente en el sistema.";
        
    
        return response()->redirectTo(route('backoffice.emissions.processed'))->with("alert_success", $successMessage);
    }

    public function processed(){

        $templateItemRepository = Repository("TemplateItem");
        $cityRepository = Repository("City");
        $emissionRepository = Repository("Emission");

        $periods = [];
        $items = [];

        $years = [];
        $now = Carbon::now(config('app.timezone'));
        $yearStart = $now->year;
        $y = 0;

        for($i = 6; $i > 0; $i--){
            $years[$yearStart - $y] = $yearStart - $y;
            $y++;
        }

        if((int)request()->input("period_type") === 1){
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
        }else if((int)request()->input("period_type") === 2){
            $periods["1"] = "Enero - Febrero";
            $periods["2"] = "Marzo - Abril";
            $periods["3"] = "Mayo - Junio";
            $periods["4"] = "Julio - Agosto";
            $periods["5"] = "Septiembre - Octubre";
            $periods["6"] = "Noviembre - Diciembre";
        }

        $where = [
            ["company_id", "=", session("companyID")]
        ];

        if(request()->input("type")  || request()->input("year") || request()->input("city")){

            if(request()->input("type")){
                $where[] = ["type", "=", request()->input("type")];
            }

            if(request()->input("year")){
                $where[] = ["year", "=", request()->input("year")];
            }

            if(request()->input("city")){
                $where[] = ["city_id", "=", request()->input("city")];
            }
            
            $items = $emissionRepository->findWhere($where);
        }else{
            $items = $emissionRepository->findWhere(["id" => -1]);
        }

        // Obtiene las ciudades segun las emisiones
        $cities = [];
        $citiesIDs = [];

        $its = $templateItemRepository->scopeQuery(function($query){
            return $query->where("company_id", "=", session("companyID"))->where("type", 3);
        })->all(); 

        foreach($its as $it){
            if((int)$it->city_id){
                $citiesIDs[$it->city_id] = $it->city_id;
            }
        }

        $_cities = $cityRepository->findWhereIn("id", $citiesIDs);

        foreach($_cities as $_city){
            $cities[$_city->id] = "{$_city->code} - {$_city->name}";
        }
        
        return view('backoffice.emissions.processed', compact("years", "periods", "items", "cities"));    
    }

    public function comboPeriodType(){
        $option = (int)request()->input("o", 0);

        $html = "empty";
        
        if($option === 1){
            $html .= "<option value=''>- Seleccione</option>";
            $html .= "<option value='2'>Bimestral</option>";
            $html .= "<option value='3'>Anual</option>";
        }elseif($option === 2){
            $html .= "<option value=''>- Seleccione</option>";
            $html .= "<option value='1'>Mensual</option>";
            $html .= "<option value='3'>Anual</option>";
        }elseif($option === 3){
            $html .= "<option value=''>- Seleccione</option>";
            $html .= "<option value='2'>Bimestral</option>";
            $html .= "<option value='3'>Anual</option>";
        }

        return response()->json(["status" => "ok", "html" => $html]);
    }

    public function combo(){
        $option = (int)request()->input("o", 0);

        $html = "empty";
        
        if($option === 1){
            $html .= "<option value='1'>Enero</option>";
            $html .= "<option value='2'>Febrero</option>";
            $html .= "<option value='3'>Marzo</option>";
            $html .= "<option value='4'>Abril</option>";
            $html .= "<option value='5'>Mayo</option>";
            $html .= "<option value='6'>Junio</option>";
            $html .= "<option value='7'>Julio</option>";
            $html .= "<option value='8'>Agosto</option>";
            $html .= "<option value='9'>Septiembre</option>";
            $html .= "<option value='10'>Octubre</option>";
            $html .= "<option value='11'>Noviembre</option>";
            $html .= "<option value='12'>Diciembre</option>";
        }elseif($option === 2){
            $html .= "<option value='1'>Enero - Febrero</option>";
            $html .= "<option value='2'>Marzo - Abril</option>";
            $html .= "<option value='3'>Mayo - Junio</option>";
            $html .= "<option value='4'>Julio - Agosto</option>";
            $html .= "<option value='5'>Septiembre - Octubre</option>";
            $html .= "<option value='6'>Noviembre - Diciembre</option>";
        }elseif($option === 3){
            $html .= "<option value='all'>Enero a Diciembre</option>";
        }

        return response()->json(["status" => "ok", "html" => $html]);
    }

    public function declaration($id){

        $emissionRepository = Repository("Emission");
        $declarationsRepository = Repository("Declaration");

        $emission = $emissionRepository->find($id);

        if($emission->type === 3){

            $declarations = $declarationsRepository->scopeQuery(function($query) use ($emission){

                $query = $query->where("type",         "=", $emission->type);
                $query = $query->where("status",       "=", 1);
                // $query = $query->where("company_id",   "=", session("companyID"));

                $query = $query->where(function ($query) use ($emission) {
                   $query->where('period', '=', $emission->period)->orWhere('period', '=', '-1');
               });

                return $query;
                
            })->get();

        }else{

            $declarations = $declarationsRepository->scopeQuery(function($query) use ($emission){

                $query = $query->where("type",         "=", $emission->type);
                $query = $query->where("status",       "=", 1);
                // $query = $query->where("company_id",   "=", session("companyID"));

                $months = explode(",", $emission->months);

                $query = $query->whereIn("period", $months);

                return $query;
                
            })->get();
        }

        // dd($declarations);

        return PDF::loadView('backoffice.emissions.declaration', [
            'emission'          => $emission,
            'declarations'      => $declarations
        ])->stream('declaracion.pdf');
    }

    public function sendAlert($id){
        $emissionRepository = Repository("Emission");

        $emission = $emissionRepository->find($id);

        

        $quienrecibe = $emission->provider->id;

        $resultado = DB::table('company_users')
            ->join('users', 'company_users.user_id', '=', 'users.id')
            ->where('company_users.company_id', $quienrecibe)
            ->select('users.email')
            ->get();

        $email = $resultado->pluck('email')->first();


        if($emission){
        
            if($emission->provider && $email){
                try {
                    Mail::to($email)->send(new Alert([
                        'name'          => $emission->provider->name,
                        'nit'           => $emission->provider->nit,
                        'email'         => $emission->provider->email,
                        'agent_name'    => $emission->agent_name,
                        'agent_nit'     => $emission->agent_nit,
                    ]));
                } catch (\Exception $e) {
                    return back()->with("alert_error", "Ocurrio un error al enviar la alerta, por favor intente más tarde.");
                }
            }
        }

        return back()->with("alert_success", "La alerta ha sido enviada con éxito");
    }

    public function myCertificates(){

        $emissionRepository = Repository("Emission");
        $cityRepository = Repository("City");

        $periods = [];
        $items = [];

        $years = [];
        $now = Carbon::now(config('app.timezone'));
        $yearStart = $now->year;
        $y = 0;

        for($i = 6; $i > 0; $i--){
            $years[$yearStart - $y] = $yearStart - $y;
            $y++;
        }

        if((int)request()->input("period_type") === 1){
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
        }else if((int)request()->input("period_type") === 2){
            $periods["1"] = "Enero - Febrero";
            $periods["2"] = "Marzo - Abril";
            $periods["3"] = "Mayo - Junio";
            $periods["4"] = "Julio - Agosto";
            $periods["5"] = "Septiembre - Octubre";
            $periods["6"] = "Noviembre - Diciembre";
        }

        $where = [
            ["provider_id", "=", session("companyID")]
        ];

        $emissions = [];

        if(request()->input("type")  || request()->input("year") || request()->input("city")){

            if(request()->input("type")){
                $where[] = ["type", "=", request()->input("type")];
            }

            if(request()->input("year")){
                $where[] = ["year", "=", request()->input("year")];
            }

            if(request()->input("city")){
                $where[] = ["city_id", "=", request()->input("city")];
            }
            
            $items = $emissionRepository->findWhere($where);

            foreach($items as $item){
                $emissions[$item->id] = $item->id;
            }    

        }else{
            $items = $emissionRepository->findWhere(["id" => -1]);
        }

        // Obtiene las ciudades segun las emisiones
        $cities = [];
        $citiesIDs = [];

        $its = $emissionRepository->scopeQuery(function($query){
            return $query->where("provider_id", "=", session("companyID"))->where("type", 3);
        })->all(); 

        foreach($its as $it){
            if((int)$it->city_id){
                $citiesIDs[$it->city_id] = $it->city_id;
            }
        }

        $_cities = $cityRepository->findWhereIn("id", $citiesIDs);

        foreach($_cities as $_city){
            $cities[$_city->id] = "{$_city->code} - {$_city->name}";
        }

        return view('backoffice.emissions.my_certificates', compact("years", "periods", "items", "cities", "emissions")); 
    }

    public function myCertificatesExport($id){

        $emissionRepository = repository("Emission");

        $emission = $emissionRepository->find($id);

        $docs = json_decode($emission->docs, true);
        
        return Excel::download(new DocsExport((array) $docs, $emission), 'detalle.xlsx');
    }

    public function myCertificatesExportAll(){
        $emissions = request()->input("emissions");
        $repository = repository("TemplateItem");

        $rows = [];

        $emissionRepository = repository("Emission");

        $emissions = $emissionRepository->findWhereIn("id", json_decode($emissions, true));

        foreach($emissions as $emission){
            $ids = json_decode($emission->docs, true);

            $docs = $repository->findWhereIn("id", $ids);

            foreach($docs as $doc){
                $rows[] = [
                    'agent_name'        => $emission->agent_name,
                    'agent_nit'         => $emission->agent_nit,
                    'provider_name'     => $emission->provider_name,
                    'provider_nit'      => $emission->provider_nit,
                    'doc'               => $doc->doc,
                    'date'              => $doc->date,
                    'base'              => $doc->base,
                    'tax'               => $doc->tax,
                    'rate'              => $doc->rate,
                    'year_process'      => $doc->year_process,
                    'period_process'    => $doc->period_process,
                    'concept'           => $doc->concept,
                ];
            }
        }

        return Excel::download(new DocsExportAll($rows), 'detalle.xlsx');
    }

    protected function getItems($year, $type, $periodType, $period, $city = -1){

        $templateItemRepository = Repository("TemplateItem");

        $items = $templateItemRepository->scopeQuery(function($query) use ($year, $type, $periodType, $period, $city){

            $query = $query->where("year_process",      "=", $year);
            $query = $query->where("type",              "=", $type);
            $query = $query->where("company_id",        "=", session("companyID"));

            if((int)$type === 3 && $city !== -1){
                $query = $query->where("city_id",        "=", $city);
            }

            if($periodType === 1){ // Mensual

                $query->where('period_process', $period);

            }elseif($periodType === 2){ // Bimestral

                // Busca registros con periodos bimestrales
                $query = $query->where("period_type", "=", 2);

                if($period === 1){ // Enero - Febrero

                    // Busca el bimestre
                    $query = $query->where("period_process", "=", 1);

                    // Busca los meses que conforma el bimestre
                    $queryOther = DB::table('template_items');

                    $queryOther = $queryOther->where("year_process",      "=", $year);
                    $queryOther = $queryOther->where("type",              "=", $type);
                    $queryOther = $queryOther->where("company_id",         "=", session("companyID"));
                    $queryOther = $queryOther->where("period_type",       "=", 1);

                    if((int)$type === 3){
                        $queryOther = $queryOther->where("city_id",       "=", $city);
                    }

                    $queryOther = $queryOther->where(function($query) {
                                        $query->where('period_process', 1)->orWhere('period_process', 2);
                                    });

                    $query->union($queryOther);

                }else if($period === 2){ // Marzo - Abril

                    $query = $query->where("period_process", "=", 2);

                    // Busca los meses que conforma el bimestre
                    $queryOther = DB::table('template_items');

                    $queryOther = $queryOther->where("year_process",      "=", $year);
                    $queryOther = $queryOther->where("type",              "=", $type);
                    $queryOther = $queryOther->where("company_id",         "=", session("companyID"));
                    $queryOther = $queryOther->where("period_type",       "=", 1);

                    if((int)$type === 3){
                        $queryOther = $queryOther->where("city_id",       "=", $city);
                    }

                    $queryOther = $queryOther->where(function($query) {
                                        $query->where('period_process', 3)->orWhere('period_process', 4);
                                    });

                    $query->union($queryOther);

                }else if($period === 3){ // Mayo - Junio

                    $query = $query->where("period_process", "=", 3);

                    // Busca los meses que conforma el bimestre
                    $queryOther = DB::table('template_items');

                    $queryOther = $queryOther->where("year_process",      "=", $year);
                    $queryOther = $queryOther->where("type",              "=", $type);
                    $queryOther = $queryOther->where("company_id",         "=", session("companyID"));
                    $queryOther = $queryOther->where("period_type",       "=", 1);

                    if((int)$type === 3){
                        $queryOther = $queryOther->where("city_id",       "=", $city);
                    }

                    $queryOther = $queryOther->where(function($query) {
                        $query->where('period_process', 5)->orWhere('period_process', 6);
                    });

                    $query->union($queryOther);

                }else if($period === 4){ // Junio - Agosto

                    $query = $query->where("period_process", "=", 4);

                    // Busca los meses que conforma el bimestre
                    $queryOther = DB::table('template_items');

                    $queryOther = $queryOther->where("year_process",      "=", $year);
                    $queryOther = $queryOther->where("type",              "=", $type);
                    $queryOther = $queryOther->where("company_id",         "=", session("companyID"));
                    $queryOther = $queryOther->where("period_type",       "=", 1);

                    if((int)$type === 3){
                        $queryOther = $queryOther->where("city_id",       "=", $city);
                    }

                    $queryOther = $queryOther->where(function($query) {
                                        $query->where('period_process', 7)->orWhere('period_process', 8);
                                    });

                    $query->union($queryOther);

                }else if($period === 5){ // Septiembre - Octubre

                    $query = $query->where("period_process", "=", 5);

                    // Busca los meses que conforma el bimestre
                    $queryOther = DB::table('template_items');

                    $queryOther = $queryOther->where("year_process",      "=", $year);
                    $queryOther = $queryOther->where("type",              "=", $type);
                    $queryOther = $queryOther->where("company_id",         "=", session("companyID"));
                    $queryOther = $queryOther->where("period_type",       "=", 1);

                    if((int)$type === 3){
                        $queryOther = $queryOther->where("city_id",       "=", $city);
                    }

                    $queryOther = $queryOther->where(function($query) {
                                        $query->where('period_process', 9)->orWhere('period_process', 10);
                                    });

                    $query->union($queryOther);


                }else if($period === 6){ // Noviembre -  Diciembre

                    $query = $query->where("period_process", "=", 6);

                    // Busca los meses que conforma el bimestre
                    $queryOther = DB::table('template_items');

                    $queryOther = $queryOther->where("year_process",      "=", $year);
                    $queryOther = $queryOther->where("type",              "=", $type);
                    $queryOther = $queryOther->where("company_id",         "=", session("companyID"));
                    $queryOther = $queryOther->where("period_type",       "=", 1);

                    if((int)$type === 3){
                        $queryOther = $queryOther->where("city_id",       "=", $city);
                    }

                    $queryOther = $queryOther->where(function($query) {
                                        $query->where('period_process', 11)->orWhere('period_process', 12);
                                    });

                    $query->union($queryOther);
                }

            }elseif($periodType === 3){ // Anual

                $query = $query->whereBetween('period_process', [1, 12]);

            }   

            return $query;

        })->all();

        return $items;
    }

    private function getMonthshUsed($items){

        $months = [];

        foreach($items as $item){
            if((int)$item->period_type === 1){

                $months[$item->period_process] = $item->period_process;

            }else if((int)$item->period_type === 2){

                if($item->period_process === 1){ // Enero - Febrero

                    $months[1] = 1;
                    $months[2] = 2;

                }else if($item->period_process === 2){ // Marzo - Abril

                    $months[3] = 3;
                    $months[4] = 4;

                }else if($item->period_process === 3){ // Mayo - Junio

                    $months[5] = 5;
                    $months[6] = 6;

                }else if($item->period_process === 4){ // Junio - Agosto

                    $months[7] = 7;
                    $months[8] = 8;

                }else if($item->period_process === 5){ // Septiembre - Octubre

                    $months[9] = 9;
                    $months[10] = 10;


                }else if($item->period_process === 6){ // Noviembre -  Diciembre

                    $months[11] = 11;
                    $months[12] = 12;
                }

            }else if((int)$item->period_type === 3){
                $months[1] = 1;
                $months[2] = 2;
                $months[3] = 3;
                $months[4] = 4;
                $months[5] = 5;
                $months[6] = 6;
                $months[7] = 7;
                $months[8] = 8;
                $months[9] = 9;
                $months[10] = 10;
                $months[12] = 12;
            }
        }

        return $months;
    }

    private function validateEmissionRequest(){

        if(! request()->input("year")){
            return "El año es obligatorio";
        }

        if(! request()->input("type")){
            return "El tipo de impuesto es obligatorio";
        }

        if(! request()->input("period_type")){
            return "El tipo de per&iacute;odo es obligatorio";
        }

        if(! request()->input("period")){
            //return "El per&iacute;odo es obligatorio";
        }

        if((int)request()->input("type") === 3 && ! request()->input("city")){
            return "La ciudad es obligatoria para el impuesto seleccionado.";
        }

        if(! request()->input("date_emission")){
            return "La Fecha de emisi&oacute;n es obligatoria.";
        }

        return null;
    }

    private function sendAlerts($providers){

        foreach($providers as $provider){
            //Mail::to($provider["email"])->send(new Alert($provider));
            Mail::to("analista@saascolombia.com")->send(new Alert($provider));
        }
    }
}