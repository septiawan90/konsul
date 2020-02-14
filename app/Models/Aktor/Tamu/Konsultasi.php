<?php

namespace App\Models\Aktor\Tamu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Konsultasi extends Model
{
    use SoftDeletes;
    
    protected $table 		= "konsultasi";
    protected $fillable 	= ['tiket_id','nama','nik','nip','instansi','email','hp','subjek_id','konsultasi'];
    protected $dates 		= ['deleted_at'];

    public function tiket()
    {
    	return $this->belongsTo('App\Models\Aktor\Tamu\Tiket');
    }

    public function subjek()
    {
        return $this->belongsTo('App\Models\Aktor\Operator\Konsultasi\Subjek');
    }

    public function petugas()
    {
    	return $this->belongsTo('App\Petugas');
    }
}
