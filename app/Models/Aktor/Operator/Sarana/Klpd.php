<?php

namespace App\Models\Aktor\Operator\Sarana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klpd extends Model
{
    use SoftDeletes;
    
    protected $table 		= "klpd";
    protected $fillable 	= ['kode', 'nama', 'alias', 'created_by', 'updated_at', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function instansi()
    {
        return $this->hasOne('App\Models\Home\Riwayat\Instansi');
    }
}
