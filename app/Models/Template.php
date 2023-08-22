<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Template.
 *
 * @package namespace App\Models;
 */
class Template extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title',
    	'status',
        'type',
    	'company_id',
    	'user_id',
        'city_id',
        'period_type',
    ];

    public function company(){
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public static function array($field = 'id') {
        $templates = self::all();
        $array = [];
        foreach ($templates as $template) {
            $array[] = $template->$field;
        }
        return $array;
    }
}
