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
    public function side_slots()
    {
        return $this->hasMany(Side_slot::class, 'side_id');
    }
    public function side_slot_numbers()
    {
        return $this->hasMany(Side_slot_number::class, 'side_id');
    }
}
