<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;
use App\Models\Admin\Suspend;

class SuspendController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'suspend',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'admin',
		'aksi'        		=> '',
		'link'         		=> '/admin',
		'link_sampah'       => '',
		'view_utama' 		=> 'admin/suspend/index',
		'view_form' 	 	=> '',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	public function index()
    {
		$this->data['suspend'] = Suspend::where('status', '=', '0')->orderBy('created_at', 'DESC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

	public function kirim_ulang($id, Request $request)
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

		$isi = Suspend::find(Crypt::decrypt($id));

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
			$isi->file 				= Storage::putFile('public/file_suspend', $file);
			$isi->updated_by 		= Auth::user()->profil->first()->id;
		}

		$isi->save();
		
		return redirect($this->data['link'].'/'.$this->data['judul'])->with(['success' => 'Suspend berhasil diubah.']);
	}

   	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 		= "cari";
		$this->data['suspend']  	= Suspend::where('status', '=', "0")
										->where('nik','like',"%".$cari."%")
										->orWhere('email','like',"%".$cari."%")
										->orderBy('created_at', 'DESC')
										->paginate(10);

		$this->data['suspend']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
	
	public function hapus($id)
	{
		Suspend::destroy(Crypt::decrypt($id));
		return redirect()->back()->with(['success' => 'User suspend berhasil dihapus.']);
	}
}