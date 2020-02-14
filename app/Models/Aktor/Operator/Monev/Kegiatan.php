<?php

namespace App\Models\Aktor\Operator\Monev;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use SoftDeletes;
    
    protected $table 		= "kegiatan";
    protected $fillable 	= ['status', 'keterangan', 'pengawas1_id', 'pengawas2_id'];
    protected $dates 		= ['deleted_at'];
    
    public function surat()
    {
    	return $this->belongsTo('App\Models\Aktor\Operator\Monev\Surat');
    }

    public function peserta()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Monev\Peserta');
    }

    public function venue()
    {
    	return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Venue');
    }

    public function pengawas1()
    {
        return $this->belongsTo('App\Models\Aktor\Operator\Legal\Penerima');
    }

    public function pengawas2()
    {
        return $this->belongsTo('App\Models\Aktor\Operator\Legal\Penerima');
    }
}
