<?php

namespace App\Http\Controllers\Home\Riwayat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Aktor\Operator\Sarana\Strata;
use App\Models\Home\Riwayat\Pendidikan;

class PendidikanController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'pendidikan',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/riwayat/pendidikan',
		'link_sampah'       => '',
		'view_utama' 		=> 'home/riwayat/pendidikan/detil',
		'view_form' 	 	=> 'home/riwayat/pendidikan/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;

		$this->data['pendidikan'] 	= Pendidikan::where('profil_id', '=', Crypt::decrypt($profil_id))->orderBy('thn_lulus', 'DESC')->paginate(10);

		return view($this->data['view_utama'], $this->data);
    }

    public function tambah($user_id, $profil_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;

		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/riwayat/pendidikan/store/".$user_id.'/'.$profil_id;
		$this->data['strata'] 		= Strata::orderBy('level', 'DESC')->orderBy('id', 'DESC')->get();

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
    		'strata_id' 		=> 'required',
			'thn_lulus' 		=> 'required|numeric|digits:4',
			'institusi'			=> 'required',
    	], $pesan);
 
        Pendidikan::create([
			'profil_id'			=> Crypt::decrypt($profil_id),
			'strata_id' 		=> $request->strata_id,
			'thn_lulus' 		=> $request->thn_lulus,
			'institusi'			=> $request->institusi,
    	]);
 
    	return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Pendidikan berhasil ditambah.']);
    }

    public function lihat($user_id, $profil_id, $pendidikan_id)
	{
		$this->data['user_id'] 			= $user_id;
		$this->data['profil_id'] 		= $profil_id;
		$this->data['pendidikan_id'] 	= $pendidikan_id;

		$this->data['aksi'] 			= "lihat";
		$this->data['pendidikan'] 		= Pendidikan::find(Crypt::decrypt($pendidikan_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $pendidikan_id)
	{
		$this->data['user_id'] 			= $user_id;
		$this->data['profil_id'] 		= $profil_id;
		$this->data['pendidikan_id'] 	= $pendidikan_id;

		$this->data['aksi'] 			= "ubah";
		$this->data['form_action'] 		= "/riwayat/pendidikan/update/".$user_id.'/'.$profil_id.'/'.$pendidikan_id;
		$this->data['pendidikan'] 		= Pendidikan::find(Crypt::decrypt($pendidikan_id));
		$this->data['strata'] 			= Strata::orderBy('level', 'DESC')->orderBy('id', 'DESC')->get();
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $pendidikan_id, Request $request)
	{
		$pesan = [
            'required'      	=> 'Wajib diisi.',
            'numeric'       	=> 'Wajib angka.',
			'digits'       		=> 'Jumlah karakter harus :digits.',
			'unique'        	=> 'Data :unique sudah ada.',
		];

		$this->validate($request,[
			'strata_id' 		=> 'required',
			'thn_lulus' 		=> 'required|numeric|digits:4',
			'institusi'			=> 'required',
	    ], $pesan);

	    $isi 					= Pendidikan::find(Crypt::decrypt($pendidikan_id));

	    $isi->strata_id 		= $request->strata_id;
		$isi->thn_lulus 		= $request->thn_lulus;
		$isi->institusi 		= $request->institusi;

	    $isi->save();
	    return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Pendidikan berhasil diubah.']);
	}

	public function hapus($user_id, $profil_id, $pendidikan_id)
	{
        $isi 				= Pendidikan::find(Crypt::decrypt($pendidikan_id));
		$isi->delete();
		
	    return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Pendidikan berhasil dihapus.']);
	}

	public function cari($user_id, $profil_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;

		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['pendidikan'] 	= Pendidikan::orderBy('thn_lulus', 'DESC')
									->where('thn_lulus','like',"%".$cari."%")
									->orWhere('institusi','like',"%".$cari."%")
									->orWhereHas('strata', function($q) use($cari){
										return $q->where('nama', 'like', '%'.$cari.'%');
									})
									->paginate(10);
		
		$this->data['pendidikan']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
	}
}