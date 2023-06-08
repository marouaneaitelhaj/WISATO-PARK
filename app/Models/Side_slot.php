<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Side_slot extends Model
{
    use HasFactory;
    protected $table = 'side_slots';
    protected $fillable = [
        'side_id',
        'category_id',
    ];
    public function side()
    {
        return $this->belongsTo(Sides::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
