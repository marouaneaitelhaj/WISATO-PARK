<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Parkzone;

class Floor extends Model
{
    use HasFactory;

    protected $table = 'floors';

    protected $fillable = [
        'parkzone_id',
        'level',
        'shadow',
        'status',
    ];


    public function parkzone()
    {
        return $this->belongsTo(Parkzone::class, 'parkzone_id');
    }
    public function floorSlots($categorie_id = null)
    {
        if ($categorie_id == null) {
            return $this->hasMany(FloorSlot::class);
        }
        return $this->hasMany(FloorSlot::class)->where('categorie_id', $categorie_id);
    }
}
