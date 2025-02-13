<?php

namespace App\Models\Inspek;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKendaraan extends Model
{
    use HasFactory;

    protected $fillable = ['nopol', 'merek', 'tahun', 'model', 'type', 'cc', 'transmition', 'bahan_bakar', 'periode', ' warna', 'file'];
}