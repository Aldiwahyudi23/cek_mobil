<?php

namespace App\Models\DataMobil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
