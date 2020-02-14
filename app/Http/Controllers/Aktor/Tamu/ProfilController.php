<?php

namespace App\Http\Controllers\Aktor\Tamu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SertifikasiEmail;

use App\Models\Aktor\Tamu\Profil;

class ProfilController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'profil',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'profil',
		'aksi'        		=> '',
		'link'         		=> '/profil',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/tamu/profil/index',
		'view_form' 	 	=> 'aktor/tamu/profil/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	public function cari()
    {
		$this->data['aksi'] 		= 'cari';
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/telusur";
		
		return view($this->data['view_form'], $this->data);
	}
	
	public function telusur(Request $request)
    {
        $pesan = [
            'required'    => 'Wajib diisi.',
            'min'         => 'Minimal 16 Karakter.',
        ];

        $this->validate($request, ['nik' => 'required|min:16'], $pesan);
		
		$cari = $request->nik;

        if(empty($cari))
        {

        }
        else
        {
            $email 	= Profil::where('nik','=', $cari)->first();
			
			if(is_null($email))
			{
				$this->data['profil']  = Profil::where('nik','=', $cari)->paginate(10);
				return view($this->data['view_utama'], $this->data);
			}
			else
			{
				$pin = substr(uniqid(), -4);
				$details = [
					'title' => 'Pin Konsultasi',
					'body' 	=> $pin
				];

				Mail::to($email->email)->send(new \App\Mail\SertifikasiEmail($details));

				$isi 				= Profil::where('nik', '=', $cari)->first();
        		$isi->pin 	        = $pin;
				$isi->save();
		
				return redirect('/profil/pin/'.Crypt::encrypt($isi->id))->with(['success' => 'Masukan 4 digit pin yang telah kami kirimkan ke kotak masuk email Anda.']);
			}
        }
    }

	public function pin($id)
    {
		$this->data['aksi'] 		= 'pin';
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/pin_telusur/".$id;
		
		return view($this->data['view_form'], $this->data);
	}

	public function pin_telusur($id, Request $request)
	{
		$cari 		= $request->pin;
		$cek_pin 	= Profil::where('id', '=', Crypt::decrypt($id))->where('pin', '=', $cari)->count();
		
		if($cek_pin > 0)
		{
			// cleaning pin
			$isi 				= Profil::where('id', '=', Crypt::decrypt($id))->first();
        	$isi->pin 	        = null;
			$isi->save();

			return redirect('/profil/tamu/'.Crypt::encrypt($isi->id));
		}
		else
		{
			return abort(404);
		}
	}

    public function tamu($id)
    {
    	$this->data['profil']  = Profil::where('id', '=', Crypt::decrypt($id))->paginate(10);
		return view($this->data['view_utama'], $this->data);	
    }

    public function tambah()
    {
		$this->data['aksi']         = 'tambah';
		$this->data['form_action'] 	= "/profil/store/";
		
		return view($this->data['view_form'], $this->data);
    }

    public function store(Request $request)
    {
    	$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
            'digits'        => 'Jumlah harus :digits digit.',
			'email'         => 'Format harus email.',
			'unique'        => 'Data sudah ada.',
        ];

        $this->validate($request,[
    		'nama' 			=> 'required',
    		'nik'           => 'required|numeric|digits:16|unique:tamu',
            'nip'           => 'nullable|numeric|digits:18',
            'email'         => 'required|email|unique:tamu',
            'hp'            => 'required|numeric',
    	], $pesan);
 
        Profil::create([
    		'nama' 			=> $request->nama,
    		'nik' 			=> $request->nik,
    		'nip' 			=> $request->nip,
            'email'         => $request->email,
            'hp'            => $request->hp,
			'instansi'      => $request->instansi,
    	]);

        $profil = Profil::select('id')->where('nik', '=', $request->nik)->first();

    	return redirect('/tiket/tambah/'.Crypt::encrypt($profil->id));
    }

    /*public function ubah($id)
	{
	   	$id        = Crypt::decrypt($id);
        $isi       = Tamu::find($id);
	   	return view('tamu/ubah', ['tamu' => $isi]);
	}

	public function update($id, Request $request)
	{
	    $this->validate($request,[
		   	'nama' 			=> 'required',
    		'nik' 			=> 'required|numeric|digits:16|unique:tamu',
            'nip'           => 'nullable|numeric|digits:18',
            'email'         => 'required|email|unique:tamu',
            'hp'            => 'required|numeric|unique:tamu'
	    ]);

	    $isi 				= Tamu::find($id);

	    $isi->nama 			= $request->nama;
    	$isi->nik 			= $request->nik;
    	$isi->nip			= $request->nip;
        $isi->email         = $request->email;
        $isi->hp            = $request->hp;
        $isi->instansi      = $request->instansi;

	    $isi->save();
	    return redirect('/tamu/');
	}

    public function delete($id)
	{
	    $id    = Crypt::decrypt($id);

        $isi = Tamu::find($id);
	    $isi->delete();

	    return redirect()->back();
	}

	public function sampah()
	{
    	$isi = Tamu::onlyTrashed()->get();
    	return view('tamu/sampah', ['tamu' => $isi]);
	}

	public function kembalikan($id)
	{
    	$id     = Crypt::decrypt($id);

        $isi    = Tamu::onlyTrashed()->where('id', $id);
    	$isi->restore();
    	return redirect('/tamu/sampah');
	}

	public function kembalikan_semua()
	{		
    	$isi = Tamu::onlyTrashed();
    	$isi->restore();

    	return redirect('/tamu/sampah');
	}

	public function hapus_permanen($id)
	{
    	$id    = Crypt::decrypt($id);

        $isi   = Tamu::onlyTrashed()->where('id', $id);
    	$isi->forceDelete();

    	return redirect('/tamu/sampah');
	}

	public function hapus_permanen_semua()
	{
    	$isi = Tamu::onlyTrashed();
    	$isi->forceDelete();

    	return redirect('/tamu/sampah');
	}*/
}

