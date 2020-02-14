<?php

namespace App\Http\Controllers\Aktor\Lpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use App\Models\Daerah\Kota;
use App\Models\Aktor\Lpp\Venue;
use App\Models\Aktor\Lpp\Surat;
use App\Models\Aktor\Lpp\Kegiatan;

class VenueController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'surat',
		'subjudul' 		 	=> 'kegiatan',
		'subsubjudul' 		=> 'venue',
		'fungsi' 		 	=> 'lpp',
		'aksi'        		=> '',
		'link'         		=> '/lpp',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/lpp/venue/index',
		'view_form' 	 	=> 'aktor/lpp/venue/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);
	
	public function index($user_id, $profil_id, $lpp_id, $surat_id, $aksi, $venue_id, $kegiatan_id = null)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;
		$this->data['kegiatan_id'] 	= $kegiatan_id;

		$this->data['aksi'] 		= $aksi;
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['subsubjudul']."/update";

		$this->data['surat']  		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::where('surat_id', '=', Crypt::decrypt($surat_id))->first();
		$this->data['pilih'] 		= Kota::all();
		$this->data['venue'] 		= Venue::orderBy('nama', 'ASC')->where('nama', '=', 'xxx')->first();
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $lpp_id, $surat_id, $aksi, $venue_id, $kegiatan_id = null, Request $request)
	{
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];

		$this->validate($request,[
			'nama' 			=> 'required',
			'alamat' 		=> 'nullable',
			'kota_id' 		=> 'nullable'
	    ], $pesan);

	    $isi 				= Venue::find(Crypt::decrypt($venue_id));

		$isi->nama 			= $request->nama;
		$isi->alamat 		= $request->alamat;
		$isi->kota_id 		= $request->kota_id;
		$isi->updated_by 	= Crypt::decrypt($profil_id);

		$isi->save();

		if($aksi == "tambah")
		{
			return redirect($this->data['link'].'/'.$this->data['subjudul'].'/tambah/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id)->with('message', 'Lokasi baru <b>'.kapital($request->nama).'</b> berhasil Ditambahkan.');
		}
		else
		{
			return redirect($this->data['link'].'/'.$this->data['subjudul'].'/ubah/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)->with('message', 'Lokasi baru <b>'.kapital($request->nama).'</b> berhasil Ditambahkan.');
		}
	    
	}
}