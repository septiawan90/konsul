<?php

namespace App\Models\Aktor\Tamu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tiket extends Model
{
    use SoftDeletes;
    
    protected $table 		= "tiket";
    protected $fillable 	= ['tamu_id', 'nomor'];
    protected $dates 		= ['deleted_at'];

    public function konsultasi()
    {
    	return $this->hasOne('App\Konsultasi');
    }

    public function layanan()
    {
    	return $this->hasOne('App\Layanan');
    }
}
