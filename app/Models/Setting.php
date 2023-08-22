<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Setting.
 *
 * @package namespace App\Models;
 */
class Setting extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'project',
        'route_login_panel',
        'email_notification',
        'maintenance_mode',
        'coming_soon_mode'
    ];

    public static $rules = [
        'project'               => 'required|string',
        'route_login_panel'     => 'required|string',
        'email_notification'    => 'required|email',
        'maintenance_mode'      => 'required|integer|in:0,1',
        'coming_soon_mode'      => 'required|integer|in:0,1'
    ];
}