<?php

namespace App\Models\Inspek;

use App\Models\MasterData\InspectionPoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_kendaraan_id',
        'inspection_point_id',
        'file_path'
    ];

    public function inspection_point()
    {
        return $this->belongsTo(InspectionPoint::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}