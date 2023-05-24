<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category_category_wise_parkzone_slot extends Model
{
    use HasFactory;
    protected $table = 'category_category_wise_parkzone_slot';

    protected $fillable = [
        'slot_id ',
        'category_id',
    ];

    // Define the relationship with the Operator model

}
