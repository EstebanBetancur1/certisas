<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CompanyUser.
 *
 * @package namespace App\Models;
 */
class CompanyUser extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
    	'company_id',
        'type',
        'status',
    ];

    public static $rules = [
        'user_id'          => 'required|integer',
        'company_id'       => 'required|integer',
        'type'             => 'required|in:0,1',
        'status'           => 'required|in:0,1',
    ];

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function company(){
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
}
