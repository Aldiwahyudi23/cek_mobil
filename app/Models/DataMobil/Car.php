<?php

namespace App\Models\DataMobil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'model_id',
        'car_type_id',
        'year',
        'engine_capacity_id',
        'transmission_id',
        'fuel_type_id',
        'production_period_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function engineCapacity()
    {
        return $this->belongsTo(EngineCapacity::class);
    }

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }

    public function productionPeriod()
    {
        return $this->belongsTo(ProductionPeriod::class);
    }
}
