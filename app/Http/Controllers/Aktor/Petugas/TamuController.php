<?php

namespace App\Http\Controllers\Aktor\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use App\Models\Aktor\Petugas\Tamu;
use App\Models\Aktor\Petugas\Tiket;
use App\Models\Aktor\Petugas\Konsultasi;

class TamuController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'tamu',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'petugas',
		'aksi'        		=> '',
		'link'         		=> '/petugas',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/petugas/tamu/index',
		'view_riwayat' 		=> 'aktor/petugas/tamu/riwayat',
		'view_detil' 		=> 'aktor/petugas/tamu/detil',
		'view_form' 	 	=> 'aktor/petugas/tamu/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

    public function index($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
        $this->data['profesi_id']   = $profesi_id;
		
		$this->data['tamu']  = Tamu::orderBy('nama', 'ASC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

    public function ubah($user_id, $profil_id, $profesi_id, $tamu_id)
	{
		$this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
		$this->data['profesi_id']   = $profesi_id;
		$this->data['tamu_id']   	= $tamu_id;

		$this->data['aksi']         = 'ubah';
		$this->data['form_action'] 	= "/petugas/tamu/update/".$user_id."/".$profil_id."/".$profesi_id."/".$tamu_id;
		
		$this->data['tamu']  		= Tamu::find(Crypt::decrypt($tamu_id));
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $profesi_id, $tamu_id, Request $request)
	{
	    $this->validate($request,[
		   	'nama' 			=> 'required',
    		'nik' 			=> 'required|numeric|digits:16|unique:tamu,'.Crypt::decrypt($tamu_id),
            'nip'           => 'nullable|numeric|digits:18',
            'email'         => 'required|email|unique:tamu,'.Crypt::decrypt($tamu_id),
            'hp'            => 'required|numeric'
	    ]);

	    $isi 				= Tamu::find(Crypt::decrypt($tamu_id));

	    $isi->nama 			= $request->nama;
    	$isi->nik 			= $request->nik;
    	$isi->nip			= $request->nip;
        $isi->email         = $request->email;
        $isi->hp            = $request->hp;
		$isi->instansi      = $request->instansi;
		$isi->updated_by 	= Crypt::decrypt($profesi_id);

	    $isi->save();
	    return redirect('/petugas/tamu/'.$user_id.'/'.$profil_id.'/'.$profesi_id);
	}

	public function riwayat($user_id, $profil_id, $profesi_id, $tamu_id)
	{
		$this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
		$this->data['profesi_id']   = $profesi_id;
		$this->data['tamu_id']   	= $tamu_id;
		
		$this->data['tamu']  		= Tamu::find(Crypt::decrypt($tamu_id));
		$this->data['konsultasi'] 	= Konsultasi::select('*', DB::raw('count(konsultasi.tiket_id) as total'))
										->join('tiket', 'tiket.id', '=', 'konsultasi.tiket_id')
										->join('tamu', 'tamu.id', '=', 'tiket.tamu_id')
										->where('tiket.tamu_id', '=', Crypt::decrypt($tamu_id))
										->groupBy('tiket.nomor')
										->orderBy('tiket.created_at', 'desc')
										->paginate(10);
						
		return view($this->data['view_riwayat'], $this->data);
	}

	public function detil($user_id, $profil_id, $profesi_id, $tamu_id, $tiket_id)
    {
		$this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
		$this->data['profesi_id']   = $profesi_id;
		$this->data['tamu_id']   	= $tamu_id;
		$this->data['tiket_id']   	= $tiket_id;

		$this->data['tiket']  		= Tiket::find(Crypt::decrypt($tiket_id));
		$this->data['tamu']  		= Tamu::find(Crypt::decrypt($tamu_id));
        $this->data['konsultasi'] 	= Konsultasi::where('tiket_id', '=', Crypt::decrypt($tiket_id))->paginate(10);

        return view($this->data['view_detil'], $this->data);
    }

	public function cari($user_id, $profil_id, $profesi_id, Request $request)
    {
        $this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
        $this->data['profesi_id']   = $profesi_id;

        $cari = $request->cari;
        $this->data['aksi']         = 'cari';
        
        $this->data['tamu']  		= Tamu::where('nama','like',"%".$cari."%")
                                        ->orWhere('nip','like',"%".$cari."%")
										->orWhere('nik','like',"%".$cari."%")
										->orWhere('email','like',"%".$cari."%")
										->orWhere('hp','like',"%".$cari."%")
										->orderBy('nama', 'ASC')
                                        ->paginate(10);

        $this->data['tamu']->appends($request->only('cari'));
        return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_tiket($user_id, $profil_id, $profesi_id, $tamu_id, Request $request)
    {
        $this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
		$this->data['profesi_id']   = $profesi_id;
		$this->data['tamu_id']   	= $tamu_id;

        $cari = $request->cari;
        $this->data['aksi']         = 'cari';
		
		$this->data['tamu']  		= Tamu::find(Crypt::decrypt($tamu_id));
        $this->data['konsultasi']  	= Konsultasi::select('*', DB::raw('count(konsultasi.tiket_id) as total'))
										->join('tiket', 'tiket.id', '=', 'konsultasi.tiket_id')
										->join('tamu', 'tamu.id', '=', 'tiket.tamu_id')
										->where('tiket.tamu_id', '=', Crypt::decrypt($tamu_id))
										->where('tiket.nomor', 'like', "%".$cari."%")
										->groupBy('tiket.nomor')
										->orderBy('tiket.created_at', 'desc')
										->paginate(10);

        $this->data['konsultasi']->appends($request->only('cari'));
        return view($this->data['view_riwayat'], $this->data);
    }
}

