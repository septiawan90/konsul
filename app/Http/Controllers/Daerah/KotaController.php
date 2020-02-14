<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Daerah\Kota;

class KotaController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'kota',
		'subjudul' 		 	=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/kota',
		'link_sampah'       => '/daerah/kota/sampah',
		'view_utama' 		=> 'daerah/kota/index',
		'view_form' 	 	=> 'daerah/kota/form',
		'view_sampah' 	 	=> 'daerah/kota/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
    	$this->data['kota'] = Kota::paginate(10);
    	return view($this->data['view_utama'], $this->data);
    }

    public function tambah()
    {
    	$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/kota/store";

		return view($this->data['view_form'], $this->data);
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'nama' 		=> 'required',
    		'met' 		=> 'required'
    	]);
 
        Kota::create([
    		'nama' 		=> $request->kode,
    		'meta' 		=> $request->kota
    	]);
 
    	return redirect($this->data['link']);
    }

    public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['kota'] 		= Kota::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/kota/update/".$id;
		$this->data['kota'] 		= Kota::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($id, Request $request)
	{
        $this->validate($request,[
		   	'nama' 		=> 'required',
    		'meta' 		=> 'required'
	    ]);

	    $isi 			= Kota::find($id);

	    $isi->nama 		= $request->nama;
    	$isi->meta 		= $request->meta;

	    $isi->save();
	    return redirect($this->data['link']);
	}

	public function delete($id)
	{
        $isi = Kota::find(Crypt::decrypt($id));
	    $isi->delete();

	    return redirect($this->data['link']);
	}

	public function sampah()
	{
    	$this->data['subjudul'] = "sampah";

		$this->data['kota'] = Kota::onlyTrashed()->paginate(10);
    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Kota::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->restore();
    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Kota::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
    	$isi   = Kota::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Kota::onlyTrashed();
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['kota'] 	= Kota::where('nama','like',"%".$cari."%")
									->orWhereHas('provinsi', function($q) use ($cari) {
										return $q->where('nama', 'LIKE', '%' . $cari . '%');
									})->paginate(10);

		$this->data['kota']->appends($request->only('cari'));
		
		return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['kota'] 	= Kota::onlyTrashed()->where('nama','like',"%".$cari."%")
									->orWhereHas('provinsi', function($q) use ($cari) {
										return $q->where('nama', 'LIKE', '%' . $cari . '%');
									})->paginate(10);

		$this->data['kota']->appends($request->only('cari'));
					
    	return view($this->data['view_sampah'], $this->data);
    }
}