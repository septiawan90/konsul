<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Profil;
use App\User;
use App\Models\Daerah\Kota;
use Auth;

class KonfirmasiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $kota = Kota::all();
        return view('konfirmasi',['user_id' => $user_id, 'kota' => $kota]);
    }

    public function update($id, Request $request)
	{
        $pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];
		
		$this->validate($request,[
			'nama' 			=> 'required',
            'alamat' 		=> 'required',
            'kota_id' 		=> 'required',
            'no_hp'         => 'nullable|numeric',
            'email'         => 'nullable|email|confirmed',
	    ], $pesan);

        $profil_id = Profil::where('user_id', '=', Crypt::decrypt($id))->first()->id;

		$isi = Profil::find($profil_id);

        $isi->nama 		= $request->nama;
        $isi->alamat 	= $request->alamat;
        $isi->kota_id 	= $request->kota_id;
        $isi->no_hp 	= $request->no_hp;
        $isi->email2    = $request->email;
        $isi->save();
        
        //update status menjadi 1
        $isi2 = User::find(Crypt::decrypt($id));
        $isi2->status = '1';
        $isi2->save();
		
		return redirect('/home/');
	}
	
	protected function store(Request $request)
    {
        $pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
            'digits'        => 'Jumlah karakter harus :digits.',
            'email'         => 'Format harus email.',
        ];

        $this->validate($request,[
            'nama' 			=> 'required',
            'alamat' 		=> 'required',
            'kota_id' 		=> 'required',
            'no_hp'         => 'nullable|numeric',
            'email'         => 'nullable|email|confirmed',
            'password'      => 'required|confirmed'
    	], $pesan);
 
        Profil::create([
            'user_id'        => Auth::user()->id,
            'nama' 			 => $request->nama,
            'alamat' 		 => $request->alamat,
            'kota_id' 		 => $request->kota_id,
            'no_hp' 		 => $request->no_hp,
            'email2'         => $request->email,
        ]);

		$user = Auth::user('id');
         DB::table('users')
			->where('id', $user->id)
			->update(
            [
            'password'  => Hash::make($request['password']),
            'status'    => '1'
            ]
        );

    	return redirect('/home/');
    }

   
}
