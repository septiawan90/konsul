<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suspend extends Model
{
    //use SoftDeletes;
    
    protected $table 		= "users";
    //protected $dates 		= ['deleted_at'];
}
