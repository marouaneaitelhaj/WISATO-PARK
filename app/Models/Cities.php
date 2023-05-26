<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    protected $fillable = [
        'CITY',
    ];
    public function Quartier(){
        return $this->hasMany(Quartier::class);
    }
}
