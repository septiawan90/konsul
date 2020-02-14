<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'name', 'email', 'password', 'status',
        'nik', 'email', 'password', 'status', 'activation_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function peserta()
    {
    	return $this->hasMany('App\Models\Aktor\Lpp\Peserta');
    }

    public function petugas()
    {
    	return $this->hasOne('App\Petugas');
    }

    public function profil()
    {
        //return $this->hasMany('App\Profil');
        return $this->hasOne('App\Profil');
    }

    public function owner()
    {
        return $this->hasOne('App\Models\Aktor\Lpp\Owner');
    }
}
