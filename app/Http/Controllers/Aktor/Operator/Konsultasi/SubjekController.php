<?php

namespace App\Http\Controllers\Aktor\Operator\Konsultasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\Aktor\Operator\Konsultasi\Subjek;

class SubjekController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'subjek',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/konsultasi',
		'aksi'        		=> '',
		'link'         		=> '/operator/konsultasi',
		'link_sampah'       => '/operator/konsultasi/subjek/sampah',
		'view_utama' 		=> 'aktor/operator/konsultasi/subjek/index',
		'view_form' 	 	=> 'aktor/operator/konsultasi/subjek/form',
		'view_sampah' 	 	=> 'aktor/operator/konsultasi/subjek/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
		$this->data['subjek'] = Subjek::orderBy('nama', 'DESC')->paginate(10);
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
		
		$this->validate($request,[
    		'kode' 		=> 'required',
    		'nama' 		=> 'required'
    	], $pesan);
 
        Subjek::create([
    		'kode' 		=> $request->kode,
    		'nama' 		=> $request->nama
    	]);
 
    	return redirect($this->data['link'].'/'.$this->data['judul'])->with(['success' => 'Subjek berhasil ditambahkan.']);
	}

    public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['subjek'] 		= Subjek::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['judul']."/update/".$id;
		$this->data['subjek'] 		= Subjek::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($id, Request $request)
	{
        $this->validate($request,[
		   	'kode' 		=> 'required',
    		'nama' 		=> 'required'
	    ]);

	    $isi 			= Subjek::find(Crypt::decrypt($id));

	    $isi->kode 		= $request->kode;
    	$isi->nama 		= $request->nama;

	    $isi->save();
	    return redirect($this->data['link'].'/'.$this->data['judul'])->with(['success' => 'Subjek '.$isi->kode.' berhasil diubah.']);
	}

	public function delete($id)
	{
	    $isi = Subjek::find(Crypt::decrypt($id));
	    $isi->delete();

		//return redirect()->back()->with(['success' => 'Subjek berhasil dihapus.']);
		return redirect($this->data['link'].'/'.$this->data['judul'])->with(['success' => 'Subjek '.$isi->kode.' berhasil dihapus.']);
	}

	public function sampah()
	{
		$this->data['subjudul'] 	= "sampah";

		$this->data['subjek'] 		= Subjek::onlyTrashed()->paginate(10);
    	return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
    	$isi   = Subjek::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->restore();
		
    	return redirect($this->data['link_sampah'])->with(['success' => 'Subjek berhasil dikembalikan.']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Subjek::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah'])->with(['success' => 'Subjek berhasil dikembalikan semua.']);
	}

	public function hapus_permanen($id)
	{
    	$isi   = Subjek::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah'])->with(['success' => 'Subjek berhasil dihapus permanen.']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Subjek::onlyTrashed();
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah'])->with(['success' => 'Subjek berhasil dihapus semua.']);
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['subjek'] 	= Subjek::where('kode','like',"%".$cari."%")
									->orWhere('nama','like',"%".$cari."%")
									->paginate(10);
					
		$this->data['subjek']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
	
	public function cari_sampah(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['subjek'] 	= Subjek::onlyTrashed()
									->where('kode','like',"%".$cari."%")
									->orWhere('nama','like',"%".$cari."%")
									->paginate(10);
					
		$this->data['subjek']->appends($request->only('cari'));

		return view($this->data['view_sampah'], $this->data);
    }
}