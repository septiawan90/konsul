<?php

namespace App\Models\Aktor\Operator\Legal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sk extends Model
{
    use SoftDeletes;
    
    protected $table 		= "sk";
    protected $fillable 	= ['nomor', 'tanggal', 'tentang', 'kadaluarsa', 'role_id','file', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    // public function profesi()
    // {
    // 	return $this->belongsTo('App\Models\Aktor\Operator\Sarana\Profesi');
    // }

    public function role()
    {
    	return $this->belongsTo('App\Models\Aktor\Operator\Legal\Role');
    }

    public function penerima()
    {
    	return $this->hasMany('App\Models\Aktor\Operator\Legal\Penerima');
    }
}
