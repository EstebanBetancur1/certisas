<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class City.
 *
 * @package namespace App\Models;
 */
class City extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'code',
    	'state_id',
    	'name',
    ];

    public function state(){
        return $this->belongsTo('App\Models\State', 'state_id', 'id');
    }

    public function entity(){
        return $this->hasOne('App\Models\Entity', 'city_id', 'id');
    }
}
