<?php

namespace App\Models\Aktor\Operator\Sarana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Strata extends Model
{
    use SoftDeletes;
    
    protected $table 		= "strata";
    protected $fillable 	= ['nama', 'level', 'created_by', 'updated_at', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function pendidikan()
    {
        return $this->hasOne('App\Models\Home\Riwayat\Pendidikan');
    }
}
