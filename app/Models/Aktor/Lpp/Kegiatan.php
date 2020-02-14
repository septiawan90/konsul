<?php

namespace App\Models\Aktor\Lpp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use SoftDeletes;
    
    protected $table 		= "kegiatan_sertifikasi";
    protected $fillable 	= ['kode', 'surat_id', 'tanggal', 'jam', 'status', 'venue_id', 'kuota', 'sesi'];
    protected $dates 		= ['deleted_at'];
    
    public function surat()
    {
    	return $this->belongsTo('App\Models\Aktor\Lpp\Surat');
    }

    public function peserta()
    {
    	return $this->hasOne('App\Models\Aktor\Lpp\Peserta');
    }

    public function venue()
    {
    	return $this->belongsTo('App\Models\Aktor\Lpp\Venue');
    }
}
