<?php

namespace App\Models\Aktor\Lpp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use SoftDeletes;
    
    protected $table 		= "profil";
    protected $fillable 	= [];
    protected $dates 		= ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function lpp()
    {
        return $this->hasOne('App\Models\Aktor\Lpp\Profil', 'profil_id');
    }
}
