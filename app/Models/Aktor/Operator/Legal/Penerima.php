<?php

namespace App\Models\Aktor\Operator\Legal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penerima extends Model
{
    use SoftDeletes;
    
    protected $table 		= "profil_profesi";
    protected $fillable 	= ['profil_id', 'sk_id', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function sk()
    {
    	return $this->belongsTo('App\Models\Aktor\Operator\Legal\Sk');
    }

    public function profil()
    {
    	return $this->belongsTo('App\Profil');
    }
}
