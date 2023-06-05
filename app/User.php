<?php

namespace App;

use App\Models\ModelCommonMethodTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ControlOperator;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable, MustVerifyEmailTrait, ModelCommonMethodTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'Phone','cin'
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
    public function parkzones()
    {
        return $this->belongsToMany('App\Models\Parkzone', 'agent_inparkzone', 'agent_id', 'parkzone_id');
    }

    public function hasRole($roles){
        if (!is_array($roles)) {
            $roles = [$roles]; 
        }
        
        return (boolean) $this->roles()->whereIn('name', $roles)->first();
    }
    public function CategoryWiseParkzoneSlot()
    {
        return $this->belongsToMany('App\Models\CategoryWiseParkzoneSlot', 'operators_in_parks', 'operator_id', 'category_wise_parkzone_slot_id');
    }
    public function controlOperators()
    {
        return $this->hasMany(ControlOperator::class, 'operator');
    }
    
    
}
