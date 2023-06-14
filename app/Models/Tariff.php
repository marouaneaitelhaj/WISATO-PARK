<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use ModelCommonMethodTrait;
    protected $fillable = [
        'id',
        'name',
        'category_id',
        'start_date',
        'end_date',
        'total_amount',
        'amount',
        'status',
        'created_by',
        'modified_by',
        'validate_start_date', 
        'validate_end_date', 
        'day' ,
        'quartier_id', 
        'parkzone_id',
        'shadow_amount',
        'number_hour'
    ];
    protected $guarded = [];

    public static function getCurrent($category_id)
    {
        $currDate = date('Y-m-d H:i:s');
        return Tariff::where([
            ['end_date', '>=', $currDate],
            ['start_date', '<=', $currDate],
            ['category_id', '=', $category_id],
            ['status', '=', 1]
        ])->orderBy('id', 'DESC')->first();
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function quartier()
    {
        return $this->belongsTo('App\Models\Quartier');
    }
    public function parkzone()
    {
        return $this->belongsTo('App\Models\Parkzone');
    }
    
    
}
