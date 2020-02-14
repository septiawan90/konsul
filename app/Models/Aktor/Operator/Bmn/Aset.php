<?php

namespace App\Models\Aktor\Operator\Bmn;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    use SoftDeletes;
    
    protected $table 		= "aset";
    protected $fillable 	= ['nama', 'merk', 'kategori', 'kode_bmn', 'nomor_urut', 'kode_satker', 'tahun_perolehan', 'file', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];

    public function server()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Ubk\Server');
    }
}
