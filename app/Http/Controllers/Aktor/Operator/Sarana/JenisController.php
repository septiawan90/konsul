<?php

namespace App\Http\Controllers\Aktor\Operator\Sarana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Aktor\Operator\Sarana\Jenis;

class JenisController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'jenis',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/sarana',
		'aksi'        		=> '',
		'link'         		=> '/operator/sarana',
		'link_sampah'       => '/operator/sarana/jenis/sampah',
		'view_utama' 		=> 'aktor/operator/sarana/jenis/index',
		'view_form' 	 	=> 'aktor/operator/sarana/jenis/form',
		'view_sampah' 	 	=> 'aktor/operator/sarana/jenis/sampah',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['jenis'] = Jenis::orderBy('nama', 'ASC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

    public function tambah($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/operator/sarana/jenis/store/".$user_id.'/'.$profil_id.'/'.$profesi_id;

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
			'nama' 				=> 'required'
    	], $pesan);
 
        Jenis::create([
    		'kode' 				=> $request->kode,
			'nama' 				=> $request->nama,
			'fungsi' 			=> $request->fungsi,
			'created_by' 		=> Auth::user()->profil->first()->id
    	]);
 
    	return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Jenis '.$request->nama.' berhasil ditambah.']);
    }

    public function lihat($user_id, $profil_id, $profesi_id, $jenis_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['jenis_id'] 	= $jenis_id;

		$this->data['aksi'] 		= "lihat";
		$this->data['jenis'] 		= Jenis::find(Crypt::decrypt($jenis_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $profesi_id, $jenis_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['jenis_id'] 	= $jenis_id;

		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/operator/sarana/jenis/update/".$user_id.'/'.$profil_id.'/'.$profesi_id.'/'.$jenis_id;
		$this->data['jenis'] 		= Jenis::find(Crypt::decrypt($jenis_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $profesi_id, $jenis_id, Request $request)
	{
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];

		$this->validate($request,[
			'kode' 				=> 'nullable',
			'nama' 				=> 'required'
	    ], $pesan);

	    $isi 					= Jenis::find(Crypt::decrypt($jenis_id));

	    $isi->kode 				= $request->kode;
		$isi->nama 				= $request->nama;
		$isi->fungsi 			= $request->fungsi;
		$isi->updated_by 		= Crypt::decrypt($profil_id);
		$isi->save();
		
	    return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Jenis '.$request->nama.' berhasil diubah.']);
	}

	public function hapus($user_id, $profil_id, $profesi_id, $jenis_id)
	{
        $isi 				= Jenis::find(Crypt::decrypt($jenis_id));
		$isi->deleted_by 	= Crypt::decrypt($profil_id);
		
		$isi->delete();
		$isi->save();
		
	    return redirect($this->data['link']);
	}

	public function sampah($user_id, $profil_id, $profesi_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['subjudul'] 	= "sampah";
		$this->data['jenis'] 		= Jenis::orderBy('nama', 'ASC')->onlyTrashed()->paginate(10);

    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($user_id, $profil_id, $profesi_id, $jenis_id)
	{
		$isi   = Jenis::onlyTrashed()->where('id', Crypt::decrypt($jenis_id));
		$isi->restore();

		return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Data sampah Jenis berhasil dikembalikan.']);
	}

	public function kembalikan_semua($user_id, $profil_id, $profesi_id)
	{		
		$isi = Jenis::onlyTrashed();
		
		if($isi->count() > 0)
		{
			$isi->restore();
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Semua data sampah Jenis berhasil dikembalikan.']);
		}
		else
		{
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Tidak ada data sampah Jenis yang dikembalikan.']);
		}
	}

	public function hapus_permanen($user_id, $profil_id, $profesi_id, $jenis_id)
	{
		$isi   = Jenis::onlyTrashed()->where('id', Crypt::decrypt($jenis_id));
    	$isi->forceDelete();

		return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Data sampah Jenis berhasil dihapus permanen.']);
	}

	public function hapus_permanen_semua($user_id, $profil_id, $profesi_id)
	{
		$isi = Jenis::onlyTrashed();
		
		if($isi->count() > 0)
		{
			$isi->forceDelete();
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Semua data sampah Jenis berhasil dihapus permanen.']);
		}
		else
		{
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Tidak ada data sampah Jenis yang dihapus permanen.']);
		}
	}

	public function cari($user_id, $profil_id, $profesi_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$cari 	= $request->cari;
		$this->data['aksi'] 		= "cari";
		$this->data['jenis'] 		= Jenis::orderBy('nama', 'ASC')
										->where('kode','like',"%".$cari."%")
										->orWhere('nama','like',"%".$cari."%")
										->orWhere('fungsi','like',"%".$cari."%")
										->whereNull('deleted_at')
										->paginate(10);
		
		$this->data['jenis']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah($user_id, $profil_id, $profesi_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$cari 	= $request->cari;
		$this->data['aksi'] 		= "cari";
		$this->data['jenis'] 		= Jenis::onlyTrashed()
										->where('kode','like',"%".$cari."%")
										->orWhere('nama','like',"%".$cari."%")
										->orWhere('fungsi','like',"%".$cari."%")
										->whereNotNull('deleted_at')
										->paginate(10);
		
		$this->data['jenis']->appends($request->only('cari'));									
					
		return view($this->data['view_utama'], $this->data);
    }
}