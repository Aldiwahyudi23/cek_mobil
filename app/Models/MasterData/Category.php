<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_active'];

    public function inspection_points()
    {
        return $this->hasMany(InspectionPoint::class, 'categories_id');
    }
}