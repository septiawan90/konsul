<?php

namespace App\Models\Home\Riwayat;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table 		= "riwayat_instansi";
    protected $fillable 	= ['klpd_id', 'profil_id', 'unit_kerja', 'kategori', 'nomor_pegawai', 'tgl_mulai', 'tgl_akhir'];

    public function klpd()
    {
        return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Klpd');
    }
}
