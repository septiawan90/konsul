<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Rules\Nik\Prov; #1
use App\Rules\Nik\Kota_nik; #2
use App\Rules\Nik\Gender; #3
use App\Rules\Nik\Tgl; #4
use App\Rules\Nik\Bln; #5
use App\Rules\Nik\Thn; #6

class RegisterController extends Controller
{   
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nik'       => ['required', 'numeric', 'digits:16', 'confirmed', 'unique:users', new Prov, new Kota_nik, new Gender, new Tgl, new Bln, new Thn],
            'email'     => ['required', 'string', 'email', 'max:255', 'confirmed', 'unique:users'],
            'password'  => ['required', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        // 1. insert tabel user
        // 2. ambil id tabel user parameter : where nik, where email
        // 3. tambah tabel profil fk user_id

        return User::create([
            'nik'       => $data['nik'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
        ]);
        
        //$user_id = User::where('nik', '=', $data['nik'])->where('email', '=', $data['email'])->first()->id;
        
       
    }
}
