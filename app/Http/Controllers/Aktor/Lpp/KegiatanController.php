<?php

namespace App\Http\Controllers\Aktor\Lpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use App\Models\Aktor\Lpp\Venue;
use App\Models\Aktor\Lpp\Surat;
use App\Models\Aktor\Lpp\Kegiatan;

class KegiatanController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'surat',
		'subjudul' 		 	=> 'kegiatan',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'lpp',
		'aksi'        		=> '',
		'link'         		=> '/lpp',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/lpp/kegiatan/index',
		'view_form' 	 	=> 'aktor/lpp/kegiatan/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);
	
	public function index($user_id, $profil_id, $lpp_id, $surat_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;

		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::orderBy('tanggal', 'DESC')
											->where('surat_id', '=', Crypt::decrypt($surat_id))
											->paginate(10);
		
		return view($this->data['view_utama'], $this->data);
    }

	public function tambah($user_id, $profil_id, $lpp_id, $surat_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;

		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['subjudul']."/store/".$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id;
		
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::orderBy('tanggal', 'DESC')
											->where('surat_id', '=', Crypt::decrypt($surat_id))
											->get();

		$this->data['pilih'] 		= Venue::select('venue.id', 'ina_kota.nama as kota', 'venue.nama as nama')
										->join('ina_kota', 'ina_kota.id', '=', 'venue.kota_id')
										->where('venue.nama', 'not like', "%xxx%")
										->get();

		return view($this->data['view_form'], $this->data);
    }

    public function store($user_id, $profil_id, $lpp_id, $surat_id, Request $request)
    {
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'max'        	=> 'Maks. :max.',
			'min'        	=> 'Min :min.'
		];
		
		$this->validate($request,[
			'tanggal' 		=> 'required',
			'jam' 			=> 'required',
			'venue_id' 		=> 'required',
			'kuota' 		=> 'required|numeric|min:10',
			'sesi' 			=> 'required|numeric|max:10',
		], $pesan);
		
		$angka 				= Kegiatan::where('tanggal', '=', date("Y-m-d", strtotime($request->tanggal)))->count();
		$max 				= is_null($angka) || empty($angka) ? 1 : $angka + 1;
		$kode 				= date("ymd", strtotime($request->tanggal)).''.str_pad($max,2,"0",STR_PAD_LEFT);

        Kegiatan::create([
    		'kode' 			=> $kode,
			'surat_id' 		=> Crypt::decrypt($surat_id),
			'tanggal' 		=> date("Y-m-d", strtotime($request->tanggal)),
			'jam' 			=> $request->jam,
			'venue_id' 		=> $request->venue_id,
			'status' 		=> 'verifikasi',
			'kuota' 		=> $request->kuota,
			'sesi' 			=> $request->sesi,
    	]);
 
		return redirect($this->data['link'].'/'.$this->data['subjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id)->with(['success' => 'Kegiatan '.$kode.' berhasil ditambah.']);
	}
	
	public function lihat($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;
		$this->data['kegiatan_id'] 	= $kegiatan_id;

		$this->data['aksi'] 		= "lihat";
		$this->data['surat']  		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($kegiatan_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;
		$this->data['kegiatan_id'] 	= $kegiatan_id;

		$this->data['aksi'] 		= "ubah";
		
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['subjudul']."/update/".$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id."/".$kegiatan_id;
		$this->data['surat']  		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($kegiatan_id));
		$this->data['pilih'] 		= Venue::select('venue.id', 'ina_kota.nama as kota', 'venue.nama as nama')
										->join('ina_kota', 'ina_kota.id', '=', 'venue.kota_id')
										->where('venue.nama', 'not like', "%xxx%")
										->get();
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id, Request $request)
	{
		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];
		
		$this->validate($request,[
			'tanggal' 		=> 'required',
			'jam' 			=> 'required',
			'venue_id' 		=> 'required',
			'kuota' 		=> 'required|numeric',
			'sesi' 			=> 'required|numeric|max:10',
	    ], $pesan);
		
		$isi 				= Kegiatan::find(Crypt::decrypt($kegiatan_id));	

		$isi->tanggal 		= date("Y-m-d", strtotime($request->tanggal));
		$isi->jam 			= $request->jam;
		$isi->venue_id 		= $request->venue_id;
		$isi->kuota 		= $request->kuota;
		$isi->sesi 			= $request->sesi;

		$isi->save();
		
		return redirect($this->data['link'].'/'.$this->data['subjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id)->with(['success' => 'Kegiatan '.$isi->kode.' berhasil diubah.']);
	}
	
	public function cari($user_id, $profil_id, $lpp_id, $surat_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;

		$cari 	= $request->cari;
		$this->data['aksi'] 		= 'cari';
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan']    	= Kegiatan::where('surat_id', '=', Crypt::decrypt($surat_id))
										->where('kode','like',"%".$cari."%")
										->orWhere('tanggal','like',"%".date("Y-m-d", strtotime($cari))."%")
										->orWhere('status','like',"%".$cari."%")
										->orWhereHas('venue', function($q) use($cari)
										{
											return $q->where('nama', 'like', '%'.$cari.'%')
														->orWhereHas('kota', function($q) use($cari)
														{
															return $q->where('nama', 'like', '%'.$cari.'%');
														});
										})
										->orderBy('tanggal', 'DESC')
										->paginate(10);

		$this->data['kegiatan']->appends($request->only('cari'));									
		
		return view($this->data['view_utama'], $this->data);
	}
	
	public function hapus($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id)
	{
		$isi = Kegiatan::find(Crypt::decrypt($kegiatan_id));
		$isi->delete();
		$isi->save();

	    return redirect($this->data['link'].'/'.$this->data['subjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id)->with(['success' => 'Kegiatan berhasil dihapus.']);
	}
}