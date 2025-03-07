<?php

namespace App\Models\DataMobil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'car_model_id',
        'car_type_id',
        'year',
        'engine_capacity_id',
        'transmission_id',
        'fuel_type_id',
        'production_period'
    ];

    // Relasi ke tabel brands
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relasi ke tabel car_models
    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    // Relasi ke tabel car_types
    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    // Relasi ke tabel engine_capacities
    public function engineCapacity()
    {
        return $this->belongsTo(EngineCapacity::class);
    }

    // Relasi ke tabel transmissions
    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }

    // Relasi ke tabel fuel_types
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }
}
