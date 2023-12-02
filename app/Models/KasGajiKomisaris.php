<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KasGajiKomisaris extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function getIdTanggalAttribute()
    {
        return date('d-m-Y', strtotime($this->tanggal));
    }

    public function kasGajiKomisarisNow($bulan, $tahun)
    {
        return $this->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
    }

    public function lastKasGajiKomisarisByMonth($month, $year)
    {
        $sub = $this->select('divisi_id', DB::raw('MAX(id) as id'))
                    ->whereMonth('tanggal', $month)
                    ->whereYear('tanggal', $year)
                    ->groupBy('divisi_id');

        return $this->from('kas_gaji_komisaris as k')
                    ->joinSub($sub, 'sub', function ($join) {
                        $join->on('k.id', '=', 'sub.id');
                    })
                    ->first();
    }

    public function lastKas($divisiId)
    {
        $db = $this->where('divisi_id', $divisiId)->latest()->orderBy('id', 'desc')->first();

        return $db;
    }

    public function getNfNominalTransaksiAttribute()
    {
        return number_format($this->nominal_transaksi, 0, ',', '.');
    }

    public function getNominalTransaksiMasukAttribute()
    {
        if ($this->jenis == 1) {
            return $this->nominal_transaksi;
        }
    }
    
    public function getNfNominalTransaksiMasukAttribute()
    {
        if ($this->jenis == 1) {
            return number_format($this->nominal_transaksi, 0, ',', '.');
        }
    }

    public function getNominalTransaksiKeluarAttribute()
    {
        if ($this->jenis == 0) {
            return number_format($this->nominal_transaksi, 0, ',', '.');
        }
    }

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(tanggal) as tahun')->groupBy('tahun')->get();
    }


    public function getNfSaldoAttribute()
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    public function insertDividen($data)
    {
        $persen = PersenKas::select('nama', 'persen')->get();
        $divisi = Divisi::where('id', $data['divisi_id'])->first();

        $nominal = str_replace('.', '', $data['nominal_transaksi']);

        $kasBesarPersen = $persen->where('nama', 'kas-besar')->first()->persen;
        $kasGajiKomisarisPersen = $persen->where('nama', 'kas-gaji-komisaris')->first()->persen;

        $kasBesarAmount = round($nominal * $kasBesarPersen / 100);
        $kasGajiKomisarisAmount = round($nominal * $kasGajiKomisarisPersen / 100);

        // Adjust for rounding errors
        $total = $kasBesarAmount + $kasGajiKomisarisAmount;

        if($total < $nominal) {
            $kasBesarAmount += $nominal - $total;
        }

        if($total > $nominal) {
            $kasBesarAmount -= $total - $nominal;
        }

        $saldoGaji = $this->lastKas($data['divisi_id'])->saldo ?? 0;

        $kasBesar = new KasBesar();

        $kas['uraian'] = 'Dividen '.$divisi->nama;
        $kas['nominal_transaksi'] = $kasBesarAmount;

        $store = $kasBesar->insertMasuk($kas);

        $kasGaji['uraian'] = 'Dividen';
        $kasGaji['jenis'] = 1;
        $kasGaji['divisi_id'] = $data['divisi_id'];
        $kasGaji['tanggal'] = date('Y-m-d');
        $kasGaji['nominal_transaksi'] = $kasGajiKomisarisAmount;
        $kasGaji['saldo'] = $saldoGaji + $kasGajiKomisarisAmount;

        $this->create($kasGaji);

        return $store;
    }
}
