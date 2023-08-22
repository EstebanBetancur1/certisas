<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TemplateItem.
 *
 * @package namespace App\Models;
 */
class TemplateItem extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nit',
    	'name',
    	'doc',
    	'date',
    	'base',
        'tax',
    	'rate',
    	'year_process',
    	'period_process',
    	'concept',
    	'type',
    	'company_id',
    	'user_id',
    	'template_id',

        'city_id',
        'period_type',
    ];

    public static $rules = [

        'nit'               => 'required|string',
        'name'              => 'required|string',
        'doc'               => 'required|string',
        'date'              => 'required|string',
        'base'              => 'required|string',
        'tax'               => 'required|string',
        'rate'              => 'required|string',
        'year_process'      => 'required|string',
        'period_process'    => 'required|string',
        'concept'           => 'required|string',

        'type'              => 'required|in:1,2,3',
        'status'            => 'required|in:0,1',

        'company_id'        => 'required|integer',
        'user_id'           => 'required|integer',
        'template_id'       => 'required|integer',

        'city_id'           => 'nullable|integer',
        'period_type'       => 'required|in:1,2,3',
    ];

    public function company(){
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
}
