<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Declaration.
 *
 * @package namespace App\Models;
 */
class Declaration extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'form',
        'nro',
        'type',
        'period',
        'declaration',
        'bank_id',
        'date_payment',
        'date_emission',
        'company_id',
        'municipality_id',
        'status',
    ];

    public function bank(){
        return $this->hasOne('App\Models\Bank', 'id', 'bank_id');
    }

    public function municipality(){
        return $this->hasOne('App\Models\Municipality', 'id', 'municipality_id');
    }
}
