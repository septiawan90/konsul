<?php

namespace App\Http\Controllers\Aktor\Operator\Legal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;
use App\Models\Aktor\Operator\Legal\Role;
use App\Models\Aktor\Operator\Legal\Sk;

class SkController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'sk',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/legal',
		'aksi'        		=> '',
		'link'         		=> '/operator/legal',
		'link_sampah'       => '/operator/legal/sk/sampah',
		'view_utama' 		=> 'aktor/operator/legal/sk/index',
		'view_form' 	 	=> 'aktor/operator/legal/sk/form',
		'view_sampah' 	 	=> 'aktor/operator/legal/sk/sampah',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['sk'] = Sk::orderBy('tanggal', 'DESC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

	public function tambah($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/operator/legal/sk/store/".$user_id."/".$profil_id."/".$profesi_id;
		$this->data['role'] 		= Role::all();

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
			'nomor' 		=> 'required',
			'tanggal' 		=> 'required',
			'tentang' 		=> 'required',
			'kadaluarsa' 	=> 'required',
			'role_id' 		=> 'required',
			'file' 			=> 'required|file|mimes:pdf|max:2048',
		], $pesan);
		
		$file 				= $request->file('file');
		$nama_file 			= time()."_".$file->getClientOriginalName();
		
        Sk::create([
    		'nomor' 		=> $request->nomor,
			'tanggal' 		=> date("Y-m-d", strtotime($request->tanggal)),
			'tentang' 		=> $request->tentang,
			'kadaluarsa' 	=> date("Y-m-d", strtotime($request->kadaluarsa)),
			'role_id' 		=> $request->role_id,
			'akreditasi' 	=> $request->akreditasi,
			'file' 			=> Storage::putFile('public/file_sk', $file),
			'created_by' 	=> Crypt::decrypt($profil_id)
    	]);
 
		return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'SK '.$request->nomor.' berhasil ditambah.']);
	}
	
	public function lihat($user_id, $profil_id, $profesi_id, $sk_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['sk_id'] 		= $sk_id;

		$this->data['aksi'] 		= "lihat";
		$this->data['sk'] 			= Sk::find(Crypt::decrypt($sk_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $profesi_id, $sk_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['sk_id'] 		= $sk_id;

		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/operator/legal/sk/update/".$user_id."/".$profil_id."/".$profesi_id."/".$sk_id;

		$this->data['role'] 		= Role::all();
		$this->data['sk'] 			= Sk::find(Crypt::decrypt($sk_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $profesi_id, $sk_id, Request $request)
	{
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];
		
		$this->validate($request,[
			'nomor' 		=> 'required',
			'tanggal' 		=> 'required',
			'tentang' 		=> 'required',
			'kadaluarsa' 	=> 'required',
			'role_id' 		=> 'required',
			'file' 			=> 'nullable|file|mimes:pdf|max:2048',
	    ], $pesan);

		$isi 				= Sk::find(Crypt::decrypt($sk_id));

		if(is_null($request->file('file')))
		{		
			$isi->nomor 		= $request->nomor;
			$isi->tanggal 		= date("Y-m-d", strtotime($request->tanggal));
			$isi->tentang 		= $request->tentang;
			$isi->kadaluarsa 	= date("Y-m-d", strtotime($request->kadaluarsa));
			$isi->role_id 		= $request->role_id;
			$isi->akreditasi 	= $request->akreditasi;
			$isi->updated_by 	= Crypt::decrypt($profil_id);
		}
		else
		{
			$file 				= $request->file('file');

			$isi->nomor 		= $request->nomor;
			$isi->tanggal 		= date("Y-m-d", strtotime($request->tanggal));
			$isi->tentang 		= $request->tentang;
			$isi->kadaluarsa 	= date("Y-m-d", strtotime($request->kadaluarsa));
			$isi->role_id 		= $request->role_id;
			$isi->akreditasi 	= $request->akreditasi;
			$isi->file 			= Storage::putFile('public/file_sk', $file);
			$isi->updated_by 	= Crypt::decrypt($profil_id);
		}

		$isi->save();
		
		return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'SK '.$request->nomor.' berhasil diubah.']);
	}

	public function unduh($user_id, $profil_id, $profesi_id, $sk_id)
	{
		$model_file = Sk::findOrFail(Crypt::decrypt($sk_id)); //Mencari model atau objek yang dicari
		return Storage::download($model_file->file);
   }

   	public function cari($user_id, $profil_id, $profesi_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['aksi'] 		= "cari";

		$cari 	= $request->cari;
		$this->data['sk']  = Sk::where('nomor','like',"%".$cari."%")
										->orWhere('tentang','like',"%".$cari."%")
										->orWhereHas('role', function($q) use($cari)
										{
											return $q->where('name', 'like', '%'.$cari.'%');
										})
										->orderBy('tanggal', 'DESC')
										->paginate(10);
		$this->data['sk']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
	
	public function hapus($user_id, $profil_id, $profesi_id, $sk_id)
	{
		$isi 				= Sk::find(Crypt::decrypt($id));
		$isi->deleted_by 	= Crypt::decrypt($profil_id);
		
		$isi->delete();
		$isi->save();

	    return redirect()->back();
	}

	public function sampah($user_id, $profil_id, $profesi_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['subjudul'] 	= "sampah";

		$this->data['sk'] = Sk::onlyTrashed()->orderBy('tanggal', 'DESC')->paginate(10);
		return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($user_id, $profil_id, $profesi_id, $sk_id)
	{
        $isi   = Sk::onlyTrashed()->where('id', Crypt::decrypt($sk_id));
		$isi->restore();
		
    	return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Data sampah SK berhasil dikembalikan.']);
	}

	public function kembalikan_semua($user_id, $profil_id, $profesi_id)
	{		
		$isi = Sk::onlyTrashed();
		
		if($isi->count() > 0)
		{
			$isi->restore();
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Semua data sampah SK berhasil dikembalikan.']);
		}
		else
		{
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Tidak ada data sampah SK yang dikembalikan.']);
		}
	}

	public function hapus_permanen($user_id, $profil_id, $profesi_id, $sk_id)
	{
        $isi   = Sk::onlyTrashed()->where('id', Crypt::decrypt($sk_id));
    	$isi->forceDelete();

		return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Data sampah KLPD berhasil dihapus permanen.']);
	}

	public function hapus_permanen_semua($user_id, $profil_id, $profesi_id)
	{
		$isi = Klpd::onlyTrashed();
		
		if($isi->count() > 0)
		{
			$isi->forceDelete();
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Semua data sampah SK berhasil dihapus permanen.']);
		}
		else
		{
			return redirect($this->data['link_sampah'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'Tidak ada data sampah SK yang dihapus permanen.']);
		}
	}
}