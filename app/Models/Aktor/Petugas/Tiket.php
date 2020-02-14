<?php

// namespace App\Models\Aktor\Operator\Konsultasi;
namespace App\Models\Aktor\Petugas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tiket extends Model
{
    use SoftDeletes;
    
    protected $table 		= "tiket";
    protected $dates 		= ['deleted_at'];

    public function tamu()
    {
        return $this->belongsTo('App\Models\Aktor\Tamu\Profil');
    }
}
