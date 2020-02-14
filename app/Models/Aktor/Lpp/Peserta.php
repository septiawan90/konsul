<?php

namespace App\Models\Aktor\Lpp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use SoftDeletes;
    
    protected $table 		= "kegiatan_sertifikasi_peserta";
    protected $fillable 	= ['kode', 'kegiatan_id', 'profil_id', 'status', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function profil()
    {
    	return $this->belongsTo('App\Profil');
    }

    public function kegiatan()
    {
    	return $this->belongsTo('App\Models\Aktor\Lpp\Kegiatan');
    }
}
