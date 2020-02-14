<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use Auth;
use App\Models\Aktor\Operator\Konsultasi\Petugas;
use App\Profil;
use App\Model_roles;
use App\Models\Aktor\Operator\Legal\Sk;

use App\Models\Home\Riwayat\Instansi;
use App\Models\Home\Riwayat\Pendidikan;
use App\Models\Home\Riwayat\Pengalaman_pbj;
use App\Models\Home\Riwayat\Sertifikasi;

class HomeController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'home',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '',
		'link_sampah'       => '',
		'view_utama' 		=> 'home',
		'view_form' 	 	=> '',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
    );
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            
            if($this->user->status == '0')
            {
                return redirect('/konfirmasi');
            }

            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->data['profil']           = Profil::where('id', '=', Auth::user()->profil->id)->first();
        $this->data['instansi']         = Instansi::where('profil_id', '=', Auth::user()->profil->id)->get();

        $this->data['pengalaman_pbj']   = Pengalaman_pbj::orderBy('tahun', 'DESC')->where('profil_id', '=', Auth::user()->profil->id)->limit(2)->get();
        $this->data['pendidikan']       = Pendidikan::where('profil_id', '=', Auth::user()->profil->id)->get();
        $this->data['sertifikasi']      = Sertifikasi::where('profil_id', '=', Auth::user()->profil->id)
                                            ->whereHas('kegiatan', function($q){
                                                return $q->orderBy('tanggal', 'DESC');
                                            })
                                            ->get();

        $this->data['model_roles']      = Model_roles::select('sk.nomor', 'sk.akreditasi', 'sk.kadaluarsa', 'roles.name', 'roles.id', 'profil_profesi.id AS profesi_id', 'profil_profesi.sk_id')
                                            ->where('model_has_roles.model_id', '=', Auth::user()->id)
                                            ->where('profil_profesi.profil_id', '=', Auth::user()->profil->id)
                                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                                            ->join('sk', 'sk.role_id', '=', 'roles.id')
                                            ->join('profil_profesi', 'profil_profesi.sk_id', '=', 'sk.id')
                                            ->groupBy('roles.id')
                                            ->orderBy('sk.kadaluarsa', 'DESC')
                                            ->get();
        
        return view($this->data['view_utama'], $this->data);
    }

    public function foto($user_id, $profil_id)
    {
		$this->data['aksi']     = "tambah";
		$form_action 	        = "/home/upload/".$user_id.'/'.$profil_id;

        return view('home/data/profil/foto',['form_action' => $form_action]);
    }

    public function upload($user_id, $profil_id, Request $request)
    {
        $pesan = [
            'required'      => 'Wajib diisi.',
            'mimes'         => 'Format harus *.jpg, *.jpeg',
			'max'           => 'Ukuran foto maks 2mb.'
		];
		
		$this->validate($request,[
            'file' 			=> 'required|file|mimes:jpg,jpeg|max:2048',
		], $pesan);
		
        
        $file 				= $request->file('file');
 
		// $nama_file          = time()."_".$file->getClientOriginalName();
		// $tujuan_upload      = 'file_foto';
		// $file->move($tujuan_upload, $nama_file);
        
        $isi 				= Profil::find(Crypt::decrypt($profil_id));
        //$isi->file          = $nama_file;
        $isi->file 			= Storage::putFile('public/file_foto', $file);
        
        $isi->save();
 
    	return redirect('/home')->with(['success' => 'Foto berhasil diunggah.', 'error' => 'Gagal unggah. Cek kembali format atau ukuran foto.']);
	}
}
