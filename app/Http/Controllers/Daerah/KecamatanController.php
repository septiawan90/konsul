<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Daerah\Kecamatan;

class KecamatanController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'kecamatan',
		'subjudul' 		 	=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/kecamatan',
		'link_sampah'       => '/daerah/kecamatan/sampah',
		'view_utama' 		=> 'daerah/kecamatan/index',
		'view_form' 	 	=> 'daerah/kecamatan/form',
		'view_sampah' 	 	=> 'daerah/kecamatan/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
    	$this->data['kecamatan'] = Kecamatan::paginate(10);
    	return view($this->data['view_utama'], $this->data);
    }

    public function tambah()
    {
    	$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/kecamatan/store";

		return view($this->data['view_form'], $this->data);
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'nama' 		=> 'required',
    		'met' 		=> 'required'
    	]);
 
        Kecamatan::create([
    		'nama' 		=> $request->kode,
    		'meta' 		=> $request->kecamatan
    	]);
 
    	return redirect($this->data['link']);
    }

    public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['kecamatan'] 	= Kecamatan::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/kecamatan/update/".$id;
		$this->data['kecamatan'] 	= Kecamatan::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($id, Request $request)
	{
        $this->validate($request,[
		   	'nama' 		=> 'required',
    		'meta' 		=> 'required'
	    ]);

	    $isi 			= Kecamatan::find($id);

	    $isi->nama 		= $request->nama;
    	$isi->meta 		= $request->meta;

	    $isi->save();
	    return redirect($this->data['link']);
	}

	public function delete($id)
	{
        $isi = Kecamatan::find(Crypt::decrypt($id));
	    $isi->delete();

	    return redirect($this->data['link']);
	}

	public function sampah()
	{
    	$this->data['subjudul'] = "sampah";

		$this->data['kecamatan'] = Kecamatan::onlyTrashed()->paginate(10);
    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Kecamatan::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->restore();
    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Kecamatan::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
    	$isi   = Kecamatan::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Kecamatan::onlyTrashed();
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['kecamatan'] 	= Kecamatan::where('nama','like',"%".$cari."%")
										->orWhereHas('kota', function($q) use ($cari) {
											return $q->where('nama', 'LIKE', '%' . $cari . '%')
													->orWhereHas('provinsi', function($q) use($cari)
													{
														return $q->where('nama', 'like', '%'.$cari.'%');
													});
										})
										->paginate(10);
		$this->data['kecamatan']->appends($request->only('cari'));
					
    	return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['kecamatan'] 	= Kecamatan::onlyTrashed()->where('nama','like',"%".$cari."%")
										->orWhereHas('kota', function($q) use ($cari) {
											return $q->where('nama', 'LIKE', '%' . $cari . '%')
													->orWhereHas('provinsi', function($q) use($cari)
													{
														return $q->where('nama', 'like', '%'.$cari.'%');
													});
										})
										->paginate(10);
		$this->data['kecamatan']->appends($request->only('cari'));
					
    	return view($this->data['view_sampah'], $this->data);
    }
}