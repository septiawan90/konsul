<?php

namespace App\Models\Aktor\Lpp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use SoftDeletes;
    
    protected $table 		= "surat";
    protected $fillable 	= ['lpp_id', 'nomor', 'tanggal', 'tentang', 'file'];
    protected $dates 		= ['deleted_at'];

    public function kegiatan()
    {
    	return $this->hasOne('App\Models\Aktor\Lpp\Kegiatan');
    }

    public function lpp()
    {
    	return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Lpp');
    }
}
