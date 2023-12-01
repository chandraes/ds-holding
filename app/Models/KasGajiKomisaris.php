<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasGajiKomisaris extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function lastKas($divisiId)
    {
        $db = $this->where('divisi_id', $divisiId)->latest()->orderBy('id', 'desc')->first();

        return $db;
    }

    public function getNfSaldoAttribute()
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    public function insertDividen($data)
    {
        $persen = PersenKas::select('nama', 'persen')->get();

        $nominal = $data['nominal_transaksi'];

        $kasBesarPersen = $persen->where('nama', 'kas-besar')->first()->persen;
        $kasGajiKomisarisPersen = $persen->where('nama', 'kas-gaji-komisaris')->first()->persen;

        $kasBesarAmount = round($nominal * $kasBesarPersen / 100);
        $kasGajiKomisarisAmount = round($nominal * $kasGajiKomisarisPersen / 100);

        // Adjust for rounding errors
        $total = $kasBesarAmount + $kasGajiKomisarisAmount;

        if ($total != $nominal) {
            $kasBesarAmount -= $total - $nominal;
        }

        $db = $this->where('divisi_id', $data['divisi_id'])->first();

        $kasBesar = new KasBesar();

        $kas['uraian'] = 'Dividen ';

        $kasGaji['uraian'] = 'Dividen';

        if($db == null)
        {
            $db = $this->create([
                'divisi_id' => $data['divisi_id'],
                'saldo' => $kasGajiKomisarisAmount
            ]);
        } else {
            $db->update([
                'saldo' => $db->saldo + $kasGajiKomisarisAmount
            ]);
        }





    }
}
