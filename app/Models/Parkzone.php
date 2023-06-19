<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Type;

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
        'type',
        'mode',
        'remarks',
        'quartier_id',
        'status',
        'in_use',
        'image_path',
    ];
    public function sides()
    {
        return $this->hasMany('App\Models\Sides');
    }
    public function Side_slot()
    {
        return $this->hasMany('App\Models\Side_slot');
    }
    public function sides_number()
    {
        return $this->hasMany('App\Models\Side_slot_number');
    }
    public function category()
    {
        return $this->hasMany('App\Models\Category', 'category_wise_parkzone_slot', 'parkzone_id', 'category_id');
    }
    public function slots($type)
    {
        if ($type == 'standard') {
            return $this->hasMany('App\Models\CategoryWiseParkzoneSlot');
        } elseif ($type == 'floor') {
            return $this->floor();
        } else {
            return $this->sides();
        }
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
    public function operators()
    {
        return $this->belongsToMany('App\User', 'operator_inparkzone', 'parkzone_id', 'operator_id');
    }
    public function agent_inparkzone()
    {
        return $this->hasMany('App\Models\AgentInparkzone');
    }
    public function floor()
    {
        return $this->hasMany('App\Models\Floor');
    }
    public function tariff()
    {
        return $this->hasMany('App\Models\Tariff');
    }
}
