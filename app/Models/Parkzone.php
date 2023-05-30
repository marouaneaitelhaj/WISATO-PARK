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
        'quartier_id',
        'status'
    ];

    public function category(){
        return $this->hasMany('App\Models\Category', 'category_wise_parkzone_slot', 'parkzone_id', 'category_id');
    }
    public function slots()
    {
        return $this->hasMany('App\Models\CategoryWiseParkzoneSlot');
    }
    public function Quartier()
    {
        return $this->belongsTo('App\Models\Quartier');
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
