<?php

namespace App\Models\DataMobil;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected    $fillable = ['name', 'description', 'is_active'];

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}