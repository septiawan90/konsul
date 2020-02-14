<?php

namespace App\Http\Controllers\Aktor\Operator\Sarana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Aktor\Operator\Sarana\Klpd;

class KlpdController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'klpd',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/sarana',
		'aksi'        		=> '',
		'link'         		=> '/operator/sarana',
		'link_sampah'       => '/operator/sarana/klpd/sampah',
		'view_utama' 		=> 'aktor/operator/sarana/klpd/index',
		'view_form' 	 	=> 'aktor/operator/sarana/klpd/form',
		'view_sampah' 	 	=> 'aktor/operator/sarana/klpd/sampah',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		
		$this->data['klpd'] = Klpd::orderBy('kode', 'ASC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

    public function tambah($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/operator/sarana/klpd/store/".$user_id.'/'.$profil_id.'/'.$profesi_id;

		return view($this->data['view_form'], $this->data);
    }

    public function store($user_id, $profil_id, $profesi_id, Request $request)
    {
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];

		$this->validate($request,[
    		'kode' 				=> 'nullable',
			'nama' 				=> 'required',
			'alias' 			=> 'nullable',
    	], $pesan);
 
        Klpd::create([
    		'kode' 				=> $request->kode,
			'nama' 				=> $request->nama,
			'alias' 			=> $request->alias,
			'created_by' 		=> Crypt::decrypt($profil_id)
    	]);
 
		return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'KLPD '.$request->nama.' berhasil ditambah.']);
    }

    public function lihat($user_id, $profil_id, $profesi_id, $klpd_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['klpd_id'] 		= $klpd_id;

		$this->data['aksi'] 		= "lihat";
		$this->data['klpd'] 		= Klpd::find(Crypt::decrypt($klpd_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $profesi_id, $klpd_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['klpd_id'] 		= $klpd_id;

		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/operator/sarana/klpd/update/".$user_id.'/'.$profil_id.'/'.$profesi_id.'/'.$klpd_id;
		$this->data['klpd'] 		= Klpd::find(Crypt::decrypt($klpd_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $profesi_id, $klpd_id, Request $request)
	{
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];

		$this->validate($request,[
			'kode' 				=> 'nullable',
			'nama' 				=> 'required',
			'alias' 			=> 'nullable',
	    ], $pesan);

	    $isi 					= Klpd::find(Crypt::decrypt($klpd_id));

	    $isi->kode 				= $request->kode;
		$isi->nama 				= $request->nama;
		$isi->alias 			= $request->alias;
		$isi->updated_by 		= Crypt::decrypt($profil_id);

	    $isi->save();
		return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'KLPD '.$request->nama.' berhasil diubah.']);
	}

	public function hapus($user_id, $profil_id, $profesi_id, $klpd_id)
	{
        $isi 				= Klpd::find(Crypt::decrypt($klpd_id));
		$isi->deleted_by 	= Crypt::decrypt($profil_id);
		
		$isi->delete();
		$isi->save();
		
	    return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'KLPD '.$isi->nama.' berhasil dihapus.']);
	}

	public function sampah($user_id, $profil_id, $profesi_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['subjudul'] 	= "sampah";
		$this->data['klpd'] 		= Klpd::orderBy('nama', 'ASC')->onlyTrashed()->paginate(10);

    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($user_id, $profil_id, $profesi_id, $klpd_id)
	{
        $isi   = Klpd::onlyTrashed()->where('id', Crypt::decrypt($klpd_id));
		$isi->restore();

		return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Data sampah KLPD berhasil dikembalikan.']);
	}

	public function kembalikan_semua($user_id, $profil_id, $profesi_id)
	{		
		$isi = Klpd::onlyTrashed();
		
		if($isi->count() > 0)
		{
			$isi->restore();
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Semua data sampah KLPD berhasil dikembalikan.']);
		}
		else
		{
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Tidak ada data sampah KLPD yang dikembalikan.']);
		}
	}

	public function hapus_permanen($user_id, $profil_id, $profesi_id, $klpd_id)
	{
        $isi = Klpd::onlyTrashed()->where('id', Crypt::decrypt($klpd_id));
    	$isi->forceDelete();

		return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Data sampah KLPD berhasil dihapus permanen.']);
	}

	public function hapus_permanen_semua($user_id, $profil_id, $profesi_id)
	{
		$isi = Klpd::onlyTrashed();
		
		if($isi->count() > 0)
		{
			$isi->forceDelete();
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Semua data sampah KLPD berhasil dihapus permanen.']);
		}
		else
		{
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Tidak ada data sampah KLPD yang dihapus permanen.']);
		}
	}

	public function cari($user_id, $profil_id, $profesi_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['klpd'] 	= Klpd::orderBy('nama', 'ASC')
									->where('kode','like',"%".$cari."%")
									->orWhere('nama','like',"%".$cari."%")
									->orWhere('alias','like',"%".$cari."%")
									->whereNull('deleted_at')
									->paginate(10);
		
		$this->data['klpd']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah($user_id, $profil_id, $profesi_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['klpd'] 	= Klpd::onlyTrashed()
									->where('kode','like',"%".$cari."%")
									->orWhere('nama','like',"%".$cari."%")
									->orWhere('alias','like',"%".$cari."%")
									->whereNotNull('deleted_at')
									->paginate(10);
		
		$this->data['klpd']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
    }
}