<?php

namespace App\Http\Controllers\Aktor\Operator\Bmn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;
use App\Models\Aktor\Operator\Bmn\Aset;

class AsetController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'aset',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/bmn',
		'aksi'        		=> '',
		'link'         		=> '/operator/bmn',
		'link_sampah'       => '/operator/bmn/aset/sampah',
		'view_utama' 		=> 'aktor/operator/bmn/aset/index',
		'view_form' 	 	=> 'aktor/operator/bmn/aset/form',
		'view_sampah' 	 	=> 'aktor/operator/bmn/aset/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
		$this->data['aset'] = Aset::orderBy('tahun_perolehan', 'DESC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

	public function tambah()
    {
		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['judul']."/store";

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
			'nama' 				=> 'required',
			'merk' 				=> 'required',
			'kategori' 			=> 'required',
			'kode_bmn' 			=> 'required',
			'nomor_urut' 		=> 'required',
			'kode_satker' 		=> 'required',
			'tahun_perolehan' 	=> 'required|numeric',
			'file' 				=> 'nullable|file|mimes:jpg|max:2048',
		], $pesan);
		
		$file 					= $request->file('file');

		if(is_null($file))
		{
			Aset::create([
				'nama' 				=> $request->nama,
				'merk' 				=> $request->merk,
				'kategori' 			=> $request->kategori,
				'kode_bmn' 			=> $request->kode_bmn,
				'nomor_urut' 		=> $request->nomor_urut,
				'kode_satker' 		=> $request->kode_satker,
				'tahun_perolehan' 	=> $request->tahun_perolehan,
				'created_by' 		=> Auth::user()->profil->first()->id
			]);
		}
		else
		{
			Aset::create([
				'nama' 				=> $request->nama,
				'merk' 				=> $request->merk,
				'kategori' 			=> $request->kategori,
				'kode_bmn' 			=> $request->kode_bmn,
				'nomor_urut' 		=> $request->nomor_urut,
				'kode_satker' 		=> $request->kode_satker,
				'tahun_perolehan' 	=> $request->tahun_perolehan,
				'file' 				=> Storage::putFile('public/file_aset', $file),
				'created_by' 		=> Auth::user()->profil->first()->id
			]);
		}
 
    	return redirect($this->data['link'].'/'.$this->data['judul'])->with(['success' => 'Aset berhasil ditambahkan.']);
	}
	
	public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['aset'] 		= Aset::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['judul']."/update/".$id;
		$this->data['aset'] 		= Aset::find(Crypt::decrypt($id));
		
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
			'nama' 				=> 'required',
			'merk' 				=> 'required',
			'kategori' 			=> 'required',
			'kode_bmn' 			=> 'required',
			'nomor_urut' 		=> 'required',
			'kode_satker' 		=> 'required',
			'tahun_perolehan' 	=> 'required|numeric',
			'file' 				=> 'nullable|file|mimes:jpg|max:2048',
	    ], $pesan);

		$isi = Aset::find(Crypt::decrypt($id));

		if(is_null($request->file('file')))
		{		
			$isi->nama 				= $request->nama;
			$isi->merk 				= $request->merk;
			$isi->kategori 			= $request->kategori;
			$isi->kode_bmn 			= $request->kode_bmn;
			$isi->nomor_urut 		= $request->nomor_urut;
			$isi->kode_satker 		= $request->kode_satker;
			$isi->tahun_perolehan 	= $request->tahun_perolehan;
			$isi->updated_by 		= Auth::user()->profil->first()->id;
		}
		else
		{
			$file 					= $request->file('file');

			$isi->nama 				= $request->nama;
			$isi->merk 				= $request->merk;
			$isi->kategori 			= $request->kategori;
			$isi->kode_bmn 			= $request->kode_bmn;
			$isi->nomor_urut 		= $request->nomor_urut;
			$isi->kode_satker 		= $request->kode_satker;
			$isi->tahun_perolehan 	= $request->tahun_perolehan;
			$isi->file 				= Storage::putFile('public/file_aset', $file);
			$isi->updated_by 		= Auth::user()->profil->first()->id;
		}

		$isi->save();
		
		return redirect($this->data['link'].'/'.$this->data['judul'])->with(['success' => 'Aset berhasil diubah.']);
	}

	public function unduh($id)
	{
		$model_file = Aset::findOrFail(Crypt::decrypt($id)); //Mencari model atau objek yang dicari
		return Storage::download($model_file->file);
   }

   	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['aset']  	= Aset::where('tahun_perolehan','like',"%".$cari."%")
										->orWhere('nama','like',"%".$cari."%")
										->orWhere('merk','like',"%".$cari."%")
										->orWhere('kategori','like',"%".$cari."%")
										->orWhere('kode_bmn','like',"%".$cari."%")
										->orWhere('nomor_urut','like',"%".$cari."%")
										->orWhere('kode_satker','like',"%".$cari."%")
										->orderBy('tahun_perolehan', 'DESC')
										->paginate(10);
		$this->data['aset']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
	
	public function hapus($id)
	{
		$isi = Aset::find(Crypt::decrypt($id));
		$isi->deleted_by 	= Auth::user()->profil->first()->id;
		
		$isi->delete();
		$isi->save();

	    return redirect($this->data['link'].'/'.$this->data['judul'])->with(['success' => 'Aset berhasil dihapus.']);
	}

	public function sampah()
	{
		$this->data['subjudul'] = "sampah";
		$this->data['aset'] = Aset::onlyTrashed()->orderBy('tahun_perolehan', 'DESC')->paginate(10);
		return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Aset::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->restore();
    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Aset::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
        $isi   = Aset::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Aset::onlyTrashed();
    	$isi->forceDelete();

		return redirect($this->data['link_sampah']);
	}
}