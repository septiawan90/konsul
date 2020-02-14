<?php

namespace App\Models\Home\Riwayat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sertifikasi extends Model
{
    protected $table 		= "kegiatan_sertifikasi_peserta";

    public function kegiatan()
    {
    	return $this->belongsTo('App\Models\Aktor\Lpp\Kegiatan');
    }
}
