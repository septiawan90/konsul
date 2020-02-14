<?php

namespace App\Models\Home\Riwayat;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table 		= "riwayat_pendidikan";
    protected $fillable 	= ['strata_id', 'profil_id', 'thn_lulus', 'institusi'];

    public function strata()
    {
        return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Strata');
    }
}
