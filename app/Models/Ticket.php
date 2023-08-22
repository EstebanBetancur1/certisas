<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Ticket.
 *
 * @package namespace App\Models;
 */
class Ticket extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file',
        'subject',
        'message',
        'user_id',
        'transmitter_id',
        'emission_id',
        'receiver_id',
        'status',
    ];

    public function companyTransmitter(){
        return $this->hasOne('App\Models\Company', 'id', 'transmitter_id');
    }

    public function companyReceiver(){
        return $this->hasOne('App\Models\Company', 'id', 'receiver_id');
    }
}
