<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use Carbon\Carbon; 

trait CrudTrait
{
	protected $_appLayout = "backoffice";
	protected $_appName = "backoffice";

	protected $_pageTitle = "M&oacute;dulo";
	protected $_module = "default";
	protected $_pathModel = "App\Models";
    protected $_pathRepositories = "App\Repositories";

    protected $_textCreateBtn = "Nuevo";

    protected $_defaultFirstSegment = "default";
	protected $_defaultSecondSegment = "crud";

	protected $_allowEdit = true;
	protected $_allowDelete = true;
	protected $_allowCreate = true;

    protected $_allowedTypesRegularExpression = '/(\.jpg|\.jpeg|\.png)$/';
    protected $_allowedTypes = ['jpg', 'jpeg', 'png'];
    protected $_pathUpload = null;

	protected $_model = null;

    protected $_fields = [
        'title' => 'T&iacute;tulo',
        'status' => 'Estado'
    ];

    protected $_statusOptions = [
        0 => 'Inactivo',
        1 => 'Activo'
    ];

	private $classModel = null;
	private $classRepository = null;
	private $repository = null;
    private $views = null;

	private $hasFiles = false;

	public function __construct() {

		$this->pageTitle 			= (! isset($this->pageTitle))?$this->_pageTitle:$this->pageTitle;
		$this->module 				= (! isset($this->module))?Str::camel($this->_module):Str::camel($this->module);
    	
		$this->allowEdit 			= (! isset($this->allowEdit))?$this->_allowEdit:$this->allowEdit;
		$this->allowDelete 			= (! isset($this->allowDelete))?$this->_allowDelete:$this->allowDelete;
		$this->allowCreate 			= (! isset($this->allowCreate))?$this->_allowCreate:$this->allowCreate;

		$this->pathModel 			= (! isset($this->pathModel))?$this->_pathModel:$this->pathModel;
		$this->pathRepositories 	= (! isset($this->pathRepositories))?$this->_pathRepositories:$this->pathRepositories;
		$this->appName 		        = (! isset($this->appName))?$this->_appName:$this->appName;
        $this->appLayout            = (! isset($this->appLayout))?$this->_appLayout:$this->appLayout;

        $this->fields               = (! isset($this->fields))?$this->_fields:$this->fields;
        $this->fileFields           = (! isset($this->fileFields))?[]:$this->fileFields;
        $this->statusOptions        = (! isset($this->statusOptions))?$this->_statusOptions:$this->statusOptions;

        $this->defaultFirstSegment  = (! isset($this->defaultFirstSegment))?$this->_defaultFirstSegment:$this->defaultFirstSegment;
        $this->defaultSecondSegment = (! isset($this->defaultSecondSegment))?$this->_defaultSecondSegment:$this->defaultSecondSegment;

		$this->textCreateBtn        = (! isset($this->textCreateBtn))?$this->_textCreateBtn:$this->textCreateBtn;

        $this->model                = (! isset($this->model))?$this->_model:$this->model;

        $this->allowedTypesRegularExpression    = (! isset($this->allowedTypesRegularExpression))?$this->_allowedTypesRegularExpression:$this->allowedTypesRegularExpression;
        $this->allowedTypes                     = (! isset($this->allowedTypes))?$this->_allowedTypes:$this->allowedTypes;
		$this->pathUpload 				        = (! isset($this->pathUpload))?$this->module:$this->pathUpload;

        // ProductItem => product_item_
        $this->views                = Str::snake($this->module);

        if(is_array($this->fileFields) && count($this->fileFields)){
            $this->hasFiles = true;
        }

	    view()->share('pageTitle'      , $this->pageTitle);

	    view()->share('routeIndex'     , "{$this->appName}.{$this->module}.index");
	    view()->share('routeCreate'    , "{$this->appName}.{$this->module}.create");
	    view()->share('routeStore'     , "{$this->appName}.{$this->module}.store");
	    view()->share('routeEdit'      , "{$this->appName}.{$this->module}.edit");
	    view()->share('routeUpdate'    , "{$this->appName}.{$this->module}.update");
	    view()->share('routeDestroy'   , "{$this->appName}.{$this->module}.destroy");
	    view()->share('routeStatus'    , "{$this->appName}.{$this->module}.status");

        view()->share('appName'        , $this->appName);
	    view()->share('appLayout'      , $this->appLayout);
	    
	    view()->share('allowEdit'      , $this->allowEdit);
	    view()->share('allowDelete'    , $this->allowDelete);
	    view()->share('allowCreate'    , $this->allowCreate);

	    view()->share('module'         , $this->module);
        view()->share('views'          , $this->views);

        view()->share('fields'         , $this->fields);
	    view()->share('statusOptions'  , $this->statusOptions);

        // Path for includes into views
        view()->share('firstSegment'   , $this->appName);
        view()->share('secondSegment'  , $this->views);

        view()->share('hasFiles'       , $this->hasFiles);
        view()->share('fieldFiles'     , $this->fileFields);
        
        view()->share('textCreateBtn'     , $this->textCreateBtn);

        if($this->model){
            $this->classModel = "{$this->pathModel}\\{$this->model}";
            $this->classRepository = "{$this->pathRepositories}\\{$this->model}Repository";
            $this->repository = app($this->classRepository);
        }
	}

	public function index()
	{		    	
	    $items = $this->repository->all();

        return $this->view("index", compact('items'));
	}

	public function create()
    {
        return $this->view("create");
    }

