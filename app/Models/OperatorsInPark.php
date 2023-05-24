<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorsInPark extends Model
{
    use HasFactory;
    protected $table = 'operators_in_parks';

    protected $fillable = [
        'category_wise_parkzone_slot_id ',
        'operator_id',
    ];

    // Define the relationship with the Operator model

}
