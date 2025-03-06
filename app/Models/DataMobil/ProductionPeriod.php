<?php

namespace App\Models\DataMobil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPeriod extends Model
{

    use HasFactory;
    protected $fillable = ['start_year', 'end_year'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
