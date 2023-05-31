<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentInParkzone extends Model
{
    use HasFactory;

    protected $table = 'agent_inparkzone';
    protected $fillable = ['agent_id', 'parkzone_id'];


    // public function parkzone()
    // {
    //     return $this->belongsTo(Parkzone::class, 'parkzone_id');
    // }
}
