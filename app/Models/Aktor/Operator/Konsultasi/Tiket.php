<?php

namespace App\Models\Aktor\Operator\Konsultasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tiket extends Model
{
    use SoftDeletes;
    
    protected $table 		= "tiket";
    protected $fillable 	= [];
    protected $dates 		= ['deleted_at'];

    public function layanan()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Konsultasi\Layanan');
    }
}
