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

class LanguagesController extends Controller
{
    use CrudTrait;

    protected $appLayout = "admin";
    protected $appName = "admin";

    protected $module = "Languages";
    protected $pageTitle = "Idiomas";
    protected $model = "Language";

    protected $textCreateBtn = "Crear idioma";

    protected $fields = [
    	'title' => 'Idioma',
    	'status' => 'Estado'
    ];
}