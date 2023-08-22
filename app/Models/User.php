<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'token_pre_register', 'phone', 'password', 'image', 'type', 'status', 'is_admin', 'last_login', 'email_confirmed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $rules = [
        'full_name'         => 'required|string',
        'email'             => 'required|email|unique:users',
        'password'          => 'nullable|alpha_num|confirmed|min:6',
        'is_admin'          => 'integer|in:0,1',
        'status'            => 'required|in:0,1,2',
        'email_confirmed'   => 'nullable|in:0,1',
        'type'              => 'nullable|in:0,1,2',
    ];

    public function getImageAttribute($value){

        if($value){
            return (is_file(public_path("upload/users/{$value}"))) ? asset("upload/users/{$value}") : null ;
        }

        return null;
    }

    public function companies()
    {
        return $this->belongsToMany('App\Models\Company', 'company_users', 'user_id', 'company_id');
    }
}