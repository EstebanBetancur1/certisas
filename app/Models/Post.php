<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Post.
 *
 * @package namespace App\Models;
 */
class Post extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'status'
    ];

    public static $rules = [
        'status'            => 'required|in:0,1'
    ];

    public function versions(){
        return $this->hasMany('App\Models\PostTranslation', 'instance_id', 'id');
    }
}