<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Language.
 *
 * @package namespace App\Models;
 */
class Language extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title',
    	'lang',
    	'status',
    	'main'
    ];

    public static $rules = [
        'title'         	=> 'required|string',
        'lang'         		=> 'required|string|size:2',
        'status'            => 'required|in:0,1',
        'main'   			=> 'nullable|in:0,1'
    ];
}
