<?php

namespace App;

use App\Models\ModelCommonMethodTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, MustVerifyEmailTrait, ModelCommonMethodTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'Phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
      return $this->belongsToMany('App\Models\Role');
    }

    public function hasRole($roles){
        if (!is_array($roles)) {
            $roles = [$roles]; 
        }
        
        return (boolean) $this->roles()->whereIn('name', $roles)->first();
    }
}
