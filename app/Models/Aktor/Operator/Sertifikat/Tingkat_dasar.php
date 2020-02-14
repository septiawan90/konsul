<?php

namespace App\Models\Aktor\Operator\Sertifikat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tingkat_dasar extends Model
{
    use SoftDeletes;
    
    protected $table 		= "tingkat_dasar";
    protected $fillable 	= ['seri', 'file', 'nik', 'nip', 'email', 'created_by', 'updated_by', 'deleted_by'];
    protected $dates 		= ['deleted_at'];
}
