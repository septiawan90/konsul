<?php

namespace App\Models\Aktor\Operator\Sarana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lpp extends Model
{
    use SoftDeletes;
    
    protected $table 		= "lpp";
    protected $fillable 	= ['profil_id', 'kode', 'alias', 'nama', 'alamat', 'email', 'telp', 'kota_id', 'jenis_id', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function kota()
    {
    	return $this->belongsTo('App\Models\Daerah\Kota');
    }

    public function surat()
    {
        return $this->hasOne('App\Models\Aktor\Lpp');
        //return $this->hasOne('App\Models\Aktor\Operator\Jadwal\Lpp');
    }

    public function profil()
    {
        return $this->belongsTo('App\Profil');
    }

    public function jenis()
    {
        return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Jenis');
    }
}
