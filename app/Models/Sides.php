<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sides extends Model
{
    use HasFactory;
    use ModelCommonMethodTrait;
    // table name
    protected $table = 'sides';
    protected $fillable = [
        'parkzone_id',
        'side',
    ];
    public function parkzone()
    {
        return $this->belongsTo(Parkzone::class);
    }
    public function side_slots($Category = null)
    {
        if ($Category == null) {
            return $this->hasMany(Side_slot::class, 'side_id');
        } else {
            return $this->hasMany(Side_slot::class, 'side_id')->where('category_id', $Category);
        }
    }
    public function side_slots_active($Category = null)
    {
        return $this->hasMany(Side_slot::class, 'side_id')->where('category_id', $Category);
    }
    public function side_slot_numbers()
    {
        return $this->hasMany(Side_slot_number::class, 'side_id')->with('category');
    }
}
