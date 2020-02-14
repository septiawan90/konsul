<?php

namespace App\Models\Daerah;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table 		= "ina_kecamatan";
    protected $fillable 	= ['kota_id', 'nama', 'meta'];

    public function kota()
    {
    	return $this->belongsTo('App\Models\Daerah\Kota');
    }

    public function kelurahan()
    {
    	return $this->hasOne('App\Models\Daerah\Kelurahan');
    }
}
