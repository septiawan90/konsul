<?php

namespace App\Http\Controllers\Aktor\Tamu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use App\Models\Aktor\Tamu\Tiket;
use App\Models\Aktor\Tamu\Profil;
use App\Models\Aktor\Tamu\Konsultasi;

use App\Models\Aktor\Operator\Konsultasi\Subjek;
//use App\Models\Aktor\Operator\Konsultasi\Petugas;
use Response;

class KonsultasiController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'profil',
		'subjudul' 		 	=> 'tiket',
		'subsubjudul' 		=> 'konsultasi',
		'fungsi' 		 	=> 'tamu',
		'aksi'        		=> '',
		'link'         		=> '/tamu',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/tamu/konsultasi/index',
		'view_form' 	 	=> 'aktor/tamu/konsultasi/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
    );
    
    public function index($id, $t_id)
    {
        $id                         = Crypt::decrypt($id);
        $tiket_id                   = Crypt::decrypt($t_id);
        $this->data['profil']       = Profil::find($id);
        $this->data['tiket']        = Tiket::find($tiket_id);
        $this->data['konsultasi']   = Konsultasi::where('tiket_id', '=', $tiket_id)->paginate(10);
                    
        return view($this->data['view_utama'], $this->data);
    }

    public function tambah($id, $t_id)
    {
        $this->data['aksi']         = 'tambah';
        $this->data['form_action'] 	= "/konsultasi/store/".$id."/".$t_id;

        $this->data['profil']       = Profil::find(Crypt::decrypt($id));
        $this->data['tiket']        = Tiket::find(Crypt::decrypt($t_id));
        $this->data['subjek']       = Subjek::all();
        //$this->data['petugas']      = Petugas::all();

        return view($this->data['view_form'], $this->data);
    }

    public function store($id, $t_id, Request $request)
    {
        $pesan = [
            'required'      => 'Wajib diisi.'
        ];

        $this->validate($request,[
    		'subjek_id' 	=> 'required',
    		'konsultasi' 	=> 'required'
    	], $pesan);
 
        Konsultasi::create([
            'tiket_id'      => Crypt::decrypt($t_id),
    		'subjek_id' 	=> $request->subjek_id,
    		'konsultasi' 	=> $request->konsultasi
    	]);
        
    	return redirect('/konsultasi/'.$id.'/'.$t_id);
    }

    public function ubah($id, $t_id, $k_id)
	{   
        $this->data['aksi']         = 'ubah';
        $this->data['form_action'] 	= "/konsultasi/update/".$id."/".$t_id."/".$k_id;

        $this->data['profil']       = Profil::find(Crypt::decrypt($id));
        $this->data['tiket']        = Tiket::find(Crypt::decrypt($t_id));
        $this->data['konsultasi']   = Konsultasi::find(Crypt::decrypt($k_id));
        $this->data['subjek']       = Subjek::all();
        //$this->data['petugas']      = Petugas::all();
        
        return view($this->data['view_form'], $this->data);
	}

	public function update($id, $t_id, $k_id, Request $request)
	{
        $this->validate($request,[
    		'subjek_id' 	=> 'required',
    		'konsultasi' 	=> 'required'
	    ]);

	    $isi 				= Konsultasi::find(Crypt::decrypt($k_id));

    	$isi->subjek_id 	= $request->subjek_id;
    	$isi->konsultasi 	= $request->konsultasi;
        $isi->save();
        
        return redirect('/konsultasi/'.$id.'/'.$t_id);
	}

    public function lihat($id)
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
    }

	public function delete($id)
	{
	    $id    = Crypt::decrypt($id);
        $isi   = Konsultasi::find($id);
	    $isi->delete();

	    return redirect()->back();
	}

	public function sampah()
	{
    	$isi = Konsultasi::onlyTrashed()->get();
    	return view('konsultasi/sampah', ['konsultasi' => $isi]);
	}

	public function kembalikan($id)
	{
    	$id     = Crypt::decrypt($id);
        $isi    = Konsultasi::onlyTrashed()->where('id', $id);
    	$isi->restore();
    	return redirect('/konsultasi/sampah');
	}

	public function kembalikan_semua()
	{		
    	$isi = Konsultasi::onlyTrashed();
    	$isi->restore();

    	return redirect('/konsultasi/sampah');
	}

	public function hapus_permanen($id)
	{
    	$id    = Crypt::decrypt($id);

        $isi   = Konsultasi::onlyTrashed()->where('id', $id);
    	$isi->forceDelete();

    	return redirect('/konsultasi/sampah');
	}

	public function hapus_permanen_semua()
	{
    	$isi = Konsultasi::onlyTrashed();
    	$isi->forceDelete();

    	return redirect('/konsultasi/sampah');
	}

    public function cari($id, $t_id, Request $request)
    {
        $cari = $request->cari;
        $this->data['aksi']         = 'cari';
        
        $this->data['profil']       = Profil::find(Crypt::decrypt($id));
        $this->data['tiket']        = Tiket::find(Crypt::decrypt($t_id));
        $this->data['konsultasi']   = Konsultasi::where('konsultasi','like',"%".$cari."%")
                                        ->orWhere('jawaban','like',"%".$cari."%")
                                        ->orWhereHas('subjek', function($q) use ($cari) {
                                            return $q->where('kode', 'LIKE', '%' . $cari . '%')->orWhere('nama', 'LIKE', '%' . $cari . '%');
                                        })
                                        ->where('tiket_id', '=', Crypt::decrypt($t_id))
                                        ->paginate(10);

        $this->data['konsultasi']->appends($request->only('cari'));
        return view($this->data['view_utama'], $this->data);
    }

    /*
    public function cari_tiket($id, Request $request)
    {
        $cari       = $request->cari;
        
        $id     = Crypt::decrypt($id);
        $tamu   = Profil::find($id);
        $isi    = Konsultasi::select('*', DB::raw('count(konsultasi.tiket_id) as total'))
                    ->join('tiket', 'tiket.id', '=', 'konsultasi.tiket_id')
                    ->join('tamu', 'tamu.id', '=', 'tiket.tamu_id')
                    ->where('tiket.tamu_id', '=', $id)
                    ->where('tiket.nomor', 'like', "%".$cari."%")
                    ->orderBy('tiket.created_at', 'desc')
                    ->groupBy('konsultasi.tiket_id')
                    ->paginate(10);

        return view('konsultasi/index', ['tamu' => $tamu, 'konsultasi' => $isi]);
    }*/
}
