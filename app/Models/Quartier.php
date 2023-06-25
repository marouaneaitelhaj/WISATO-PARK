<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\cities;

class Quartier extends Model
{
    use HasFactory;
    
    protected $fillable = ['quartier_name', 'city_id'];

    public function city()
    {
        return $this->belongsTo(cities::class, 'city_id');
    }
    public function parkzones()
    {
        return $this->hasMany(Parkzone::class);
    }
    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }
}
