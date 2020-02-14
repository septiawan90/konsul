<?php

namespace App\Models\Aktor\Lpp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use SoftDeletes;
    
    protected $table 		= "lpp";
    protected $fillable 	= ['kota_id', 'jenis_id', 'alamat', 'no_hp', 'email2', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function kota()
    {
    	return $this->belongsTo('App\Models\Daerah\Kota');
    }

    public function surat()
    {
        return $this->hasOne('App\Models\Aktor\Lpp');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\Aktor\Lpp\Owner');
    }

    public function jenis()
    {
        return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Jenis');
    }
}
