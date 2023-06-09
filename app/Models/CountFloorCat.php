<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountFloorCat extends Model
{
    use HasFactory;


    protected $table = 'count_floor_cat';

    protected $fillable = [
        'floor_id',
        'category_id',
        'count',
    ];

    // Define relationships or customizations here
    // For example:
    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

