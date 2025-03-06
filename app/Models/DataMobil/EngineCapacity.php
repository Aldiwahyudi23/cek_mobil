<?php

namespace App\Models\DataMobil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Types\Relations\Car;

class EngineCapacity extends Model
{

    use HasFactory;
    protected $fillable = ['value'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
