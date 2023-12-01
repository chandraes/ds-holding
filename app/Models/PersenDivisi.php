<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersenDivisi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function komisaris()
    {
        return $this->belongsTo(Komisaris::class);
    }

    public function persenKomisaris($divisiId, $komisarisId)
    {
        $db = $this->where('divisi_id', $divisiId)->where('komisaris_id', $komisarisId)->first()->persen ?? 0;

        return $db;
    }
}
