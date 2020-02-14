<?php

namespace App\Http\Controllers\Aktor\Lpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;
use App\Models\Aktor\Lpp\Owner;
use App\Models\Aktor\Lpp\Profil;
use App\Models\Aktor\Lpp\Surat;

use Illuminate\Support\Facades\Mail;
use App\Mail\Notif_surat;
use App\Roles;

class SuratController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'surat',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'lpp',
		'aksi'        		=> '',
		'link'         		=> '/lpp',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/lpp/surat/index',
		'view_form' 	 	=> 'aktor/lpp/surat/form',
		'view_sampah' 	 	=> 'aktor/lpp/surat/sampah',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id, $lpp_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		//$owner_id 				= Owner::find(Auth::user()->profil->id)->id;
		//$this->data['lpp_id'] 	= Profil::where('profil_id', '=', $profil_id)->first()->id;
		$this->data['surat'] 		= Surat::orderBy('tanggal', 'DESC')->where('lpp_id', '=', Crypt::decrypt($lpp_id))->paginate(10);
		
		return view($this->data['view_utama'], $this->data);
    }

	public function tambah($user_id, $profil_id, $lpp_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;

		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['judul']."/store/".$user_id.'/'.$profil_id.'/'.$lpp_id;

		return view($this->data['view_form'], $this->data);
    }

    public function store($user_id, $profil_id, $lpp_id, Request $request)
    {
		//cari operator monev
		$operator = Roles::select('users.email')
						->join('model_has_roles as mhr', 'mhr.role_id', '=', 'roles.id')
						->join('users', 'users.id', '=', 'mhr.model_id')
						->join('sk', 'sk.role_id', '=', 'roles.id')
						->where('mhr.role_id', '=', '9')
						->orWhere('mhr.role_id', '=', '1')
						->where('sk.kadaluarsa', '>', date('Y-m-d'))
						->get();
		
		$dari 		= Profil::find(Crypt::decrypt($lpp_id))->first();	 

		$details 	= [
			'title' => 'Surat Baru : Nomor '.$request->nomor,
			'body' 	=> 'Dari : '.$dari->nama.'<br>Alias : '.$dari->alias.'<br>Nomor : '.$request->nomor.'<br>Tanggal : '.tanggal($request->tanggal).'<br>Tentang : '.$request->tentang
		];

		foreach($operator as $monev)
		{
			Mail::to($monev->email)->send(new Notif_surat($details));
		}

		var_dump('berhasil'); die;
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
			'file' 			=> 'required|file|mimes:pdf|max:2048',
		], $pesan);
		
		$file 				= $request->file('file');
		
        Surat::create([
    		'nomor' 		=> $request->nomor,
			'tanggal' 		=> date('Y-m-d', strtotime($request->tanggal)),
			'tentang' 		=> $request->tentang,
			'lpp_id' 		=> Crypt::decrypt($lpp_id),
			'file' 			=> Storage::putFile('public/file_surat', $file)
		]);
 
    	return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id)->with(['sukses' => 'Surat nomor '.$request->nomor.' berhasil ditambah.']);
	}
	
    public function lihat($user_id, $profil_id, $lpp_id, $surat_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		
		$this->data['aksi'] 		= "lihat";
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $lpp_id, $surat_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;

		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['judul']."/update/".$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id;
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $lpp_id, $surat_id, Request $request)
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
			'file' 			=> 'nullable|file|mimes:pdf|max:2048',
	    ], $pesan);

		$file 				= $request->file('file');
		$isi 				= Surat::find(Crypt::decrypt($surat_id));	

		$isi->nomor 		= $request->nomor;
		$isi->tanggal 		= date("Y-m-d", strtotime($request->tanggal));
		$isi->tentang 		= $request->tentang;

		if($file)
		{
			$isi->file 		= Storage::putFile('public/file_surat', $file); #$nama_file;
		}

		$isi->save();
		
		return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id)->with(['sukses' => 'Surat nomor '.$request->nomor.' berhasil diubah.']);
	}

	public function unduh($user_id, $profil_id, $lpp_id, $surat_id)
	{
		$model_file = Surat::findOrFail(Crypt::decrypt($surat_id)); //Mencari model atau objek yang dicari
		return Storage::download($model_file->file);
   }

   	public function cari($user_id, $profil_id, $lpp_id, Request $request)
    {
		$cari 	= $request->cari;
		
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;

		$this->data['aksi'] 		= "cari";
		$this->data['surat']    	= Surat::where('nomor','like',"%".$cari."%")
										->orWhere('tentang','like',"%".$cari."%")
										->orderBy('tanggal', 'DESC')
										->where('lpp_id', '=', Crypt::decrypt($lpp_id))
										->orderBy('tanggal', 'DESC')
										->paginate(10);

		$this->data['surat']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
	
	public function hapus($user_id, $profil_id, $lpp_id, $surat_id)
	{
		$isi = Surat::find(Crypt::decrypt($surat_id));
		$isi->delete();
		$isi->save();

	    return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id)->with(['success' => 'Surat berhasil dihapus.']);
	}
}