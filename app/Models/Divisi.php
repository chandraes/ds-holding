<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kas_gaji_komisaris()
    {
        return $this->hasMany(KasGajiKomisaris::class);
    }

    public function kas_gaji_komisaris_now($month, $year)
    {
        return $this->kas_gaji_komisaris()->whereMonth('tanggal', $month)->whereYear('tanggal', $year)->get();
    }
}
