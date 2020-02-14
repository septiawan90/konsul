<?php

namespace App\Models\Aktor\Petugas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subjek extends Model
{
    use SoftDeletes;
    
    protected $table 		= "subjek";
    protected $fillable     = [];
    protected $dates 		= ['deleted_at'];

    public function konsultasi()
    {
    	return $this->hasOne('App\Models\Aktor\Petugas\Konsultasi');
    }

    // public function layanan()
    // {
    // 	return $this->hasOne('App\Models\Aktor\Operator\Konsultasi\Layanan');
    // }
}
