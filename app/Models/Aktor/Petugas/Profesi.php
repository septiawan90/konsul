<?php

namespace App\Models\Aktor\Petugas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesi extends Model
{
    use SoftDeletes;
    
    protected $table 		= "profil_profesi";

    public function konsultasi()
    {
    	return $this->hasOne('App\Models\Aktor\Petugas\Konsultasi');
    }

    public function profil()
    {
        return $this->belongsTo('App\Models\Aktor\Petugas\Profil');
    }
}
