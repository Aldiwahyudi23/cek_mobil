<?php

namespace App\Models\DataMobil;

use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    protected $fillable = ['type'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
