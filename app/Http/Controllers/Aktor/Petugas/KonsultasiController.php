<?php

namespace App\Http\Controllers\Aktor\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\Aktor\Petugas\Tiket;
use App\Models\Aktor\Petugas\Profesi;
use App\Models\Aktor\Petugas\Konsultasi;

use Auth;
use App\Models\Aktor\Operator\Konsultasi\Subjek;
use Response;

class KonsultasiController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'tiket',
		'subjudul' 		 	=> 'konsultasi',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'petugas',
		'aksi'        		=> '',
		'link'         		=> '/petugas',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/petugas/konsultasi/index',
		'view_form' 	 	=> 'aktor/petugas/konsultasi/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
    );
    
    public function index($user_id, $profil_id, $profesi_id, $tiket_id)
    {
        $this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
        $this->data['profesi_id']   = $profesi_id;
        $this->data['tiket_id']     = $tiket_id;

        $this->data['tiket']        = Tiket::find(Crypt::decrypt($tiket_id));
        $this->data['konsultasi']   = Konsultasi::where('tiket_id', '=', Crypt::decrypt($tiket_id))->paginate(10);

        return view($this->data['view_utama'], $this->data);
    }

    public function jawab($user_id, $profil_id, $profesi_id, $tiket_id, $konsultasi_id)
	{   
        $this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
        $this->data['profesi_id']   = $profesi_id;
        $this->data['tiket_id']     = $tiket_id;

        $this->data['aksi']         = 'jawab';
        $this->data['form_action'] 	= "/petugas/konsultasi/update/".$user_id."/".$profil_id."/".$profesi_id."/".$tiket_id."/".$konsultasi_id;
        
        $this->data['tiket']        = Tiket::find(Crypt::decrypt($tiket_id));
        $this->data['konsultasi']   = Konsultasi::find(Crypt::decrypt($konsultasi_id));
        $this->data['subjek']       = Subjek::all();
        
        return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $profesi_id, $tiket_id, $konsultasi_id, Request $request)
	{
        $this->validate($request,[
    		'subjek_id' 	=> 'required',
    		'jawaban' 	    => 'required'
	    ]);

        $isi 				        = Konsultasi::find(Crypt::decrypt($konsultasi_id));

        $isi->subjek_id 	        = $request->subjek_id;
        $isi->profil_profesi_id 	= Crypt::decrypt($profesi_id);
        $isi->jawaban 	            = $request->jawaban;
        $isi->jawaban_at 	        = date('Y-m-d H:i:s');

        $isi->save();
        
        return redirect('/petugas/konsultasi/'.$user_id.'/'.$profil_id.'/'.$profesi_id.'/'.$tiket_id);
	}

    /*public function lihat($id)
    {
        $id        = Crypt::decrypt($id);
        
        $tiket     = Tiket::find($id);
        $tamu      = Profil::find($tiket->tamu_id);
        
        $isi       = Konsultasi::select('subjek.*', 'konsultasi.*', 'petugas.nama')
                        ->join('subjek', 'subjek.id', '=', 'konsultasi.subjek_id')
                        ->leftJoin('petugas', 'petugas.id', '=', 'konsultasi.petugas_id')
                        ->where('konsultasi.tiket_id', '=', $id)
                        ->get();

        return view('konsultasi/lihat', ['tiket' => $tiket, 'tamu' => $tamu, 'konsultasi' => $isi]);
    }*/
    
    public function cari($user_id, $profil_id, $profesi_id, $tiket_id, Request $request)
    {
        $this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
        $this->data['profesi_id']   = $profesi_id;
        $this->data['tiket_id']     = $tiket_id;

        $cari = $request->cari;
        $this->data['aksi']         = 'cari';
        $this->data['tiket']        = Tiket::find(Crypt::decrypt($tiket_id));
        $this->data['konsultasi']   = Konsultasi::where('tiket_id', '=', Crypt::decrypt($tiket_id))
                                        ->where('konsultasi','like',"%".$cari."%")
                                        ->orWhere('jawaban','like',"%".$cari."%")
                                        ->orWhereHas('subjek', function($q) use ($cari) {
                                            return $q->where('kode', 'LIKE', '%' . $cari . '%')->orWhere('nama', 'LIKE', '%' . $cari . '%');
                                        })
                                        ->paginate(10);

        $this->data['konsultasi']->appends($request->only('cari'));
        return view($this->data['view_utama'], $this->data);
    }
}
