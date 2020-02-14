<?php

namespace App\Http\Controllers\Aktor\Operator\Sarana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\User;
use App\Profil;
use App\Models\Daerah\Kota;
use App\Models\Aktor\Operator\Sarana\Jenis;
use App\Models\Aktor\Operator\Sarana\Lpp;

class LppController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'lpp',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/sarana',
		'aksi'        		=> '',
		'link'         		=> '/operator/sarana',
		'link_sampah'       => '/operator/sarana/lpp/sampah',
		'view_utama' 		=> 'aktor/operator/sarana/lpp/index',
		'view_form' 	 	=> 'aktor/operator/sarana/lpp/form',
		'view_sampah' 	 	=> 'aktor/operator/sarana/lpp/sampah',
		'view_cari_owner' 	=> 'aktor/operator/sarana/lpp/cari_owner',
		'view_telusur' 		=> 'aktor/operator/sarana/lpp/telusur',
		'form_action'   	=> '',
	);

	public function cari_owner($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['aksi'] 		= "cari";
		return view($this->data['view_cari_owner'], $this->data);
	}

	public function telusur($user_id, $profil_id, $profesi_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$pesan = [
            'required'    => 'Wajib diisi.',
			'min'         => 'Minimal 16 Karakter.',
			'numeric'     => 'Wajib angka.',
			'digits'      => 'Jumlah karakter harus :digits digit.',
        ];

        $this->validate($request, ['cari'=>'required|numeric|digits:16'], $pesan);

        if(empty($request->cari))
        {
			return "<div class='alert alert-warning'> NIK ".$request->cari." Tidak Ditemukan</div>";
        }
        else
        {
            $cari 					= $request->cari;
			$this->data['profil'] 	= Profil::whereHas('user', function($q) use($cari)
										{
											return $q->where('nik','like',"%".$cari."%");
										})->paginate(10);
     
            return view($this->data['view_telusur'], $this->data);
        }
    }

	public function index($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['lpp'] = Lpp::orderBy('nama', 'ASC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

    public function tambah($user_id, $profil_id, $profesi_id, $owner_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['owner_id'] 	= $owner_id;
		
		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/operator/sarana/lpp/store/".$user_id.'/'.$profil_id.'/'.$profesi_id.'/'.$owner_id;
		$this->data['owner'] 		= Profil::find(Crypt::decrypt($owner_id));
		$this->data['pilih'] 		= Kota::all();
		$this->data['pilih2'] 		= Jenis::all();

		return view($this->data['view_form'], $this->data);
    }

    public function store($user_id, $profil_id, $profesi_id, $owner_id, Request $request)
    {
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];

		$this->validate($request,[
			'kode' 			=> 'nullable',
			'nama' 			=> 'required',
			'alias'         => 'nullable',
			'alamat'        => 'required',
			'jenis_id'      => 'required',
			'email'        	=> 'required|email',
			'telp'        	=> 'required|numeric',
			'kota_id' 		=> 'required'
    	], $pesan);
 
        Lpp::create([
    		'kode' 			=> $request->kode,
			'profil_id' 	=> Crypt::decrypt($owner_id),
			'nama' 			=> $request->nama,
			'alias' 		=> $request->alias,
			'alamat' 		=> $request->alamat,
			'jenis_id' 		=> $request->jenis_id,
			'email' 		=> $request->email,
			'telp' 			=> $request->telp,
			'kota_id' 		=> $request->kota_id,
			'created_by' 	=> Crypt::decrypt($profil_id)
    	]);
 
		return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'LPP '.$request->nama.' berhasil ditambah.']);
    }

	public function lihat($user_id, $profil_id, $profesi_id, $lpp_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['lpp_id'] 		= $lpp_id;

		$this->data['aksi'] 		= "lihat";
		$this->data['pilih'] 		= Kota::all();
		$this->data['pilih2'] 		= Jenis::all();
		$this->data['lpp']			= Lpp::find(Crypt::decrypt($lpp_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $profesi_id, $lpp_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['lpp_id'] 		= $lpp_id;

		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/operator/sarana/lpp/update/".$user_id.'/'.$profil_id.'/'.$profesi_id.'/'.$lpp_id;

		$this->data['owner'] 		= User::all();
		$this->data['pilih'] 		= Kota::all();
		$this->data['pilih2'] 		= Jenis::all();
		$this->data['lpp']			= Lpp::find(Crypt::decrypt($lpp_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $profesi_id, $lpp_id, Request $request)
	{
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];

		$this->validate($request,[
			'profil_id' 	=> 'required',
			'kode' 			=> 'nullable',
			'nama' 			=> 'required',
			'alias'         => 'nullable',
			'alamat'        => 'required',
			'jenis_id'      => 'required',
			'email'        	=> 'required|email',
			'telp'        	=> 'required|numeric',
			'kota_id' 		=> 'required'
	    ], $pesan);

	    $isi 					= Lpp::find(Crypt::decrypt($lpp_id));

		$isi->profil_id 		= $request->profil_id;
		$isi->kode 				= $request->kode;
		$isi->nama 				= $request->nama;
		$isi->alias 			= $request->alias;
		$isi->alamat 			= $request->alamat;
		$isi->jenis_id 			= $request->jenis_id;
		$isi->email 			= $request->email;
		$isi->telp 				= $request->telp;
		$isi->kota_id 			= $request->kota_id;
		$isi->updated_by 		= Crypt::decrypt($profil_id);

	    $isi->save();
	    return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)->with(['success' => 'LPP '.$request->nama.' berhasil diubah.']);
	}

	public function hapus($id)
	{
        $isi 				= Lpp::find(Crypt::decrypt($id));
		$isi->deleted_by 	= Auth::user()->id;
		
		$isi->delete();
		$isi->save();
		
	    return redirect($this->data['link'].'/lpp');
	}

	public function sampah()
	{
		$this->data['subjudul'] = "sampah";

		$this->data['lpp'] = Lpp::orderBy('nama', 'ASC')->onlyTrashed()->paginate(10);
    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Lpp::onlyTrashed()->where('id', Crypt::decrypt($id));
		$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Lpp::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
        $isi   = Lpp::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Lpp::onlyTrashed();
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function cari($user_id, $profil_id, $profesi_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$cari 						= $request->cari;
		$this->data['aksi'] 		= "cari";
		$this->data['lpp'] 			= Lpp::orderBy('nama', 'ASC')
										->where('kode','like',"%".$cari."%")
										->orWhere('nama','like',"%".$cari."%")
										->orWhere('alias','like',"%".$cari."%")
										->orWhereHas('kota', function($q) use($cari)
										{
											return $q->where('nama','like',"%".$cari."%");
										})
										->whereNull('deleted_at')
										->paginate(10);
		
		$this->data['lpp']->appends($request->only('cari'));
		
		return view($this->data['view_utama'], $this->data);
		
		// if(!$this->data['lpp']->isEmpty()) {
		// 	return view($this->data['view_utama'], $this->data);
		// }  
		// else 
		// {
		// 	abort(404);
		// }
	}
	
	public function cari_sampah($user_id, $profil_id, $profesi_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$cari 						= $request->cari;
		$this->data['aksi'] 		= "cari";
		$this->data['lpp'] 			= Lpp::onlyTrashed()
										->where('kode','like',"%".$cari."%")
										->orWhere('nama','like',"%".$cari."%")
										->orWhere('alias','like',"%".$cari."%")
										->orWhereHas('kota', function($q) use($cari)
										{
											return $q->where('nama','like',"%".$cari."%");
										})
										->whereNotNull('deleted_at')
										->paginate(10);
		
		$this->data['lpp']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
    }
}