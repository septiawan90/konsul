<?php

namespace App\Http\Controllers\Aktor\Operator\Sertifikat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;
use App\Models\Aktor\Operator\Sertifikat\Tingkat_dasar;

class Tingkat_dasarController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'tingkat_dasar',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/sertifikat',
		'aksi'        		=> '',
		'link'         		=> '/operator/sertifikat',
		'link_sampah'       => '/operator/sertifikat/tingkat_dasar/sampah',
		'view_utama' 		=> 'aktor/operator/sertifikat/tingkat_dasar/index',
		'view_form' 	 	=> 'aktor/operator/sertifikat/tingkat_dasar/form',
		'view_sampah' 	 	=> 'aktor/operator/sertifikat/tingkat_dasar/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
		$this->data['tingkat_dasar'] = Tingkat_dasar::orderBy('id', 'ASC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

	public function tambah()
    {
		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/operator/sertifikat/tingkat_dasar/store";
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
			'nik' 			=> 'nullable|numeric|digits:16',
			'nip' 			=> 'nullable|numeric|digits:18',
			'email' 		=> 'nullable|email',
			'seri' 			=> 'nullable|numeric',
			'file' 			=> 'nullable|file|mimes:pdf|max:2048',
		], $pesan);
		
		$file 				= $request->file('file');
		$nama_file 			= time()."_".$file->getClientOriginalName();
		
        Tingkat_dasar::create([
			'seri' 			=> $request->seri,
			'nik' 			=> $request->nik,
			'nip' 			=> $request->nip,
			'email' 		=> $request->email,
			'file' 			=> Storage::putFile('public/file_tingkat_dasar', $file),
			'created_by' 	=> Auth::user()->profil->first()->id
    	]);
 
    	return redirect($this->data['link'].'/'.$this->data['judul'])->with(['sukses' => 'Sertifikat Tingkat Dasar nomor '.$isi->nomor.' berhasil ditambahkan.']);
	}
	
	public function lihat($id)
	{
		$this->data['aksi'] 			= "lihat";
		$this->data['tingkat_dasar'] 	= Tingkat_dasar::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($id)
	{
		$this->data['aksi'] 			= "ubah";
		$this->data['form_action'] 		= "/operator/sertifikat/tingkat_dasar/update/".$id;
		$this->data['tingkat_dasar'] 	= Tingkat_dasar::find(Crypt::decrypt($id));
		
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
			'nik' 			=> 'nullable|numeric|digits:16',
			'nip' 			=> 'nullable|numeric|digits:18',
			'email' 		=> 'nullable|email',
			'seri' 			=> 'nullable|numeric',
			'file' 			=> 'nullable|file|mimes:pdf|max:2048',
	    ], $pesan);

		$isi 				= Tingkat_dasar::find(Crypt::decrypt($id));

		$file 				= $request->file('file');

		$isi->seri 			= $request->seri;
		$isi->nik 			= $request->nik;
		$isi->nip 			= $request->nip;
		$isi->email 		= $request->email;

		if($file)
		{ 
			$isi->file 			= Storage::putFile('public/file_tingkat_dasar', $file);
		}

		$isi->updated_by 	= Auth::user()->profil->first()->id;

		$isi->save();
		
		return redirect($this->data['link'].'/'.$this->data['judul'])->with(['sukses' => 'Sertifikat Tingkat Dasar nomor '.$isi->nomor.' berhasil diubah.']);
	}

	public function unduh($id)
	{
		$model_file = Tingkat_dasar::findOrFail(Crypt::decrypt($id)); //Mencari model atau objek yang dicari
		return Storage::download($model_file->file);
   }
	
	public function hapus($id)
	{
		$isi = Tingkat_dasar::find(Crypt::decrypt($id));
		$isi->deleted_by 	= Auth::user()->id;
		
		$isi->delete();
		$isi->save();

	    return redirect($this->data['link'].'/'.$this->data['judul']);
	}

	public function sampah()
	{
		$this->data['subjudul'] 		= "sampah";
		$this->data['tingkat_dasar'] 	= Tingkat_dasar::onlyTrashed()->orderBy('tanggal', 'DESC')->paginate(10);
		return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($id)
	{
        $isi   = Tingkat_dasar::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->restore();
    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua()
	{		
    	$isi = Tingkat_dasar::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($id)
	{
        $isi   = Tingkat_dasar::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua()
	{
    	$isi = Tingkat_dasar::onlyTrashed();
    	$isi->forceDelete();

		return redirect($this->data['link_sampah']);
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 			= "cari";
		$this->data['tingkat_dasar']  	= Tingkat_dasar::where('seri','like',"%".$cari."%")
											->orWhere('nomor','like',"%".$cari."%")
											->orWhere('nik','like',"%".$cari."%")
											->orWhere('nip','like',"%".$cari."%")
											->orWhere('email','like',"%".$cari."%")
											->paginate(10);
		$this->data['tingkat_dasar']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
}