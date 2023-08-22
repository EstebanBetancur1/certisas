<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Company.
 *
 * @package namespace App\Models;
 */
class Company extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'logo',
        'nit',
    	'dv',
    	'sectional',
    	'type',
    	'name',
    	'city',
    	'address',
    	'email',
    	'phone',
        'file',
        'date',
        'activities',
        'responsibilities',
        'status',
    ];

    public static $rules = [
        'logo'             => 'nullable|string',
        'nit'              => 'required|string|unique:companies',
        'dv'               => 'required|string',
        'sectional'        => 'required|string',
        'type'             => 'required|string',
        'name'             => 'required|string',
        'city'             => 'required|string',
        'address'          => 'required|string',
        'email'            => 'required|email',
        'phone'            => 'required|string',
        'activities'       => 'nullable|string',
        'responsibilities' => 'nullable|string',
        'date'             => 'nullable|integer',
        'status'           => 'required|in:0,1',
    ];


    public function activities()
    {
        return $this->belongsToMany('App\Models\Activity', 'company_activities', 'company_id', 'activity_id');
    }

    public function responsibilities()
    {
        return $this->belongsToMany('App\Models\Responsibility', 'company_responsibilities', 'company_id', 'responsibility_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'company_users', 'company_id', 'user_id');
    }

    public static function array($field = 'id') {
        $companies = self::all();
        $array = [];
        foreach ($companies as $company) {
            $array[] = $company->$field;
        }
        return $array;
    }

}
