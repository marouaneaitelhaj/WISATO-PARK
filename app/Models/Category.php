<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelCommonMethodTrait;
    protected $fillable = [
        'type',
        'description',
        'status',
        'created_by',
        'modified_by'
    ];

    protected $guarded = [];
    // realtion with CategoryWiseParkzoneSlot
    public function categoryWiseParkzoneSlot()
    {
        return $this->hasMany('App\Models\CategoryWiseParkzoneSlot');
    }
    public function parking()
    {
        return $this->hasMany('App\Models\Parking');
    }
    public function parkzone()
    {
        return $this->belongsToMany('App\Models\Parkzone', 'category_wise_parkzone_slot', 'category_id', 'parkzone_id');
    }

    public function tariff()
    {
        return $this->hasMany('App\Models\Tariff');
    }

    public function slots()
    {
        return $this->hasMany('App\Models\CategoryWiseParkzoneSlot');
    }

    public function active_parking()
    {
        return $this->hasOneThrough('App\Models\Parking', 'App\Models\CategoryWiseParkzoneSlot', 'category_id', 'slot_id')->whereNull('out_time');
    }
}
