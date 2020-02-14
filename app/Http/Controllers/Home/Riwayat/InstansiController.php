<?php

namespace App\Http\Controllers\Home\Riwayat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Auth;
use App\Models\Aktor\Operator\Sarana\Klpd;
use App\Models\Home\Riwayat\Instansi;

use App\Rules\Nip\Thn_lhr; #1
use App\Rules\Nip\Bln_lhr; #2
use App\Rules\Nip\Tgl_lhr; #3
use App\Rules\Nip\Thn_msk; #4
use App\Rules\Nip\Bln_msk; #5
use App\Rules\Nip\Gender; #6

class InstansiController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'instansi',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/riwayat/instansi',
		'link_sampah'       => '',
		'view_utama' 		=> 'home/riwayat/instansi/detil',
		'view_form' 	 	=> 'home/riwayat/instansi/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);

	public function index($user_id, $profil_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;

		$this->data['instansi'] 	= Instansi::where('profil_id', '=', Crypt::decrypt($profil_id))->orderBy('tgl_mulai', 'DESC')->paginate(10);

		return view($this->data['view_utama'], $this->data);
    }

    public function tambah($user_id, $profil_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;

		$this->data['aksi'] 		= "tambah";
		$this->data['form_action'] 	= "/riwayat/instansi/store/".$user_id.'/'.$profil_id;
		$this->data['klpd'] 		= Klpd::all();

		return view($this->data['view_form'], $this->data);
    }

    public function store($user_id, $profil_id, Request $request)
    {
		$pesan = [
            'required'      	=> 'Wajib diisi.',
            'numeric'       	=> 'Wajib angka.',
			'digits'        	=> 'Jumlah karakter harus :digits.',
			'unique'        	=> 'Data :unique sudah ada.',
		];

		if($request->kategori == 'PNS')
		{
			$this->validate($request,[
				'klpd_id' 			=> 'required',
				'unit_kerja' 		=> 'required',
				'kategori'			=> 'required',
				'nomor_pegawai'		=> ['required', 'unique:riwayat_instansi', new Thn_lhr, new Bln_lhr, new Tgl_lhr, new Thn_msk, new Bln_msk, new Gender],
				'tgl_mulai'			=> 'required',
				'tgl_akhir'			=> 'nullable',
			], $pesan);
		}
		elseif($request->kategori == 'Polri' || $request->kategori == 'TNI')
		{
			$this->validate($request,[
				'klpd_id' 			=> 'required',
				'unit_kerja' 		=> 'required',
				'kategori'			=> 'required',
				'nomor_pegawai'		=> ['required','unique:riwayat_instansi'],
				'tgl_mulai'			=> 'required',
				'tgl_akhir'			=> 'nullable',
			], $pesan);
		}
		else
		{
			$this->validate($request,[
				'klpd_id' 			=> 'required',
				'unit_kerja' 		=> 'required',
				'kategori'			=> 'required',
				'tgl_mulai'			=> 'required',
				'tgl_akhir'			=> 'nullable',
			], $pesan);
		}
		
        Instansi::create([
			'klpd_id' 			=> $request->klpd_id,
			'profil_id'			=> Crypt::decrypt($profil_id),
			'unit_kerja' 		=> $request->unit_kerja,
			'kategori'			=> $request->kategori,
			'nomor_pegawai'		=> $request->nomor_pegawai,
			'tgl_mulai'			=> date('Y-m-d', strtotime($request->tgl_mulai)),
			'tgl_akhir'			=> date('Y-m-d', strtotime($request->tgl_akhir)),
    	]);
 
    	return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Instansi berhasil ditambah.']);
    }

    public function lihat($user_id, $profil_id, $instansi_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['instansi_id'] 	= $instansi_id;

		$this->data['aksi'] 		= "lihat";
		$this->data['instansi'] 	= Instansi::find(Crypt::decrypt($instansi_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function ubah($user_id, $profil_id, $instansi_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['instansi_id'] 	= $instansi_id;

		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/riwayat/instansi/update/".$user_id.'/'.$profil_id.'/'.$instansi_id;
		$this->data['instansi'] 	= Instansi::find(Crypt::decrypt($instansi_id));
		$this->data['klpd'] 		= Klpd::all();
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $instansi_id, Request $request)
	{
		$pesan = [
            'required'      	=> 'Wajib diisi.',
            'numeric'       	=> 'Wajib angka.',
			'digits'       		=> 'Jumlah karakter harus :digits.',
			'unique'        	=> 'Data :unique sudah ada.',
		];

		$this->validate($request,[
			'klpd_id' 			=> 'required',
			'unit_kerja' 		=> 'required',
			'kategori'			=> 'required',
			'nomor_pegawai'		=> 'required',
			'tgl_mulai'			=> 'required',
			'tgl_akhir'			=> 'nullable',
	    ], $pesan);

	    $isi 					= Instansi::find(Crypt::decrypt($instansi_id));

	    $isi->klpd_id 			= $request->klpd_id;
		$isi->unit_kerja 		= $request->unit_kerja;
		$isi->kategori 			= $request->kategori;
		$isi->nomor_pegawai 	= $request->nomor_pegawai;
		$isi->tgl_mulai 		= date('Y-m-d', strtotime($request->tgl_mulai));
		$isi->tgl_akhir 		= date('Y-m-d', strtotime($request->tgl_akhir));

	    $isi->save();
	    return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Instansi berhasil diubah.']);
	}

	public function hapus($user_id, $profil_id, $instansi_id)
	{
        $isi 				= Instansi::find(Crypt::decrypt($instansi_id));
		$isi->delete();
		
	    return redirect($this->data['link'].'/'.$user_id.'/'.$profil_id)->with(['success' => 'Instansi berhasil dihapus.']);
	}

	public function cari($user_id, $profil_id, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;

		$cari 	= $request->cari;
		$this->data['aksi'] 	= "cari";
		$this->data['instansi'] 	= Instansi::orderBy('nama', 'ASC')
									->where('kode','like',"%".$cari."%")
									->orWhere('nama','like',"%".$cari."%")
									->orWhere('fungsi','like',"%".$cari."%")
									->whereNull('deleted_at')
									->paginate(10);
		
		$this->data['instansi']->appends($request->only('cari'));
					
		return view($this->data['view_utama'], $this->data);
	}
}