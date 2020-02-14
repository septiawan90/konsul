<?php

namespace App\Models\Daerah;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table 		= "ina_kota";
    protected $fillable 	= ['provinsi_id', 'nama', 'meta'];

    public function provinsi()
    {
    	return $this->belongsTo('App\Models\Daerah\Provinsi');
    }

    public function kecamatan()
    {
    	return $this->hasOne('App\Models\Daerah\Kecamatan');
    }

    public function venue()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Sarana\Venue');
    }

    public function profil()
    {
        return $this->hasOne('App\Profil');
    }
}
