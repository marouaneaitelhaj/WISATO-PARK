<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class operator_inparkzone extends Model
{
    use HasFactory;
    // name of table
    protected $table = 'operator_inparkzone';
    protected $fillable = [
        'operator_id',
        'parkzone_id',
    ];
    
}
