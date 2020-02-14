<?php

namespace App\Models\Aktor\Operator\Sarana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit_kerja extends Model
{
    use SoftDeletes;
    
    protected $table 		= "unit_kerja";
    protected $fillable 	= ['kode', 'nama', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function profesi()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Sarana\Profesi');
    }
}
