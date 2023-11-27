<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKecil extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getIdTanggalAttribute()
    {
        return date('d-m-Y', strtotime($this->tanggal));
    }

    public function lastKasKecil()
    {
        return $this->latest()->orderBy('id', 'desc')->first();
    }

    public function kasKecilNow($bulan, $tahun)
    {
        return $this->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
    }

    public function lastKasKecilByMonth($bulan, $tahun)
    {
        return $this->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->latest()->orderBy('id', 'desc')->first();
    }

    public function getNfNominalTransaksiAttribute()
    {
        return number_format($this->nominal_transaksi, 0, ',', '.');
    }

    public function getNfSaldoAttribute()
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    public function getNominalTransaksiMasukAttribute()
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

    public function totalMasuk($bulan, $tahun)
    {
        $value = $this->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('jenis', 1)->sum('nominal_transaksi');
        return number_format($value, 0, ',', '.');
    }

    public function totalKeluar($bulan, $tahun)
    {
        $value = $this->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('jenis', 0)->sum('nominal_transaksi');
        return number_format($value, 0, ',', '.');
    }

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(tanggal) as tahun')->groupBy('tahun')->get();
    }

    public function insertMasuk($nota)
    {
        $rekening = Rekening::where('untuk', 'kas-kecil')->first();

        $data['nominal_transaksi'] = 1000000;
        $data['tanggal'] = now();
        $data['jenis'] = 1;
        $saldo = $this->lastKasKecil()->saldo ?? 0;
        $data['saldo'] = $saldo + $data['nominal_transaksi'];
        $data['nota'] = "KK".sprintf("%02d", $nota);
        $data['void'] = 1;
        $data['nama_rek'] = $rekening->nama_rek;
        $data['bank'] = $rekening->bank;
        $data['no_rek'] = $rekening->no_rek;

        $store = $this->create($data);

        return $store;

    }

    public function insertKeluar($data)
    {
        $data['nominal_transaksi'] = str_replace('.', '', $data['nominal_transaksi']);
        $data['tanggal'] = now();
        $data['jenis'] = 0;
        $data['saldo'] = $this->lastKasKecil()->saldo - $data['nominal_transaksi'];
        $data['void'] = 0;

        $store = $this->create($data);

        return $store;
    }

    public function insertVoid($id)
    {
        $rekening = Rekening::where('untuk', 'kas-kecil')->first();

        $update = $this->find($id);
        $data['uraian'] = "Void " . $update->uraian;
        $data['nominal_transaksi'] = $update->nominal_transaksi;
        $data['nama_rek'] = $rekening->nama_rek;
        $data['bank'] = $rekening->bank;
        $data['no_rek'] = $rekening->no_rek;

        $update->update(['void' => 1]);

        $data['tanggal'] = now();
        $data['jenis'] = 1;
        $data['saldo'] = $this->lastKasKecil()->saldo + $data['nominal_transaksi'];
        $data['void'] = 1;

        $store = $this->create($data);

        return $store;
    }
}
