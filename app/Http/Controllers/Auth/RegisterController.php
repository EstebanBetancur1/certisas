<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\Welcome;
use App\Mail\NewCompany;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Smalot\PdfParser\Parser;
use function Composer\Autoload\includeFile;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $userRepository = null;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $loginAfterCreate = false;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    protected $allowedTypesRegularExpression = '/(\.pdf)$/';
    protected $allowedTypes = ['pdf'];
    protected $pathUpload = "rut";

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->middleware('guest');

        $this->userRepository = $userRepository;
    }

    function requestAccess(){
        $post = request()->all();

        $user = $this->userRepository->findWhere(["email" => $post["email"]])->first();
        $company = Company::where("nit", $post["nit"])->first();

        if($user){
            return new JsonResponse(['error' => __('Ya existe un usuario registrado con este correo.')]);
        }

        if(!$company){
            return new JsonResponse(['error' => __('Empresa no encontrada.')]);
        }

        $user = $this->userRepository->create([
            'full_name'         => '',
            'email'             => $post['email'],
            'password'          => '',
            'phone'             => '',
            'status'            => 2,
            'type'              => 1,
            'email_token'           => sha1(datetimeToken()),
            'email_token_created'   => datetimeFormat(null),
        ]);

        if($user){
            try {
                Mail::to($post["email"])->send(new \App\Mail\RequestAccess($user, $company));
                return new JsonResponse(['success' => __('Se ha enviado un correo con los pasos a seguir.')]);
            } catch (\Exception $e) {
                $user->delete();
                return new JsonResponse(['error' => __('Tu correo no existe o esta mal escrito, porfavor verifica.')]);
            }
        }





    }
    

    public function register(RegisterRequest $request) {
        $file = $request->rut;
        $upload = $this->uploadFile($file);
    
        if (is_array($upload)) {
            $parser = new Parser();
            $data = parsePdf($parser->parseFile($upload['preview'])->getText());
    
            if (array_key_exists("nit", $data) && $data["nit"]) {
                $requestRepository = repository("Request");
                $companyRepository = Repository("Company");
    
                $company = $companyRepository->findWhere(["nit" => $data["nit"]])->first();
                $requestCompany = $requestRepository->findWhere(["nit" => $data["nit"]])->first();
    
                if ($company) {
                    unlink($upload['preview']);
                    throw ValidationException::withMessages(['rut' => __('We already have a registered company/user with uploaded document data.')]);
                } else if ($requestCompany) {
                    unlink($upload['preview']);
                    throw ValidationException::withMessages(['rut' => __('We already have a registration request with this document data.')]);
                }
    
                try {
                    $instance = $requestRepository->create([
                        'nit'               => $data["nit"],
                        'dv'                => $data["dv"],
                        'sectional'         => $data["sectional"],
                        'type'              => $data["type"],
                        'name'              => $data["name"],
                        'city'              => $data["city"],
                        'address'           => $data["address"],
                        'email'             => $data["email"],
                        'email_user'        => $request->email,
                        'phone'             => $data["phone"],
                        'activities'        => $data["activities"],
                        'responsibilities'  => $data["responsibilities"],
                        'file'              => $upload['name'],
                        'date'              => $data["date"],
                        'status'            => 0,
                        'email_status'      => 0,
                        'token'             => sha1(datetimeToken())
                    ]);
    
                    if ($instance) {
                        try {
                            Mail::to(setting('email_notification'))->send(new NewCompany($instance));
                            Mail::to($request->email)->send(new Welcome($request->all(), $instance));
                            return new JsonResponse(['success' => __('You have successfully registered.')]);
                        } catch (\Exception $e) {
                            $instance->delete();
                            unlink($upload['preview']);
                            return new JsonResponse(['error' => __('Tu correo no existe o esta mal escrito, porfavor verifica.')]);
                        }
                    } else {
                        unlink($upload['preview']);
                        // Manejar error al crear la instancia en la base de datos
                        return new JsonResponse(['error' => __('An error has occurred while creating the record.')]);
                    }
                } catch (\Exception $e) {
                    unlink($upload['preview']);
                    // Manejar error en la creación de la instancia en la base de datos
                    return new JsonResponse(['error' => __('An error has occurred while creating the record.')]);
                }
            } else {
                unlink($upload['preview']);
                return new JsonResponse(['error' => __('Invalid document, please upload the correct file.')]);
            }
        } else {
            // Manejar error en la carga del archivo
            return new JsonResponse(['rut' => __('validation.uploaded'), ['attribute' => 'rut']]);
        }
    }
    

    public function registerRequest(){

        $companyRepository = Repository("Company");

        $company = $companyRepository->findWhere(["id" => session("ID")])->first();

        if(! $company){
            return back()->with("alert_error", "Empresa no encontrada, por favor intente nuevamente.");
        }

        return view("auth.request_register", compact("company"));
    }

    public function registerRequestCreate(){
        $post = request()->all();

        $this->validatorRegisterRequest($post)->validate();

        $companyRepository = Repository("Company");
        $userRepository = Repository("User");
        $companyUserRepository = Repository("CompanyUser");

        $company = $companyRepository->findWhere(["id" => $post["company_id"]])->first();

        if(! $company){
            return back()->with("alert_error", "Empresa no encontrada, por favor intente nuevamente.");
        }

        $user = $userRepository->create([
            'full_name'     => $post["full_name"],
            'email'         => $post["email"],
            'phone'         => $post["phone"],
            'password'      => bcrypt($post["password"]),
            'type'          => 1,
            'status'        => 1,
        ]);

        if($user){
            $instance = $companyUserRepository->create([
                'user_id'       => $user->id,
                'company_id'    => $company->id,
                'type'          => 0,
                'status'        => 0,
            ]);

            if($instance){

                $mainUser = $companyUserRepository->findWhere([
                    'company_id'    => $company->id,
                    'type'          => 1,
                    'status'        => 1,
                ])->first();

                if($mainUser){
                    Mail::to($mainUser->user->email)->send(new \App\Mail\RegisterRequest($user, $company));
                    Mail::to(setting('email_notification'))->send(new \App\Mail\RegisterRequest($user, $company));
                }

                return response()->redirectTo(route("auth.request.register.finish"))->with("status_finish", "ok");
            }
        }

        return back()->with("ID", $post["company_id"])->with("alert_error", "Empresa no encontrada, por favor intente más tarde.");
    }

    public function requestEmailConfirmation(){
        $token = request()->input("token");

        $requestRepository = Repository("Request");

        $item = $requestRepository->findWhere(["token" => $token])->first();

        if($item){
            $item->token = null;
            $item->email_status = 1;
            $item->save();

            return response()->redirectTo(route("frontoffice.home.index"))->with("alert_success", "Su cuenta de correo fue validada correctamente.");
        }

        return back()->with("alert_error", "El token no es v&aacute;lido, por favor intente nuevamente");
    }

    public function registerRequestFinish(){
        return view("auth.register_request_finish", compact("item"));
    }

    public function completeRegister($token){

        $userRepository = Repository("User");

        $item = $userRepository->findWhere(["token_pre_register" => $token])->first();

        if(! $item){
            abort(404);
        }

        return view("auth.complete_register", compact("item"));
    }

    public function completeRegisterUpdate($token){
        $post = request()->all();

        $userRepository = Repository("User");

        $item = $userRepository->findWhere(["token_pre_register" => $token])->first();

        if(! $item){
            abort(404);
        }

        $this->validatorCompleteRegister($post)->validate();

        $item->full_name = $post["full_name"];
        $item->phone = $post["phone"];
        $item->password = bcrypt($post["password"]);
        $item->save();

        return response()->redirectTo(route("auth.user.login.show"));
    }

    public function emailConfirmation($token){

        $user = $this->userRepository->findWhere(["status"=>2, "email_token" => $token])->first();

        $result = [
            'status'    => "ok",
            'message'   => "Su cuenta de correo ha sido confirmada con &eacute;xito",
        ];

        if($user){

            $dt = Carbon::now(config('app.timezone'));
            $at = Carbon::instance(new \DateTime($user->email_token_created, new \DateTimeZone(config('app.timezone'))));

            // Si es mayor a 12 horas
            if($dt->diffInHours($at) > 12){

                $result = [
                    'status'    => "failed",
                    'message'   => "Su enlace ha expirado",
                ];

                return view('auth.email_confirmation', compact("result"));
            }

            try {
                $user->status = 1;
                $user->email_token = null;
                $user->email_confirmed = 1;
                $user->email_token_created = null;
                $user->save();
            } catch (\Exception $e) {
                $result = [
                    'status'    => "failed",
                    'message'   => "Ocurrio un error, por favor intente m&aacute;s tarde",
                ];
            }
        }else{
            $result = [
                'status'    => "failed",
                'message'   => "El token no es v&aacute;lido, por favor intente nuevamente",
            ];
        }

        return view('auth.email_confirmation', compact("result"));
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'email'     => 'required|string|email|max:255|unique:users',
            'terms'     => 'required|in:1',
        ]);
    }

    protected function validatorCompleteRegister(array $data){
        return Validator::make($data, [
            'full_name' => 'required|string',
            'phone'     => 'required|numeric',
            'password'  => 'required|string|min:6|confirmed',
            'terms'     => 'required|in:1',
        ]);
    }

    protected function validatorRegisterRequest(array $data){
        return Validator::make($data, [
            'full_name'     => 'required|string',
            'email'         => 'required|email',
            'phone'         => 'required|numeric',
            'company_id'    => 'required|integer',
            'password'      => 'required|string|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data){
        return User::create([
            'full_name'         => $data['full_name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'status'            => 2,
            'type'              => 1,
            'email_token'           => sha1(datetimeToken()),
            'email_token_created'   => datetimeFormat(null),
        ]);
    }

    private function uploadFile($file){
        $originalName = $file->getClientOriginalName();
        // Sustituye todo lo que no sea alfanumerico por guion
        $newName = preg_replace('/[^\.a-zA-Z0-9]+/', '-', strtolower($originalName));
        $newName = preg_replace('/[^0-9]+/', '', Carbon::now()->format('Y-m-d H:i:s')).'-'.$newName;

        $pathAbsolute = public_path().'/'.config('app.uploads_dir','upload').'/'.$this->pathUpload;

        $file->move($pathAbsolute,$newName);

        $url = config('app.uploads_dir','upload').'/'.$this->pathUpload.'/'.$newName;
        if (file_exists($url)) {
            return [
                'status' => true,
                'preview' => $url,
                'path'    => $this->pathUpload,
                'name'    => $newName
            ];
        }
        return false;
    }

    private function destroyFile($image){
        $p = explode("/", $image);

        if(is_array($p)){
            $image = $p[count($p)-1];
        }

        $public_path = public_path();
        $pathAbsolute = $public_path.'/upload/'.$this->pathUpload;

        if(is_file($pathAbsolute.'/'.$image)){
            unlink($pathAbsolute.'/'.$image);
        }
    }

     
}
