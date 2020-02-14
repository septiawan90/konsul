<?php

namespace App\Http\Controllers\Aktor\Operator\Monev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;

use App\User;
use App\Models\Aktor\Operator\Monev\Surat;
use App\Models\Aktor\Operator\Monev\Kegiatan;
use App\Models\Aktor\Operator\Monev\Peserta;

class PesertaController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'surat',
		'subjudul' 		 	=> 'kegiatan',
		'subsubjudul' 		=> 'peserta',
		'fungsi' 		 	=> 'operator/monev',
		'aksi'        		=> '',
		'link'         		=> '/operator/monev',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/operator/monev/peserta/index',
		'view_form' 	 	=> 'aktor/operator/monev/peserta/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	
	public function index($s_id, $k_id)
	{
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($s_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($k_id));
		$this->data['peserta'] 		= Peserta::where('kegiatan_id', '=', Crypt::decrypt($k_id))->paginate(10);
		
		return view($this->data['view_utama'], $this->data);
	}

	public function lihat($s_id, $k_id, $p_id)
	{
		$this->data['aksi'] 		= "lihat";

		$this->data['surat'] 		= Surat::find(Crypt::decrypt($s_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($k_id));
		$this->data['peserta'] 		= Peserta::find(Crypt::decrypt($p_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($s_id, $k_id, $p_id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/operator/monev/kegiatan/peserta/update/".$s_id."/".$k_id."/".$p_id;

		$this->data['surat'] 		= Surat::find(Crypt::decrypt($s_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($k_id));
		$this->data['peserta'] 		= Peserta::find(Crypt::decrypt($p_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($s_id, $k_id, $p_id, Request $request)
	{
		$isi 				= Peserta::find(Crypt::decrypt($p_id));
		$isi->status 		= $request->status;
		$isi->keterangan 	= $request->keterangan;
		$isi->save();

		return redirect('/operator/monev/kegiatan/peserta/'.$s_id.'/'.$k_id);
	}

	public function unduh($s_id, $k_id, $p_id)
	{
		$model_file = Peserta::findOrFail(Crypt::decrypt($p_id)); //Mencari model atau objek yang dicari
		return Storage::download($model_file->file);
   	}

	public function berkas($s_id, $k_id, $p_id)
	{		
		$document = Peserta::findOrFail(Crypt::decrypt($p_id))->file;
		$fileName   = Storage::name($document);

		return response()->file($fileName);
						
		/*$document = Peserta::findOrFail(Crypt::decrypt($p_id));
		$filePath = $document->file;

		if( ! Storage::exists($filePath) ) {
		abort(404);
		}

		$pdfContent = Storage::get($filePath);

		$type       = Storage::mimeType($filePath);
		$fileName   = Storage::name($filePath);

		return Response::make($pdfContent, 200, [
		'Content-Type'        => $type,
		'Content-Disposition' => 'inline; filename="'.$fileName.'"'
		]);*/
	}

	public function cari($s_id, $k_id, Request $request)
    {
		$cari = $request->cari;
		$this->data['aksi'] 		= "cari";
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($s_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($k_id));
		$this->data['peserta'] 		= Peserta::where('kegiatan_id', '=', Crypt::decrypt($k_id))
										->whereHas('profil', function($q) use($cari){
											return $q->where('nama', 'like', '%'.$cari.'%')->orderBy('nama', 'ASC');
										})->paginate(10);

		return view($this->data['view_utama'], $this->data);
    }
}