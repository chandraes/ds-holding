<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komisaris extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function persenDivisi()
    {
        return $this->hasMany(PersenDivisi::class);
    }

    public function persentaseDivisi($divisi)
    {
        return $this->persenDivisi()->where('divisi_id', $divisi)->first()->persen ?? 0;
    }
}
