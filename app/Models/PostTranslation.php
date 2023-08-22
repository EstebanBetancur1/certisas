<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PostTranslation.
 *
 * @package namespace App\Models;
 */
class PostTranslation extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title', 
    	'content',
    	'image',
    	'lang',
    	'language_id',
    	'instance_id',
    ];

    public static $rules = [
        'title'         => 'required|string',
        'content'       => 'required|string',
        'lang'         	=> 'required|string|size:2',
        'language_id'   => 'required|integer',
        'instance_id'   => 'required|integer',
    ];

    public function getImageAttribute($value){

        if($value){
            return (is_file(public_path("upload/posts/{$value}"))) ? asset("upload/posts/{$value}") : null;
        }

        return null;
    }
}
