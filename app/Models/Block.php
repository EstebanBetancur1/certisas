<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Block.
 *
 * @package namespace App\Models;
 */
class Block extends Model implements Transformable
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
        return $this->hasMany('App\Models\BlockTranslation', 'instance_id', 'id');
    }

}
