<?php

namespace App\Models\Aktor\Operator\Jadwal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use SoftDeletes;
    
    protected $table 		= "kegiatan_peserta";
    protected $fillable 	= [];
    protected $dates 		= ['deleted_at'];

    public function profil()
    {
    	return $this->belongsTo('App\Profil');
    }

    public function kegiatan()
    {
    	return $this->belongsTo('App\Models\Aktor\Operator\Jadwal\Kegiatan');
    }
}
