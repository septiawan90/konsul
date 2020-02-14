<?php

namespace App\Models\Daerah;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table 		= "ina_kelurahan";
    protected $fillable 	= ['kecamatan_id','nama','meta'];

    public function kecamatan()
    {
    	return $this->belongsTo('App\Models\Daerah\Kecamatan');
    }
}
