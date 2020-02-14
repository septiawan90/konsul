<?php

namespace App\Models\Aktor\Operator\Legal;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps      = false;
    protected $table 		= "roles";

    public function sk()
    {
    	return $this->hasOne('App\Models\Aktor\Operator\Legal\Sk');
    }
}