    public function store()
    {
        $post = $this->prepareForStoreValidation();

        $repository = $this->repository;

        $validator = Validator::make($post, $this->getModelRules());

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("{$this->appName}.{$this->module}.create"))->withErrors($validator)->withInput();
        }

        try{
            $instance = $repository->create($post);

            if($instance && $this->hasFiles){
                $this->processFiles($instance);
            }
        } catch (\Exception $e) {
            return redirect(route("{$this->appName}.{$this->module}.create"))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("{$this->appName}.{$this->module}.index"))->with('alert_success', 'Su registro ha sido creado con &eacute;xito');
    }

    public function edit($id)
    {
        $item = $this->repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        return $this->view("edit", compact('item'));     
    }

    public function update($id)
    {
        $post = $this->prepareForUpdateValidation();

        $repository = $this->repository;
        $item = $repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $validator = Validator::make($post, $this->getModelRules());

        if ($validator->fails()) {
            // $validator->errors()->all();
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->withErrors($validator)->withInput();
        }

        try{
            $instance = $repository->update($post, $item->id);

            if($instance && $this->hasFiles){
                $this->processFiles($item, true);
            }

        } catch (\Exception $e) {
            return redirect(route("{$this->appName}.{$this->module}.edit", ['id' => $item->id]))->with('alert_error', 'Ocurrio por favor intente nuevamente');
        }

        return redirect(route("{$this->appName}.{$this->module}.index"))->with('alert_success', 'El registro ha sido actualizado con &eacute;xito');
    }

    public function destroy($id)
    {
        $repository = $this->repository;
        $item = $repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $repository->delete($id);

        return redirect(route("{$this->appName}.{$this->module}.index"))->with('alert_success', 'El registro ha sido eliminado con &eacute;xito');
    }

    public function status($id, $status)
    {
        $repository = $this->repository;
        $item = $repository->find($id);

        if(! $item){
            return response('Registro no encontrado', 404);
        }

        $item->status = $status;
        $item->save();

        return redirect(route("{$this->appName}.{$this->module}.index"))->with("alert_success", "El estado de registro ha sido actualizado con &eacute;xito");
    }

    protected function prepareForStoreValidation()
    {
    	return request()->all();
    }

    protected function prepareForUpdateValidation()
    {
    	return request()->all();
    }

    protected function getModelRules()
    {
        $className = $this->classModel;
        return $className::$rules;
    }

    protected function view($template, $data = [])
    {
        if($template === "create" || $template === "edit"){
            if (! View::exists("{$this->appName}.{$this->views}.fields")) {
                view()->share('firstSegment'   , $this->defaultFirstSegment);
                view()->share('secondSegment'  , $this->defaultSecondSegment);
            }
        }elseif($template === "index"){
            if (! View::exists("{$this->appName}.{$this->views}.table")) {
                view()->share('firstSegment'   , $this->defaultFirstSegment);
                view()->share('secondSegment'  , $this->defaultSecondSegment);
            }
        }

        return view()->first([
            "{$this->appName}.{$this->views}.{$template}",
            "{$this->defaultFirstSegment}.{$this->defaultSecondSegment}.{$template}"
        ], $data);
    }

    protected function processFiles($instance, $deleteOldFiles = false)
    {
        $files = request()->allFiles();
        $data = [];

        if(count($files) === 0){
            return;
        }
        
        foreach($this->fileFields as $field)
        {
            if(array_key_exists($field, $files)){
                $upload = $this->uploadFile($field);

                if(is_array($upload) && $upload['status'] === true){
                    $data[$field] = $upload['name'];
                }
            }
        }

        if(count($data)){
            $this->repository->update($data, $instance->id);
        }

        if($deleteOldFiles){

            foreach($this->fileFields as $field)
            {
                if($instance->$field){  
                    $this->destroyFile($instance->$field);
                }
            }
        }
    }

    private function uploadFile($field)
    {
        $public_path = public_path();

        $allowed_types = $this->allowedTypes;
        $max_size = config('app.max_size_image');

        Storage::disk('upload')->makeDirectory($this->pathUpload);

        $files = request()->allFiles();   

        if(count($files) == 0){
            return null;
        }

        $UploadedFile = (array_key_exists($field, $files)) ? $files[$field] : [ ];

        if ($UploadedFile && $UploadedFile instanceof UploadedFile) {

            $originalName = $UploadedFile->getClientOriginalName();
            $extension = strtolower($UploadedFile->getClientOriginalExtension());
            $size = $UploadedFile->getClientSize();

            if ( ! in_array($extension, $allowed_types)) {
                return [
                    'status' => false,
                    'message' => 'El tipo de archivo seleccinado no es v&aacute;lido.'
                ];
            }

            if ($size > (int) $max_size * 1024) {
                return [
                    'status' => false,
                    'message' => 'La imagen no puede ser mayor a ('.$max_size.')Kb.'
                ];
            }

            // Sustituye todo lo que no sea alfanumerico por guion
            $newName = preg_replace('/[^\.a-zA-Z0-9]+/', '-', strtolower($originalName));
            $newName = preg_replace('/[^0-9]+/', '', Carbon::now()->format('Y-m-d H:i:s')).'-'.$newName;

            $pathAbsolute = $public_path.'/upload/'.$this->pathUpload;

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
                    'preview' => config('app.base_url').'/upload/'.$this->pathUpload.'/'.$newName,
                    'path'    => $this->pathUpload,
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
