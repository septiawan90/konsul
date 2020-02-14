<?php

namespace App\Http\Controllers\Aktor\Operator\Konsultasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use App\Models\Aktor\Operator\Konsultasi\Petugas;

class PetugasController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'petugas',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/konsultasi',
		'aksi'        		=> '',
		'link'         		=> '/operator/konsultasi',
		'link_sampah'       => '/operator/konsultasi/petugas/sampah',
		'view_utama' 		=> 'aktor/operator/konsultasi/petugas/index',
		'view_form' 	 	=> 'aktor/operator/konsultasi/petugas/form',
		'view_sampah' 	 	=> 'aktor/operator/konsultasi/petugas/sampah',
		'form_action'   	=> '',
	);

	public function index()
    {
		$this->data['petugas'] = Petugas::orderBy('nama', 'DESC')->paginate(10);
		return view($this->data['view_utama'], $this->data);
	}
	
	public function tambah()
    {
        return view('petugas/tambah');
    }

    public function store(Request $request)
    {
    	$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
            'digits'        => 'Jumlah karakter harus :digits.',
            'email'         => 'Format harus email.',
        ];

        $this->validate($request,[
    		'nama' 			=> 'required',
    		'nik'           => 'nullable|numeric|digits:16|unique:petugas',
            'nip'           => 'nullable|numeric|digits:18',
            'email'         => 'nullable|email',
            'hp'            => 'nullable|numeric'
    	], $pesan);
 
        Petugas::create([
    		'nama' 			=> $request->nama,
    		'nik' 			=> $request->nik,
    		'nip' 			=> $request->nip,
            'email'         => $request->email,
            'hp'            => $request->hp,
    	]);
 
    	return redirect('/petugas/');
    }

    public function ubah($id)
	{
	   	$id        = Crypt::decrypt($id);

        $isi       = Petugas::find($id);
	   	return view('petugas/ubah', ['petugas' => $isi]);
	}

	public function update($id, Request $request)
	{
	    $this->validate($request,[
		   	'nama' 			=> 'required',
    		'nik' 			=> 'nullable|numeric|digits:16|unique:petugas',
            'nip'           => 'nullable|numeric|digits:18',
            'email'         => 'nullable|email',
            'hp'            => 'nullable|numeric'
	    ]);

	    $isi 				= Petugas::find($id);

	    $isi->nama 			= $request->nama;
    	$isi->nik 			= $request->nik;
    	$isi->nip			= $request->nip;
        $isi->email         = $request->email;
        $isi->hp            = $request->hp;

	    $isi->save();
	    return redirect('/petugas/');
	}

    public function delete($id)
	{
	    $id    = Crypt::decrypt($id);

        $isi = Petugas::find($id);
	    $isi->delete();

	    return redirect()->back();
	}

	public function sampah()
	{
    	$isi = Petugas::onlyTrashed()->paginate(10);
    	return view('petugas/sampah', ['petugas' => $isi]);
	}

	public function kembalikan($id)
	{
    	$id     = Crypt::decrypt($id);

        $isi    = Petugas::onlyTrashed()->where('id', $id);
    	$isi->restore();
    	return redirect('/petugas/sampah');
	}

	public function kembalikan_semua()
	{		
    	$isi = Petugas::onlyTrashed();
    	$isi->restore();

    	return redirect('/petugas/sampah');
	}

	public function hapus_permanen($id)
	{
    	$id    = Crypt::decrypt($id);

        $isi   = Petugas::onlyTrashed()->where('id', $id);
    	$isi->forceDelete();

    	return redirect('/petugas/sampah');
	}

	public function hapus_permanen_semua()
	{
    	$isi = Petugas::onlyTrashed();
    	$isi->forceDelete();

    	return redirect('/petugas/sampah');
	}

    public function cari(Request $request)
    {
        $cari = $request->cari;
 
        $isi = Petugas::where('nama','like',"%".$cari."%")
                ->orWhere('nik','like',"%".$cari."%")
                ->orWhere('nip','like',"%".$cari."%")
                ->orWhere('email','like',"%".$cari."%")
                ->orWhere('hp','like',"%".$cari."%")
                ->paginate(10);
 
        return view('petugas/index',['petugas' => $isi]); 
	}
	
	public function cari_sampah(Request $request)
    {
		$this->validate($request,[
			'cari' 			=> 'required'
		 ]);
		 
		$cari = $request->cari;
 
		$isi = Petugas::onlyTrashed()
				->where('nama','like',"%".$cari."%")
                ->orWhere('nik','like',"%".$cari."%")
                ->orWhere('nip','like',"%".$cari."%")
                ->orWhere('email','like',"%".$cari."%")
                ->orWhere('hp','like',"%".$cari."%")
				->paginate(10);
 
        return view('petugas/sampah',['petugas' => $isi]); 
    }
}
