<?php

namespace App\Models\Home\Riwayat;

use Illuminate\Database\Eloquent\Model;

class Pengalaman_pbj extends Model
{
    protected $table 		= "riwayat_pengalaman_pbj";
    protected $fillable 	= ['profil_id', 'pelaku_pbj_id', 'kode_paket', 'nama_paket', 'nilai_paket', 'tahun'];

    public function pelaku_pbj()
    {
        return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Pelaku_pbj');
    }
}
