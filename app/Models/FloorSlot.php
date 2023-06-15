<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorSlot extends Model
{
    use HasFactory;

    protected $fillable = ['floor_id', 'categorie_id', 'name'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }
}
