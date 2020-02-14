<?php

namespace App\Models\Aktor\Operator\Sarana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelaku_pbj extends Model
{
    use SoftDeletes;
    
    protected $table 		= "pelaku_pbj";
    protected $fillable 	= ['kode', 'nama', 'alias', 'created_by', 'udpated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function pengalaman_pbj()
    {
        return $this->hasOne('App\Models\Home\Riwayat\Pengalaman_pbj');
    }
}
