<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parkzone extends Model
{
    use ModelCommonMethodTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'level',
        'remarks',
        'status'
    ];

    public function slots()
    {
        return $this->hasMany('App\Models\CategoryWiseParkzoneSlot');
    }

    public function active_parking()
    {
        return $this->hasOneThrough('App\Models\Parking', 'App\Models\CategoryWiseParkzoneSlot', 'parkzone_id', 'slot_id')->whereNull('out_time');
    }
    public function agents()
    {
        return $this->belongsToMany('App\User', 'agent_inparkzone', 'parkzone_id', 'agent_id');
    }
    

}
