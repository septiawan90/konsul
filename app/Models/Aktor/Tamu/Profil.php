<?php

namespace App\Models\Aktor\Tamu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use SoftDeletes;
    
    protected $table 		= "tamu";
    protected $fillable 	= ['nik', 'nip', 'pin', 'nama', 'email', 'hp', 'instansi'];
    protected $dates 		= ['deleted_at'];

    public function tiket()
    {
    	return $this->hasOne('App\Models\Aktor\Tamu\Tiket');
    }
}
