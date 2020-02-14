<?php

namespace App\Http\Controllers\Aktor\Operator\Jadwal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use App\Models\Aktor\Operator\Jadwal\Surat;

class SuratController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'surat',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/jadwal',
		'aksi'        		=> '',
		'link'         		=> '/operator/jadwal',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/operator/jadwal/surat/index',
		'view_form' 	 	=> '',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	public function index()
    {
		$this->data['surat'] 	= Surat::orderBy('tanggal', 'DESC')->paginate(10);
		
		return view($this->data['view_utama'], $this->data);
	}
	
	public function unduh($id)
	{
		$model_file = Surat::findOrFail(Crypt::decrypt($id));
		return Storage::download($model_file->file);
   }

   	public function cari(Request $request)
    {
		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['surat']    = Surat::whereHas('lpp', function($q) use($cari){
											return $q->where('nama', 'like', '%'.$cari.'%')
													->orWhere('alias', 'like', '%'.$cari.'%');
										})
										->orWhere('nomor','like',"%".$cari."%")
										->orWhere('tentang','like',"%".$cari."%")
										->orWhere('tanggal','like',"%".date('Y-m-d', strtotime($cari))."%")
										->orderBy('tanggal', 'DESC')
										->paginate(10);
		
		$this->data['surat']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
    }
}