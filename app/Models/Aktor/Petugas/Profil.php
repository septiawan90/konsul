<?php

namespace App\Models\Aktor\Petugas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use SoftDeletes;
    
    protected $table 		= "profil";
    protected $dates 		= ['deleted_at'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function profesi()
    {
    	return $this->hasOne('App\Models\Aktor\Petugas\Profesi');
    }

}
