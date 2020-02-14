<?php

namespace App\Http\Controllers\Aktor\Operator\Sarana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Aktor\Operator\Sarana\Pelaku_pbj;

class Pelaku_pbjController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'venue',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/sarana',
		'aksi'        		=> '',
		'link'         		=> '/operator/sarana',
		'link_sampah'       => '/operator/sarana/venue/sampah',
		'view_utama' 		=> 'aktor/operator/sarana/venue/index',
		'view_form' 	 	=> 'aktor/operator/sarana/venue/form',
		'view_sampah' 	 	=> 'aktor/operator/sarana/venue/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
		$this->data['venue'] = Venue::orderBy('nama', 'ASC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

    public function tambah()
    {
		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/operator/sarana/venue/store";
		$this->data['pilih'] 		= Kota::all();

		return view($this->data['view_form'], $this->data);
    }

    public function store(Request $request)
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
			'alamat' 		=> 'required',
			'kota_id' 		=> 'required'
    	], $pesan);
 
        Venue::create([
    		'kode' 				=> $request->kode,
			'nama' 				=> $request->nama,
			'alamat' 			=> $request->alamat,
			'kota_id' 			=> $request->kota_id,
			'created_by' 		=> Auth::user()->profil->first()->id
    	]);
 
    	return redirect($this->data['link'].'/'.$this->data['judul']);
    }

	public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['venue'] 		= Venue::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/operator/sarana/venue/update/".$id;

		$this->data['pilih'] 		= Kota::all();
		$this->data['venue'] 		= Venue::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($id, Request $request)
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
			'alamat' 		=> 'nullable',
			'kota_id' 		=> 'nullable'
	    ], $pesan);

	    $isi 				= Venue::find(Crypt::decrypt($id));

	    $isi->kode 			= $request->kode;
		$isi->nama 			= $request->nama;
		$isi->alamat 		= $request->alamat;
		$isi->kota_id 		= $request->kota_id;
		$isi->updated_by 	= Auth::user()->profil->first()->id;

	    $isi->save();
	    return redirect($this->data['link'].'/'.$this->data['judul']);
	}

	public function hapus($id)
	{
        $isi 				= Venue::find(Crypt::decrypt($id));
		$isi->deleted_by 	= Auth::user()->profil->first()->id;
		
		$isi->delete();
		$isi->save();
		
	    return redirect($this->data['link'].'/'.$this->data['judul']);
	}

	public function sampah()
	{
		$this->data['subjudul'] = "sampah";

		$this->data['venue'] = Venue::orderBy('nama', 'ASC')->onlyTrashed()->paginate(10);
    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Venue::onlyTrashed()->where('id', Crypt::decrypt($id));
		$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Venue::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
        $isi   = Venue::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Venue::onlyTrashed();
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['venue'] 	= Venue::orderBy('nama', 'ASC')
									->where('kode','like',"%".$cari."%")
									->orWhere('nama','like',"%".$cari."%")
									->orWhereHas('kota', function($q) use($cari)
									{
										return $q->where('nama','like',"%".$cari."%");
									})
									->whereNull('deleted_at')
									->paginate(10);

		$this->data['venue']->appends($request->only('cari'));
		return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['venue'] 	= Venue::onlyTrashed()
									->where('kode','like',"%".$cari."%")
									->orWhere('nama','like',"%".$cari."%")
									->orWhereHas('kota', function($q) use($cari)
									{
										return $q->where('nama','like',"%".$cari."%");
									})
									->whereNotNull('deleted_at')
									->paginate(10);

		$this->data['venue']->appends($request->only('cari'));
		return view($this->data['view_utama_sampah'], $this->data);
    }
}