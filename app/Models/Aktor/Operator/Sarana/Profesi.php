<?php

namespace App\Models\Aktor\Operator\Sarana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesi extends Model
{
    use SoftDeletes;
    
    protected $table 		= "profesi";
    protected $fillable 	= ['kode', 'nama', 'unit_kerja_id', 'created_by', 'updated_by', 'deleted_by', 'restored_by'];
    protected $dates 		= ['deleted_at'];

    public function unit_kerja()
    {
    	return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Unit_kerja');
    }

    public function sk()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Legal\Sk');
    }
}
