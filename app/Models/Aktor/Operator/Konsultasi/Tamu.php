<?php

namespace App\Models\Aktor\Operator\Konsultasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tamu extends Model
{
    use SoftDeletes;
    
    protected $table 		= "tamu";
    protected $fillable 	= [];
    protected $dates 		= ['deleted_at'];

    public function tiket()
    {
    	return $this->hasOne('App\Models\Aktor\Tamu\Tiket');
    }
}
