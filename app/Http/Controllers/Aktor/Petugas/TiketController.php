<?php

namespace App\Http\Controllers\Aktor\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\Aktor\Petugas\Tiket;

//use App\Models\Aktor\Tamu\Konsultasi;
use App\Models\Aktor\Tamu\Profil;

class TiketController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'tiket',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'petugas',
		'aksi'        		=> '',
		'link'         		=> '/petugas',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/petugas/tiket/index',
		'view_form' 	 	=> 'aktor/petugas/tiket/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
    );
    
    public function index($user_id, $profil_id, $profesi_id)
    {      
        $this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
        $this->data['profesi_id']   = $profesi_id;

        $this->data['tiket']   	    = Tiket::orderBy('created_at', 'desc')->paginate(10);
        return view($this->data['view_utama'], $this->data);
    }

    /*public function detil($id)
    {
        $this->data['tiket']        = Tiket::find(Crypt::decrypt($id));
        $this->data['tamu']         = Tamu::find($isi->tamu_id);
        $this->data['konsultasi']   = Konsultasi::where('tiket_id', '=', Crypt::decrypt($id))->paginate(10);

        return view($this->data['view_utama'], $this->data);
    }

    public function riwayat($id)
    {
        $id         = Crypt::decrypt($id);
        $tamu       = Tamu::find($id);
    
        // $isi = Konsultasi::select('*', DB::raw('count(konsultasi.tiket_id) as total'))
        //                 ->join('tiket', 'tiket.id', '=', 'konsultasi.tiket_id')
        //                 ->join('tamu', 'tamu.id', '=', 'tiket.tamu_id')
        //                 ->where('tiket.tamu_id', '=', $id)
        //                 ->groupBy('tiket.nomor')
        //                 ->orderBy('tiket.created_at', 'desc')
        //                 ->paginate(10);

        $isi    = Konsultasi::whereHas('tiket', function($q) use ($id) {
                        return $q->where('tamu_id', '=', $id);
                    })
                    ->groupBy('konsultasi.tiket_id')
                    ->paginate(10);

        return view('tiket/riwayat', ['tamu' => $tamu, 'konsultasi' => $isi]);
    }

    public function jawab($t_id, $k_id)
	{		
	   	$id         = Crypt::decrypt($k_id);
        $t_id       = Crypt::decrypt($t_id);

        $tiket      = Tiket::find($t_id);
        
        $tamu       = Tamu::find($tiket->tamu_id);

        $subjek     = Subjek::all();
        $konsultasi = Konsultasi::find($id);
        $petugas    = Petugas::all();

	   	return view('tiket/jawab', ['tiket' => $tiket, 'tamu' => $tamu, 'subjek' => $subjek, 'konsultasi' => $konsultasi, 'petugas' => $petugas]);
	}

	public function update($t_id, $k_id, Request $request)
	{
        $pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
            'digits'        => 'Jumlah karakter harus :digits.',
            'email'         => 'Format harus email.',
        ];

        $this->validate($request,[
            'subjek_id'     => 'required',
    		'jawaban' 	    => 'required'
	    ], $pesan);

	    $isi 				= Konsultasi::find($k_id);

        $petugas_id = Petugas::where('user_id', '=', Auth::user()->id)->first();

	    $isi->petugas_id 	= $petugas_id->id;
        $isi->subjek_id     = $request->subjek_id;
    	$isi->jawaban 		= $request->jawaban;
        $isi->jawaban_at    = date("Y-m-d H:i:s");

	    $isi->save();

	    return redirect('/tiket/detil/'.Crypt::encrypt($t_id));
	}

    public function lihat($id)
    {
        $id        = Crypt::decrypt($id);
        
        $tiket     = Tiket::find($id);
        $tamu      = Tamu::find($tiket->tamu_id);
        
        $isi       = Konsultasi::select('subjek.*', 'konsultasi.*', 'petugas.nama')
                        ->join('subjek', 'subjek.id', '=', 'konsultasi.subjek_id')
                        ->leftJoin('petugas', 'petugas.id', '=', 'konsultasi.petugas_id')
                        ->where('konsultasi.tiket_id', '=', $id)
                        ->get();

        return view('tiket/lihat', ['tiket' => $tiket, 'tamu' => $tamu, 'konsultasi' => $isi]);
    }*/

    public function cari($user_id, $profil_id, $profesi_id, Request $request)
    {
        $cari   = $request->cari;

        $this->data['user_id']      = $user_id;
        $this->data['profil_id']    = $profil_id;
        $this->data['profesi_id']   = $profesi_id;

        $this->data['aksi']         = 'cari';
        $this->data['tiket']        = Tiket::where('nomor','like',"%".$cari."%")
                                        ->orWhereHas('tamu', function($q) use ($cari) {
                                        return $q->where('nik', 'LIKE', '%' . $cari . '%')
                                                    ->orWhere('nip', 'LIKE', '%' . $cari . '%')
                                                    ->orWhere('nama', 'LIKE', '%' . $cari . '%')
                                                    ->orWhere('instansi', 'LIKE', '%' . $cari . '%')
                                                    ->orWhere('email', 'LIKE', '%' . $cari . '%')
                                                    ->orWhere('hp', 'LIKE', '%' . $cari . '%');
                                        })            
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(10);
 
        $this->data['tiket']->appends($request->only('cari'));
        return view($this->data['view_utama'], $this->data);
    }

    /*public function cari_tiket($id, Request $request)
    {
        $cari       = $request->cari;

        $id         = Crypt::decrypt($id);
        $tamu       = Tamu::find($id);

        $this->data['aksi']        = 'cari';
        $this->data['tiket']       = Konsultasi::select('*', DB::raw('count(konsultasi.tiket_id) as total'))
                                        ->join('tiket', 'tiket.id', '=', 'konsultasi.tiket_id')
                                        ->join('tamu', 'tamu.id', '=', 'tiket.tamu_id')
                                        ->where('tiket.tamu_id', '=', $id)
                                        ->where('tiket.nomor', 'like', "%".$cari."%")
                                        ->groupBy('tiket.nomor')
                                        ->orderBy('tiket.created_at', 'desc')
                                        ->paginate(10);

        return view('tiket/riwayat', ['tamu' => $tamu, 'konsultasi' => $isi]);
    } */
}
