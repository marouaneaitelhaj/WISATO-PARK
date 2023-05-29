<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlOperator extends Model
{
    use HasFactory;

    protected $table = 'control_operators';


    protected $fillable = [
        'operator',
        'agent',
        'status',
        'remark',
    ];

    public function operatorUser()
    {
        return $this->belongsTo(User::class, 'operator');
    }

    public function agentUser()
    {
        return $this->belongsTo(User::class, 'agent');
    }

}
