<?php

namespace App\Models\Aktor\Lpp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use SoftDeletes;
    
    protected $table 		= "venue";
    protected $fillable 	= ['nama', 'alamat', 'kota_id'];
    protected $dates 		= ['deleted_at'];

    public function kota()
    {
        return $this->belongsTo('App\Models\Daerah\Kota');
    }

    public function kegiatan()
    {
        return $this->hasOne('App\Models\Aktor\Lpp\kegiatan');
    }
}
