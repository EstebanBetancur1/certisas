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
use App\Traits\CrudI18nTrait;

class PostsController extends Controller
{
    use CrudI18nTrait;

    protected $appLayout = "admin";
    protected $appName = "admin";

    protected $module = "Posts";
    protected $pageTitle = "Blog";
    protected $model = "Post";

    protected $textCreateBtn = "Crear publicaci&oacute;n";

    protected $fields = [
        'es' => [
            'title' => 'Publicaci&oacute;n',
        ],
        'status' => 'Estado',
    ];

    protected $fileTranslationsFields = [
        'image'
    ];

    protected $pathUpload = "posts";
}