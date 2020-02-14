<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Daerah\Provinsi;

class ProvinsiController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'provinsi',
		'subjudul' 		 	=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/provinsi',
		'link_sampah'       => '/daerah/provinsi/sampah',
		'view_utama' 		=> 'daerah/provinsi/index',
		'view_form' 	 	=> 'daerah/provinsi/form',
		'view_sampah' 	 	=> 'daerah/provinsi/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
    	$this->data['provinsi'] = Provinsi::paginate(10);
    	return view($this->data['view_utama'], $this->data);
    }

    public function tambah()
    {
    	$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/provinsi/store";

		return view($this->data['view_form'], $this->data);
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'nama' 		=> 'required',
    		'met' 		=> 'required'
    	]);
 
        Provinsi::create([
    		'nama' 		=> $request->kode,
    		'meta' 		=> $request->provinsi
    	]);
 
    	return redirect($this->data['link']);
    }

	public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['provinsi'] 	= Provinsi::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/provinsi/update/".$id;
		$this->data['provinsi'] 	= Provinsi::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($id, Request $request)
	{
        $this->validate($request,[
		   	'nama' 		=> 'required',
    		'meta' 		=> 'required'
	    ]);

	    $isi 			= Provinsi::find($id);

	    $isi->nama 		= $request->nama;
    	$isi->meta 		= $request->meta;

	    $isi->save();
	    return redirect($this->data['link']);
	}

	public function delete($id)
	{
        $isi = Provinsi::find(Crypt::decrypt($id));
	    $isi->delete();

	    return redirect($this->data['link']);
	}

	public function sampah()
	{
    	$this->data['subjudul'] = "sampah";

		$this->data['provinsi'] = Provinsi::onlyTrashed()->paginate(10);
    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Provinsi::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->restore();
    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Provinsi::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
    	$isi   = Provinsi::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Provinsi::onlyTrashed();
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['provinsi'] 	= Provinsi::where('nama','like',"%".$cari."%")->paginate(10);
		$this->data['provinsi']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['provinsi'] 	= Provinsi::onlyTrashed()->where('nama','like',"%".$cari."%")->paginate(10);
		$this->data['provinsi']->appends($request->only('cari'));					
					
		return view($this->data['view_sampah'], $this->data);
    }
}