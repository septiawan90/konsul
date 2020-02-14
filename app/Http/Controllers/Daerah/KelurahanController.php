<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Daerah\Kelurahan;

class KelurahanController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'kelurahan',
		'subjudul' 		 	=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/kelurahan',
		'link_sampah'       => '/daerah/kelurahan/sampah',
		'view_utama' 		=> 'daerah/kelurahan/index',
		'view_form' 	 	=> 'daerah/kelurahan/form',
		'view_sampah' 	 	=> 'daerah/kelurahan/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
    	$this->data['kelurahan'] = Kelurahan::paginate(10);
    	return view($this->data['view_utama'], $this->data);
    }

    public function tambah()
    {
    	$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/kelurahan/store";

		return view($this->data['view_form'], $this->data);
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'nama' 		=> 'required',
    		'met' 		=> 'required'
    	]);
 
        Kelurahan::create([
    		'nama' 		=> $request->kode,
    		'meta' 		=> $request->kelurahan
    	]);
 
    	return redirect($this->data['link']);
    }

    public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['kelurahan'] 	= Kelurahan::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/kelurahan/update/".$id;
		$this->data['kelurahan'] 	= Kelurahan::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($id, Request $request)
	{
        $this->validate($request,[
		   	'nama' 		=> 'required',
    		'meta' 		=> 'required'
	    ]);

	    $isi 			= Kelurahan::find($id);

	    $isi->nama 		= $request->nama;
    	$isi->meta 		= $request->meta;

	    $isi->save();
	    return redirect($this->data['link']);
	}

	public function delete($id)
	{
        $isi = Kelurahan::find(Crypt::decrypt($id));
	    $isi->delete();

	    return redirect($this->data['link']);
	}

	public function sampah()
	{
    	$this->data['subjudul'] = "sampah";

		$this->data['kelurahan'] = Kelurahan::onlyTrashed()->paginate(10);
    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Kelurahan::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->restore();
    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Kelurahan::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
    	$isi   = Kelurahan::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Kelurahan::onlyTrashed();
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['kelurahan'] 	= Kelurahan::where('nama','like',"%".$cari."%")
										->orWhereHas('kecamatan', function($q) use ($cari) {
											return $q->where('nama', 'LIKE', '%' . $cari . '%')
													->orWhereHas('kota', function($q) use($cari)
													{
														return $q->where('nama', 'like', '%'.$cari.'%')
																->orWhereHas('provinsi', function($q) use($cari)
																{
																	return $q->where('nama', 'like', '%'.$cari.'%');
																});
													});
										})
										->paginate(10);
		$this->data['kelurahan']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah(Request $request)
    {
		$cari 						= $request->cari;
		$this->data['kelurahan'] 	= Kelurahan::onlyTrashed()->where('nama','like',"%".$cari."%")
										->orWhereHas('kecamatan', function($q) use ($cari) {
											return $q->where('nama', 'LIKE', '%' . $cari . '%')
													->orWhereHas('kota', function($q) use($cari)
													{
														return $q->where('nama', 'like', '%'.$cari.'%')
																->orWhereHas('provinsi', function($q) use($cari)
																{
																	return $q->where('nama', 'like', '%'.$cari.'%');
																});
													});
										})
										->paginate(10);
		$this->data['kelurahan']->appends($request->only('cari'));
					
		return view($this->data['view_sampah'], $this->data);
    }
}