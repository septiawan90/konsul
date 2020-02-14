<?php

namespace App\Models\Aktor\Operator\Jadwal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use SoftDeletes;
    
    protected $table 		= "surat";
    protected $fillable 	= ['status'];
    protected $dates 		= ['deleted_at'];

    public function kegiatan()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Jadwal\Kegiatan');
    }

    public function lpp()
    {
    	return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Lpp');
    }
}
