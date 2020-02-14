<?php

namespace App\Http\Controllers\Aktor\Operator\Legal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;
use App\User;
use App\Profil;
use App\Models\Aktor\Operator\Legal\Sk;
use App\Models\Aktor\Operator\Legal\Penerima;
use App\Models\Aktor\Operator\Legal\Akses;

class PenerimaController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'sk',
		'subjudul' 		 	=> 'penerima',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/legal',
		'aksi'        		=> '',
		'link'         		=> '/operator/legal',
		'link_sampah'       => '/operator/legal/penerima/sampah',
		'view_utama' 		=> 'aktor/operator/legal/penerima/index',
		'view_form' 	 	=> 'aktor/operator/legal/penerima/form',
		'view_sampah' 	 	=> 'aktor/operator/legal/penerima/sampah',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id, $profesi_id, $sk_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['sk_id'] 		= $sk_id;

		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['subjudul']."/tambah/".$user_id."/".$profil_id."/".$profesi_id."/".$sk_id;

		$this->data['sk'] 			= Sk::find(Crypt::decrypt($sk_id));
		$this->data['penerima'] 	= Penerima::where('sk_id', Crypt::decrypt($sk_id))->paginate(10);
		return view($this->data['view_utama'], $this->data);
    }

    public function tambah($user_id, $profil_id, $profesi_id, $sk_id, Request $request)
    {		
		$user 		= User::where('email', '=', $request->email)->count();

		if($user > 0)
		{
			// profil penerima sak
			$akses 			= Sk::find(Crypt::decrypt($sk_id))->role_id;
			$p_user_id 		= User::where('email', '=', $request->email)->first()->id;
			$p_profil_id 	= Profil::select('id')->where('user_id', '=', $p_user_id)->first()->id;

			// cek model_has ada tidak
			$eksis 		= Akses::where('role_id', '=', $akses)
								->where('model_id', '=', $p_user_id)
								->count();

			if($eksis > 0)
			{
				Akses::where('role_id', '=', $akses)
						->where('model_id', '=', $p_user_id)
						->delete();
						
				Penerima::create([
					'sk_id' 		=> Crypt::decrypt($sk_id),
					'profil_id' 	=> $p_profil_id,
					'created_by' 	=> Crypt::decrypt($profil_id)
				]);
						
				Akses::create([
					'role_id' 		=> $akses,
					'model_type' 	=> 'App\User',
					'model_id' 		=> $p_user_id
				]);
			}
			else
			{
				Penerima::create([
					'sk_id' 		=> Crypt::decrypt($sk_id),
					'profil_id' 	=> $p_profil_id,
					'created_by' 	=> Crypt::decrypt($profil_id)
				]);
				
				Akses::create([
					'role_id' 		=> $akses,
					'model_type' 	=> 'App\User',
					'model_id' 		=> $p_user_id
				]);
			}
	 
			return redirect($this->data['link'].'/'.$this->data['subjudul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id.'/'.$sk_id)->with(['success' => 'Penerima <b>'.$request->email.'</b> berhasil ditambah.']);
		}
		else
		{
			return redirect($this->data['link'].'/'.$this->data['subjudul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id.'/'.$sk_id)->with(['error' => 'Penerima <b>'.$request->email.'</b> tidak ditemukan.']);
		}
	}
	
	public function lihat($user_id, $profil_id, $profesi_id, $sk_id, $penerima_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['sk_id'] 		= $sk_id;
		$this->data['penerima_id'] 	= $penerima_id;

		$this->data['aksi'] 		= "lihat";
		$this->data['sk'] 			= Sk::find(Crypt::decrypt($sk_id));
		$this->data['penerima'] 	= Penerima::find(Crypt::decrypt($penerima_id));
		
		$p_profil_id 				= $this->data['penerima']->profil_id;
		$this->data['profesi'] 		= Sk::whereHas('penerima', function($q) use($p_profil_id) {
												return $q->where('profil_id', '=', $p_profil_id);
											})->orderBy('kadaluarsa', 'DESC')
											->get();
		
		return view($this->data['view_form'], $this->data);
	}

	public function cari($user_id, $profil_id, $profesi_id, $sk_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['sk_id'] 		= $sk_id;

		$cari 						= $request->cari;

		$this->data['aksi'] 		= "cari";
		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['subjudul']."/tambah/".$user_id."/".$profil_id."/".$profesi_id."/".$sk_id;

		$this->data['sk'] 			= Sk::find(Crypt::decrypt($sk_id));
		$this->data['penerima']  	= Penerima::where('sk_id', Crypt::decrypt($sk_id))
										->whereHas('profil', function($q) use($cari)
										{
											return $q->where('nama', 'like', '%'.$cari.'%')
													->orWhere('nip', 'like', '%'.$cari.'%');
										})->paginate(10);

		$this->data['penerima']->appends($request->only('cari'));

		return view($this->data['view_utama'], $this->data);
	}
	
	public function hapus($user_id, $profil_id, $profesi_id, $sk_id, $penerima_id)
	{
		$isi 				= Penerima::find(Crypt::decrypt($penerima_id));
		$isi->deleted_by 	= Crypt::decrypt($profil_id);
		
		$isi->delete();
		$isi->save();

		return redirect($this->data['link'].'/'.$this->data['subjudul'].'/'.$user_id.'/'.$profil_id.'/'.$profesi_id.'/'.$sk_id)->with(['success' => 'Penerima berhasil dihapus.']);
	}

	public function sampah($user_id, $profil_id, $profesi_id, $sk_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['profesi_id'] 	= $profesi_id;
		$this->data['sk_id'] 		= $sk_id;

		$this->data['subjudul'] = "sampah";
		$this->data['sk'] = Sk::onlyTrashed()->orderBy('tanggal', 'DESC')->paginate(10);
		return view($this->data['view_sampah'], $this->data);
	}

	public function kembalikan($user_id, $profil_id, $profesi_id, $sk_id, $penerima_id)
	{
        $isi   = Sk::onlyTrashed()->where('id', Crypt::decrypt($sk_id));
    	$isi->restore();
    	return redirect($this->data['link_sampah']);
	}

	public function kembalikan_semua($user_id, $profil_id, $profesi_id, $sk_id)
	{		
    	$isi = Sk::onlyTrashed();
    	$isi->restore();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen($user_id, $profil_id, $profesi_id, $sk_id, $penerima_id)
	{
        $isi   = Sk::onlyTrashed()->where('id', Crypt::decrypt($id));
    	$isi->forceDelete();

    	return redirect($this->data['link_sampah']);
	}

	public function hapus_permanen_semua($user_id, $profil_id, $profesi_id, $sk_id)
	{
    	$isi = Sk::onlyTrashed();
    	$isi->forceDelete();

		return redirect($this->data['link_sampah']);
	}
}