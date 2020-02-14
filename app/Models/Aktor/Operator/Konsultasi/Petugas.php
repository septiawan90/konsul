<?php

namespace App\Models\Aktor\Operator\Konsultasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Petugas extends Model
{
    use SoftDeletes;
    
    protected $table 		= "petugas";
    protected $fillable 	= ['nik', 'nip', 'nama', 'email', 'hp'];
    protected $dates 		= ['deleted_at'];

    public function layanan()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Konsultasi\Layanan');
    }
}
