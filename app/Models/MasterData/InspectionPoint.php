<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionPoint extends Model
{
    use HasFactory;

    protected $fillable = ['categories_id', 'name', 'description', 'type_input', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}