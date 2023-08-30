<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\UpdateMyAccountRequest;
use App\Repositories\UserRepository;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Image;

class AccountController extends Controller
{
    
    private $userRepository;

    protected $allowed_types_regular_expression = '/(\.jpg|\.jpeg|\.png)$/';
    protected $allowed_types = [ 'jpg', 'jpeg', 'png' ];
    protected $path = 'users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backoffice.accounts.index');
    }

    public function myAccount()
    {
        $user = auth()->user();

        $image = ($user->image) ? $user->image : null;

        return view('backoffice.accounts.myAccount', compact("image"));
    }

    public function UpdateMyAccount(UpdateMyAccountRequest $request)
    {
        $data = $request->validated();

        if(isset($data['password']) && !empty($data['password']))
        {
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        $user = auth()->user();

        $user->fill($data);

        $user->update();
        
        if(count(request()->allFiles()) > 0)
        {
            $upload = $this->uploadImage();
            $image = $user->image;

            if(is_array($upload)){
                if($upload['status']){
                    $user->image = $upload['name'];
                }else{

                    request()->session()->flash('alert_error', $upload['message']);

                    return redirect()->back();
                }

                $user->save();
            }

            $this->destroyFile($image);
        }

        request()->session()->flash('alert_success', "Perfil actualizado con exito!");

        return redirect()->back();
    }

    private function uploadImage($field = 'image')
    {
        $public_path = public_path();

        $allowed_types = $this->allowed_types;
        $max_size = config('app.max_size_image');

        Storage::disk('upload')->makeDirectory($this->path);

        $files = request()->allFiles();

        if(count($files) == 0){
            return null;
        }

        $UploadedFile = (array_key_exists($field, $files)) ? $files[$field] : [ ];

        if ($UploadedFile && $UploadedFile instanceof UploadedFile) {

            $originalName = $UploadedFile->getClientOriginalName();
            $extension = strtolower($UploadedFile->getClientOriginalExtension());
            // $size = $UploadedFile->getClientSize();

            if ( ! in_array($extension, $allowed_types)) {
                return [
                    'status' => false,
                    'message' => 'El tipo de archivo seleccinado no es v&aacute;lido.'
                ];
            }

            // if ($size > (int) $max_size * 1024) {
            //     return [
            //         'status' => false,
            //         'message' => 'La imagen no puede ser mayor a ('.$max_size.')Kb.'
            //     ];
            // }

            // Sustituye todo lo que no sea alfanumerico por guion
            $newName = preg_replace('/[^\.a-zA-Z0-9]+/', '-', strtolower($originalName));
            $newName = preg_replace('/[^0-9]+/', '', Carbon::now()->format('Y-m-d H:i:s')).'-'.$newName;

            $pathAbsolute = $public_path.'/upload/'.$this->path;

            try {
                $target = $UploadedFile->move($pathAbsolute, $newName);
            } catch (\Exception $e) {
                return [
                    'status' => false,
                    'message' => 'Ocurrio un error al cargar la imagen, por favor intente nuevamente'
                ];
            }

            if ($target) {
                return [
                    'status' => true,
                    'preview' => config('app.base_url').'/upload/'.$this->path.'/'.$newName,
                    'path'    => $this->path,
                    'name'    => $newName
                ];
            }
        }

        return [
            'status' => false,
            'message' => 'Ocurrio un error, por favor intente mas tarde.'
        ];
    }

    private function destroyFile($image){
        $public_path = public_path();
        $pathAbsolute = $public_path.'/upload/'.$this->path;

        if(is_file($pathAbsolute.'/'.$image)){
            unlink($pathAbsolute.'/'.$image);
        }
    }
}
