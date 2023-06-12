<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Side_slot_number extends Model
{
    use HasFactory;
    protected $fillable = [
        'side_id',
        'slot_number',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
