<?php

namespace App\Http\Controllers\Aktor\Tamu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\Aktor\Tamu\Tiket;
use App\Models\Aktor\Tamu\Profil;
use App\Models\Aktor\Tamu\Konsultasi;

class TiketController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'profil',
		'subjudul' 		 	=> 'tiket',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'profil',
		'aksi'        		=> '',
		'link'         		=> '/profil',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/tamu/tiket/index',
		'view_form' 	 	=> 'aktor/tamu/tiket/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	// public function index()
    // {	
	// 	$this->data['tiket'] 	= Tiket::orderBy('created_at', 'DESC')->paginate(10);
	// 	return view($this->data['view_utama'], $this->data);
	// }
	
	public function index($id)
    {
        $this->data['profil']	= Profil::find(Crypt::decrypt($id));
        $this->data['tiket']   	= Tiket::where('tamu_id', '=', Crypt::decrypt($id))->orderBy('created_at', 'desc')->paginate(10);

        return view($this->data['view_utama'], $this->data);
    }

    public function tambah($id)
    {
		$this->data['aksi']     = 'tambah';
		$this->data['profil']   = Profil::find(Crypt::decrypt($id));
        return view($this->data['view_form'], $this->data);
    }

    public function store($id, Request $request)
    {
    	$this->validate($request,[
    		'nomor' 	=> 'required|unique:tiket'
    	]);
 
        Tiket::create([
    		'tamu_id'   => Crypt::decrypt($id),
            'nomor'     => $request->nomor
    	]);

        $tiket_id 		= Tiket::where('nomor', '=', $request->nomor)->first()->id;

        Konsultasi::create([
            'tiket_id'  => $tiket_id
		]);
		
		$konsultasi_id 	= Konsultasi::where('tiket_id', '=', $tiket_id)->first()->id;

    	return redirect('/konsultasi/ubah/'.$id.'/'.Crypt::encrypt($tiket_id).'/'.Crypt::encrypt($konsultasi_id));
    }

	/* 
	public function delete($id)
	{
	    $id = Crypt::decrypt($id);

        $isi = Tiket::find($id);
	    $isi->delete();

	    return redirect()->back();
	}

	public function sampah()
	{
    	$isi = Tiket::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(10);
    	return view('tiket/sampah', ['tiket' => $isi]);
	}

	public function kembalikan($id)
	{
    	$id    = Crypt::decrypt($id);

        $isi   = Tiket::onlyTrashed()->where('id', $id);
    	$isi->restore();
    	return redirect('/tiket/sampah');
	}

	public function kembalikan_semua()
	{		
    	$isi = Tiket::onlyTrashed();
    	$isi->restore();

    	return redirect('/tiket/sampah');
	} */

	public function cari($id, Request $request)
    {
		$cari 	= $request->cari;

		$this->data['aksi'] 	= "cari";
		$this->data['profil']     = Profil::find(Crypt::decrypt($id));
		$this->data['tiket'] 	= Tiket::where('nomor', 'like', "%".$cari."%")
									->where('tamu_id', '=', Crypt::decrypt($id))
									->orderBy('created_at', 'DESC')
									->paginate(10);
		
		$this->data['tiket']->appends($request->only('cari'));

    	return view($this->data['view_utama'], $this->data);
    }
}