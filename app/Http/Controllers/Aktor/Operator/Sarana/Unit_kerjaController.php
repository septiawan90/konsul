<?php

namespace App\Http\Controllers\Aktor\Operator\Sarana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Aktor\Operator\Sarana\Unit_kerja;

class Unit_kerjaController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'unit_kerja',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/sarana',
		'aksi'        		=> '',
		'link'         		=> '/operator/sarana',
		'link_sampah'       => '/operator/sarana/unit_kerja/sampah',
		'view_utama' 		=> 'aktor/operator/sarana/unit_kerja/index',
		'view_form' 	 	=> 'aktor/operator/sarana/unit_kerja/form',
		'view_sampah' 	 	=> 'aktor/operator/sarana/unit_kerja/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
		$this->data['unit_kerja'] = Unit_kerja::orderBy('nama', 'ASC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

    public function tambah()
    {
		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/operator/sarana/unit_kerja/store";

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
    		'kode' 				=> 'nullable',
			'nama' 				=> 'required'
    	], $pesan);
 
        Unit_kerja::create([
    		'kode' 				=> $request->kode,
			'nama' 				=> $request->nama,
			'created_by' 		=> Auth::user()->profil->first()->id
    	]);
 
    	return redirect($this->data['link'].'/'.$this->data['judul']);
    }

    public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['unit_kerja'] 	= Unit_kerja::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/operator/sarana/unit_kerja/update/".$id;

		$this->data['unit_kerja'] 	= Unit_kerja::find(Crypt::decrypt($id));
		
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
			'kode' 				=> 'nullable',
			'nama' 				=> 'required'
	    ], $pesan);

	    $isi 					= Unit_kerja::find(Crypt::decrypt($id));

	    $isi->kode 				= $request->kode;
		$isi->nama 				= $request->nama;
		$isi->updated_by 		= Auth::user()->profil->first()->id;

	    $isi->save();
	    return redirect($this->data['link'].'/'.$this->data['judul']);
	}

	public function hapus($id)
	{
        $isi 				= Unit_kerja::find(Crypt::decrypt($id));
		$isi->deleted_by 	= Auth::user()->profil->first()->id;
		
		$isi->delete();
		$isi->save();
		
	    return redirect($this->data['link'].'/'.$this->data['judul']);
	}

	public function sampah()
	{
		$this->data['subjudul'] = "sampah";

		$this->data['unit_kerja'] = Unit_kerja::orderBy('nama', 'ASC')->onlyTrashed()->paginate(10);
    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Unit_kerja::onlyTrashed()->where('id', Crypt::decrypt($id));
		$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Unit_kerja::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
        $isi   = Unit_kerja::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Unit_kerja::onlyTrashed();
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 		= 'cari';
		$this->data['unit_kerja'] 	= Unit_kerja::orderBy('nama', 'ASC')
										->where('kode','like',"%".$cari."%")
										->orWhere('nama','like',"%".$cari."%")
										->whereNull('deleted_at')
										->paginate(10);
					
		$this->data['unit_kerja']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 		= 'cari';
		$this->data['unit_kerja'] 	= Unit_kerja::onlyTrashed()
										->where('kode','like',"%".$cari."%")
										->orWhere('nama','like',"%".$cari."%")
										->whereNotNull('deleted_at')
										->paginate(10);

		$this->data['unit_kerja']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
    }
}