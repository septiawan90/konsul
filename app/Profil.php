<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use SoftDeletes;
    
    protected $table 		= "profil";
    protected $fillable 	= ['user_id', 'alamat', 'nama', 'email2', 'no_hp', 'kota_id', 'file'];
    protected $dates 		= ['deleted_at'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function lpp()
    {
    	return $this->hasMany('App\Models\Aktor\Operator\Sarana\Lpp');
    }

    public function peserta()
    {
    	return $this->hasOne('App\Models\Aktor\Lpp\Peserta');
    }

    public function penerima()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Legal\Penerima');
    }

    public function kota()
    {
    	return $this->belongsTo('App\Models\Daerah\Kota');
    }
}
