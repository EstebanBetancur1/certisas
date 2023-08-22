<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Emission.
 *
 * @package namespace App\Models;
 */
class Emission extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'agent_name',
        'agent_nit',
        'agent_dv',
        'agent_sectional',
        'agent_phone',
        'agent_city',
        'agent_address',

        'provider_name',
        'provider_nit',
        'provider_dv',
        'provider_sectional',
        'provider_phone',
        'provider_city',
        'provider_address',

    	'concepts',
        'docs',
        
        'months',
        'total_transaction_amount',
    	'total_tax_amount',
    	'total_amount_withheld',
    	'type',
    	'period_type',
        'period',
        'date_emission',
    	'year',
    	'status',
    	'company_id',
    	'provider_id',
        'city_id',
    	'user_id',
        'doc_id',
    ];

    public function company(){
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function provider(){
        return $this->belongsTo('App\Models\Company', 'provider_id', 'id');
    }

    public function city(){
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }
}
