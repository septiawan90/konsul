<?php

namespace App\Http\Controllers\Aktor\Operator\Jadwal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;
use App\User;
use App\Profil;
use App\Models\Aktor\Operator\Jadwal\Surat;
use App\Models\Aktor\Operator\Jadwal\Kegiatan;
use App\Models\Aktor\Operator\Legal\Penerima;
use App\Models\Aktor\Operator\Legal\Sk;

class KegiatanController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'surat',
		'subjudul' 		 	=> 'kegiatan',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/jadwal',
		'aksi'        		=> '',
		'link'         		=> '/operator/jadwal',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/operator/jadwal/kegiatan/index',
		'view_form' 	 	=> 'aktor/operator/jadwal/kegiatan/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);
	
	public function index($id)
    {
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($id));
		$this->data['kegiatan'] 	= Kegiatan::orderBy('tanggal', 'DESC')
										->where('surat_id', '=', Crypt::decrypt($id))
										->paginate(10);
		
		return view($this->data['view_utama'], $this->data);
	}
	
	public function lihat($s_id, $k_id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['surat']  		= Surat::find(Crypt::decrypt($s_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($k_id));
		
		return view($this->data['view_form'], $this->data);
	}
	
    public function ubah($s_id, $k_id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/operator/jadwal/kegiatan/update/".$s_id."/".$k_id;
		$this->data['surat']  		= Surat::find(Crypt::decrypt($s_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($k_id));
		$this->data['pengawas'] 	= Penerima::whereHas('sk', function($q){
											return $q->where('profesi_id', '=', '1');
											})->get();
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($s_id, $k_id, Request $request)
	{
		$isi 				= Kegiatan::find(Crypt::decrypt($k_id));	
		$isi->status 		= $request->status;
		$isi->keterangan 	= $request->keterangan;
		$isi->pengawas1_id 	= $request->pengawas1_id;
		$isi->pengawas2_id 	= $request->pengawas2_id;

		$isi->save();
		
		return redirect($this->data['link'].'/'.$this->data['subjudul'].'/'.$s_id)->with(['sukses' => 'Kegiatan '.$isi->kode.' berhasil di ubah.']);
	}

	public function cari($id, Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 		= "cari";
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($id));
		$this->data['kegiatan']    	= Kegiatan::where('kode','like',"%".$cari."%")
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
										->where('surat_id', '=', Crypt::decrypt($id))
										->orderBy('tanggal', 'DESC')
										->paginate(10);
		
		$this->data['kegiatan']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
}