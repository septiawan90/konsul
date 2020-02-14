<?php

namespace App\Models\Aktor\Petugas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Konsultasi extends Model
{
    use SoftDeletes;
    
    protected $table 		= "konsultasi";
    protected $fillable 	= ['subjek_id','konsultasi'];
    protected $dates 		= ['deleted_at'];

    public function tiket()
    {
    	return $this->belongsTo('App\Models\Aktor\Petugas\Tiket');
    }

    public function subjek()
    {
        return $this->belongsTo('App\Models\Aktor\Petugas\Subjek');
    }

    public function profesi()
    {
    	return $this->belongsTo('App\Models\Aktor\Petugas\Profesi', 'profil_profesi_id');
    }
}
