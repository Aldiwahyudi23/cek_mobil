<?php

namespace App\Models\Inspek;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_kendaraan_id',
        'inspection_point_id',
        'status',
        'note'
    ];
}