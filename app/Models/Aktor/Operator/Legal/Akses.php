<?php

namespace App\Models\Aktor\Operator\Legal;

use Illuminate\Database\Eloquent\Model;

class Akses extends Model
{
    public $timestamps      = false;
    protected $table 		= "model_has_roles";
    protected $fillable 	= ['role_id', 'model_type', 'model_id'];
}
