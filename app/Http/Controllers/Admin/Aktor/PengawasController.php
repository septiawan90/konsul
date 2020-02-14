<?php

namespace App\Http\Controllers\Admin\Aktor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use App\Models\Admin\Aktor\Pengawas;

class PengawasController extends Controller
{
    public function index()
    {
    	$isi = Pengawas::paginate(10);
    	return view('admin/aktor/pengawas/index', ['pengawas' => $isi]);
    }

    public function tambah()
    {
        return view('aktor/pengawas/tambah');
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
    		'kode'          => 'nullable',
            'alias'         => 'nullable',
            'alamat'        => 'nullable',
            'kota_id'       => 'required',
    	], $pesan);
 
        Pengawas::create([
			'kode' 			=> $request->kode,
			'nama' 			=> $request->nama,
    		'alias' 		=> $request->alias,
            'alamat'        => $request->alamat,
            'kota_id'       => $request->kota_id,
    	]);

    	return redirect('/pengawas');
    }

    public function ubah($id)
	{
	   	$id        	= Crypt::decrypt($id);
		$isi       	= Pengawas::find($id);
		$pilih 		= Kota::all();

	   	return view('aktor/pengawas/ubah', ['pengawas' => $isi, 'kota' => $pilih]);
	}

	public function update($id, Request $request)
	{
	    $this->validate($request,[			
			'kode'          => 'nullable',
			'nama' 			=> 'required',
            'alias'         => 'nullable',
            'alamat'        => 'nullable',
            'kota_id'       => 'required',
	    ]);

	    $isi 				= Pengawas::find($id);

    	$isi->kode 			= $request->kode;
		$isi->nama 			= $request->nama;
    	$isi->alias			= $request->alias;
        $isi->alamat        = $request->alamat;
        $isi->kota_id       = $request->kota_id;

	    $isi->save();
	    return redirect('/pengawas/');
	}

    public function delete($id)
	{
	    $id    = Crypt::decrypt($id);

        $isi = Pengawas::find($id);
	    $isi->delete();

	    return redirect()->back();
	}

	public function sampah()
	{
    	$isi = Pengawas::onlyTrashed()->get();
    	return view('aktor/pengawas/sampah', ['pengawas' => $isi]);
	}

	public function kembalikan($id)
	{
    	$id     = Crypt::decrypt($id);

        $isi    = Pengawas::onlyTrashed()->where('id', $id);
    	$isi->restore();
    	return redirect('/pengawas/sampah');
	}

	public function kembalikan_semua()
	{		
    	$isi = Pengawas::onlyTrashed();
    	$isi->restore();

    	return redirect('/pengawas/sampah');
	}

	public function hapus_permanen($id)
	{
    	$id    = Crypt::decrypt($id);

        $isi   = Pengawas::onlyTrashed()->where('id', $id);
    	$isi->forceDelete();

    	return redirect('/pengawas/sampah');
	}

	public function hapus_permanen_semua()
	{
    	$isi = Pengawas::onlyTrashed();
    	$isi->forceDelete();

    	return redirect('/pengawas/sampah');
	}

	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$isi 	= Pengawas::where('nama','like',"%".$cari."%")
					->orWhere('kode','like',"%".$cari."%")
					->orWhere('alias','like',"%".$cari."%")
					->orWhereHas('kota', function($q) use($cari)
					{
						return $q->where('nama','like',"%".$cari."%");
					})
					->paginate(10);
					
    	return view('aktor/pengawas/index', ['pengawas' => $isi]);
	}
	
	public function cari_sampah(Request $request)
    {
		$cari 	= $request->cari;
		$isi 	= Pengawas::onlyTrashed()
					->where('nama','like',"%".$cari."%")
					->orWhere('kode','like',"%".$cari."%")
					->orWhere('alias','like',"%".$cari."%")
					->orWhereHas('kota', function($q) use($cari)
					{
						return $q->where('nama','like',"%".$cari."%");
					})
					->paginate(10);
					
    	return view('aktor/pengawas/sampah', ['pengawas' => $isi]);
    }
}

