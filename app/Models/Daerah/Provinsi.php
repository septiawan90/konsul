<?php

namespace App\Models\Daerah;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table 		= "ina_provinsi";
    protected $fillable 	= ['nama', 'meta'];

    public function kota()
    {
    	return $this->hasOne('App\Models\Daerah\Provinsi');
    }
}
