<?php

use App\Models\Aktor\Tamu\Konsultasi;
use App\Models\Aktor\Tamu\Tiket;

use App\Models\Daerah\Kota;
use App\Models\Daerah\Kecamatan;
use App\Models\Daerah\Kelurahan;

use App\Models\Aktor\Lpp\Kegiatan;
use App\Models\Aktor\Lpp\Peserta;

use App\Models\Aktor\Operator\Sertifikat\Tingkat_dasar;
use App\Models\Aktor\Operator\Legal\Penerima;

class Statistik
{
    public static function hitungSubjek($id, $bln)
    {
        $isi = Konsultasi::where('subjek_id', '=', $id)->whereMonth('created_at', $bln)->count();

        return $isi != 0 ? $isi : "";
    }

    public static function hitungTiketSubjek($id)
    {        
        $isi = Konsultasi::where('tiket_id', '=', $id)                            
                            ->whereNotNull('subjek_id')
                            ->distinct('subjek_id')
                            ->groupBy('tiket_id')
                            ->count();

        return $isi != 0 ? $isi : "-";
    }

    public static function hitungTiketSubjekPertanyaan($id)
    {
        $isi = Konsultasi::where('tiket_id', '=', $id)->whereNotNull('subjek_id')->count();

        return $isi != 0 ? $isi : "-";
    }

    public static function hitungSubjekTahun($id)
    {
        return Konsultasi::where('subjek_id', '=', $id)->whereYear('created_at', date('Y'))->count();
    }

    public static function hitungPetugas($id, $bln)
    {
        $isi = Konsultasi::where('petugas_id', '=', $id)->whereMonth('created_at', $bln)->count();

        return $isi != 0 ? $isi : "";
    }

    public static function hitungPetugasTahun($id)
    {
        return Konsultasi::where('petugas_id', '=', $id)->whereYear('created_at', date('Y'))->count();
    }

    public static function hitungTamu($id, $bln)
    {
        $isi = Tiket::where('tamu_id', '=', $id)
                    ->whereMonth('created_at', $bln)
                    ->count();

        return $isi != 0 ? $isi : "";
    }

    public static function hitungTamuSubjek($subjek_id, $tamu_id)
    {
        $isi = Konsultasi::where('subjek_id', '=', $subjek_id)
                ->whereNotNull('subjek_id')
                ->whereHas('tiket', function($q) use ($tamu_id)
                    {
                        return $q->where('tamu_id', '=', $tamu_id);
                    })
                ->count();

        return $isi != 0 ? $isi : "";
    }

    public static function hitungTamuSubjekTahun($tamu_id)
    {
        return Konsultasi::whereYear('created_at', date('Y'))
                ->whereNotNull('subjek_id')
                ->whereHas('tiket', function($q) use ($tamu_id)
                    {
                        return $q->where('tamu_id', '=', $tamu_id);
                    })->count();
    }

    public static function hitungTamuTahun($id)
    {
        return Tiket::where('tamu_id', '=', $id)->whereYear('created_at', date('Y'))->count();
    }

    // daerah
    public static function hitungKota($id)
    {
        $isi = Kota::where('provinsi_id', '=', $id)->count();

        return $isi != 0 ? $isi : "";
    }

    public static function hitungKecamatan($id)
    {
        $isi = Kecamatan::whereHas('kota', function($q) use ($id) {
            return $q->where('provinsi_id', '=', $id);
        })->count();

        return $isi != 0 ? $isi : "";
    }

    public static function hitungKelurahan($id)
    {
        $isi = Kelurahan::whereHas('kecamatan', function($q) use ($id) {
            return $q->join('ina_kota as kota', 'kota.id', '=', 'ina_kecamatan.kota_id')->where('kota.provinsi_id', '=', $id);
        })->count();

        return $isi != 0 ? $isi : "";
    }

    // kegiatan
    public static function hitungKegiatan($id)
    {
        $isi = Kegiatan::where('surat_id', '=', $id)->count();

        return $isi != 0 ? $isi : "";
    }

    public static function hitungPendaftarSurat($id)
    {
        $isi = Peserta::whereHas('kegiatan', function($q) use($id)
                {
                    return $q->where('surat_id', '=', $id);
                })->count();

        return $isi != 0 ? $isi : "";
    }
    
    public static function hitungPendaftar($id)
    {
        $isi = Peserta::where('kegiatan_id', '=', $id)->count();

        return $isi != 0 ? $isi : "0";
    }

    // sertifikat tingkat dasar
    public static function hitungTingkatDasar($nomor)
    {
        $isi = Tingkat_dasar::where('nomor', '=', $nomor)->count();

        return $isi != 0 ? $isi : "";
    }

    // penerima sk
    public static function hitungPenerimaSk($id)
    {
        $isi = Penerima::where('sk_id', '=', $id)->count();

        return $isi != 0 ? $isi : "-";
    }
}