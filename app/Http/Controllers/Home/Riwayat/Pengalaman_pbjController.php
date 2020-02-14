<?php

namespace App\Http\Controllers\Home\Riwayat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Aktor\Operator\Sarana\Pelaku_pbj;
use App\Models\Home\Riwayat\Pengalaman_pbj;

class Pengalaman_pbjController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'pengalaman_pbj',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/riwayat/pengalaman_pbj',
		'link_sampah'       => '',
		'view_utama' 		=> 'home/riwayat/pengalaman_pbj/detil',
		'view_form' 	 	=> 'home/riwayat/pengalaman_pbj/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id)
    {
		$this->data['user_id'] 			= $user_id;
		$this->data['profil_id'] 		= $profil_id;

		$this->data['pengalaman_pbj'] 	= Pengalaman_pbj::where('profil_id', '=', Crypt::decrypt($profil_id))->orderBy('tahun', 'DESC')->paginate(10);

		return view($this->data['view_utama'], $this->data);
    }

    public function tambah($user_id, $profil_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;

		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/riwayat/pengalaman_pbj/store/".$user_id.'/'.$profil_id;
		$this->data['pelaku_pbj'] 	= Pelaku_pbj::all();

		return view($this->data['view_form'], $this->data);
    }

    public function store($user_id, $profil_id, Request $request)
    {
		$pesan = [
            'required'      	=> 'Wajib diisi.',
            'numeric'       	=> 'Wajib angka.',
			'digits'        	=> 'Jumlah karakter harus :digits.',
			'unique'        	=> 'Data :unique sudah ada.',
		];

		$this->validate($request,[
    		'pelaku_pbj_id' 	=> 'required',
			'kode_paket' 		=> 'required|numeric',
			'nama_paket'		=> 'required',
			'nilai_paket'		=> 'required',
			'tahun'				=> 'required|numeric|digits:4',
    	], $pesan);
 
        Pengalaman_pbj::create([
			'profil_id'			=> Crypt::decrypt($profil_id),
			'kode_paket' 		=> $request->kode_paket,
			'nama_paket' 		=> $request->nama_paket,
			'nilai_paket' 		=> $request->nilai_paket,
			'pelaku_pbj_id' 	=> $request->pelaku_pbj_id,
			'tahun'				=> $request->tahun,
    	]);
 
    	return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Pengalaman_pbj berhasil ditambah.']);
    }

    public function lihat($user_id, $profil_id, $pengalaman_pbj_id)
	{
		$this->data['user_id'] 			= $user_id;
		$this->data['profil_id'] 		= $profil_id;
		$this->data['pengalaman_pbj_id'] 	= $pengalaman_pbj_id;

		$this->data['aksi'] 			= "lihat";
		$this->data['pengalaman_pbj'] 		= Pengalaman_pbj::find(Crypt::decrypt($pengalaman_pbj_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $pengalaman_pbj_id)
	{
		$this->data['user_id'] 			= $user_id;
		$this->data['profil_id'] 		= $profil_id;
		$this->data['pengalaman_pbj_id'] 	= $pengalaman_pbj_id;

		$this->data['aksi'] 			= "ubah";
		$this->data['form_action'] 		= "/riwayat/pengalaman_pbj/update/".$user_id.'/'.$profil_id.'/'.$pengalaman_pbj_id;
		$this->data['pengalaman_pbj'] 	= Pengalaman_pbj::find(Crypt::decrypt($pengalaman_pbj_id));
		$this->data['pelaku_pbj'] 		= Pelaku_pbj::all();
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $pengalaman_pbj_id, Request $request)
	{
		$pesan = [
            'required'      	=> 'Wajib diisi.',
            'numeric'       	=> 'Wajib angka.',
			'digits'       		=> 'Jumlah karakter harus :digits.',
			'unique'        	=> 'Data :unique sudah ada.',
		];

		$this->validate($request,[
			'pelaku_pbj_id' 	=> 'required',
			'kode_paket' 		=> 'required|numeric',
			'nama_paket'		=> 'required',
			'nilai_paket'		=> 'required',
			'tahun'				=> 'required|numeric|digits:4',
	    ], $pesan);

	    $isi 					= Pengalaman_pbj::find(Crypt::decrypt($pengalaman_pbj_id));

		$isi->kode_paket		= $request->kode_paket;
		$isi->nama_paket 		= $request->nama_paket;
		$isi->nilai_paket 		= $request->nilai_paket;
		$isi->pelaku_pbj_id 	= $request->pelaku_pbj_id;
		$isi->tahun				= $request->tahun;

	    $isi->save();
	    return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Pengalaman_pbj berhasil diubah.']);
	}

	public function hapus($user_id, $profil_id, $pengalaman_pbj_id)
	{
        $isi 				= Pengalaman_pbj::find(Crypt::decrypt($pengalaman_pbj_id));
		$isi->delete();
		
	    return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Pengalaman_pbj berhasil dihapus.']);
	}

	public function cari($user_id, $profil_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;

		$cari 	= $request->cari;
		$this->data['aksi'] 			= "cari";
		$this->data['pengalaman_pbj'] 	= Pengalaman_pbj::orderBy('tahun', 'DESC')
											->where('kode_paket','like',"%".$cari."%")
											->orWhere('nama_paket','like',"%".$cari."%")
											->orWhere('nilai_paket','like',"%".$cari."%")
											->orWhereHas('pelaku_pbj', function($q) use($cari){
												return $q->where('nama','like',"%".$cari."%")->orWhere('alias', 'like',"%".$cari."%");
											})
											->paginate(10);
		
		$this->data['pengalaman_pbj']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
	}
}