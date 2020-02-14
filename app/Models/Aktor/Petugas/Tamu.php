<?php

namespace App\Models\Aktor\Petugas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tamu extends Model
{
    use SoftDeletes;
    
    protected $table 		= "tamu";
    protected $fillable 	= ['nik', 'nip', 'nama', 'email', 'hp', 'instansi'];
    protected $dates 		= ['deleted_at'];

    public function tamu()
    {
    	return $this->hasOne('App\Models\Aktor\Petugas\Tamu');
    }
}
