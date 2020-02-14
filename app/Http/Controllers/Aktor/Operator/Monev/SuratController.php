<?php

namespace App\Http\Controllers\Aktor\Operator\Monev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use App\Models\Aktor\Operator\Monev\Surat;

class SuratController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'surat',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/monev',
		'aksi'        		=> '',
		'link'         		=> '/operator/monev',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/operator/monev/surat/index',
		'view_form' 	 	=> '',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id, $profesi_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;

		$this->data['surat'] 	= Surat::orderBy('tanggal', 'DESC')->paginate(10);
		
		return view($this->data['view_utama'], $this->data);
	}
	
	public function unduh($id)
	{
		$model_file = Surat::findOrFail(Crypt::decrypt($id));
		return Storage::download($model_file->file);
	   }
	   
	public function status($user_id, $profil_id, $profesi_id, $surat_id, Request $request)
	{
		$isi 				= Surat::find(Crypt::decrypt($surat_id));	
		$isi->status 		= $request->status;
		$isi->status_by 	= Crypt::decrypt($profesi_id);
		$isi->status_at 	= date('Y-m-d H:i:s');
		$isi->save();
		
		return redirect($this->data['link'].'/'.$this->data['judul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id)
				->with(['sukses' => 'Surat nomor '.$request->nomor.' telah di'.$request->status.'.']);
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