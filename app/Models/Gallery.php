<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'parkzone_id',
        'image',
    ];

    public function parkzone()
    {
        return $this->belongsTo(Parkzone::class);
    }
}
