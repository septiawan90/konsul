<?php

namespace App\Models\Admin\Aktor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengawas extends Model
{
    use SoftDeletes;
    
    protected $table 		= "pengawas";
    protected $fillable 	= ['nama', 'nik', 'nip', 'email'];
    protected $dates 		= ['deleted_at'];
}
