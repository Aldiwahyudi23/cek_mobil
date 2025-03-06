<?php

namespace App\Models\DataMobil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;

    protected $fillable = ['car_model_id', 'name', 'description', 'is_active'];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }
}