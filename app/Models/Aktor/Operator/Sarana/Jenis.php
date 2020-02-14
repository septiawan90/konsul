<?php

namespace App\Models\Aktor\Operator\Sarana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis extends Model
{
    use SoftDeletes;
    
    protected $table 		= "jenis";
    protected $fillable 	= ['kode', 'nama', 'fungsi', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function lpp()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Sarana\Lpp');
    }
}
