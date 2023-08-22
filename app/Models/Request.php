<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Request.
 *
 * @package namespace App\Models;
 */
class Request extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'nit',
    	'dv',
    	'sectional',
    	'type',
    	'name',
    	'city',
    	'address',
    	'email',
        'email_user',
        'user_request',
    	'phone',
        'file',
        'date',
        'activities',
        'responsibilities',
        'status',
        'email_status',
        'token',
    ];

    public static $rules = [
        'nit'              => 'required|string',
        'dv'               => 'required|string',
        'sectional'        => 'required|string',
        'type'             => 'required|string',
        'name'             => 'required|string',
        'city'             => 'required|string',
        'address'          => 'required|string',
        'email'            => 'required|email',
        'email_user'       => 'required|email',
        'user_request'     => 'nullable|email',
        'phone'            => 'required|string',
        'activities'       => 'required|string',
        'responsibilities' => 'required|string',
        'date'             => 'nullable|integer',
        'status'           => 'required|in:0,1',
        'email_status'     => 'required|in:0,1',
    ];
}
