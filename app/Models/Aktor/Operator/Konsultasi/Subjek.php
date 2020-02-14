<?php

namespace App\Models\Aktor\Operator\Konsultasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subjek extends Model
{
    use SoftDeletes;
    
    protected $table 		= "subjek";
    protected $fillable 	= ['kode', 'subjek'];
    protected $dates 		= ['deleted_at'];

    public function konsultasi()
    {
    	return $this->hasOne('App\Models\Aktor\Tamu\Konsultasi');
    }

    public function layanan()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Konsultasi\Layanan');
    }
}
