<?php

namespace App\Http\Controllers\Aktor\Operator\Konsultasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\Aktor\Operator\Konsultasi\Subjek;
use App\Models\Aktor\Operator\Konsultasi\Petugas;
use App\Models\Aktor\Operator\Konsultasi\Tamu;
use App\Models\Aktor\Operator\Konsultasi\Tiket;

class StatistikController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'statistik',
		'subjudul' 		 	=> 'subjek',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> 'operator/konsultasi',
		'aksi'        		=> '',
		'link'         		=> '/operator/konsultasi/statistik',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/operator/konsultasi/statistik',
		'view_form' 	 	=> '',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
    );
    
    public function index()
    {
        $this->data['subjek'] = Subjek::all();
        return view($this->data['view_utama'].'/index', $this->data);
    }

    public function petugas()
    {
        $this->data['subjudul'] = 'petugas';

        $this->data['petugas']  = Petugas::orderBy('nama', 'ASC')->get();
        return view($this->data['view_utama'].'/petugas', $this->data);
    }

    public function tamu()
    {
        $this->data['subjudul'] = 'tamu';

        $this->data['tamu'] = Tamu::orderBy('nama', 'ASC')->paginate(10);
        return view($this->data['view_utama'].'/tamu', $this->data);
    }

    public function tamu_subjek()
    {
        $this->data['subjudul'] = 'tamu_subjek';

        $this->data['subjek']   = Subjek::orderBy('kode', 'ASC')->get();
        $this->data['tamu']     = Tamu::orderBy('nama', 'ASC')->paginate(10);

        return view($this->data['view_utama'].'/tamu_subjek', $this->data);
    }

    public function tiket()
    {
        $this->data['subjudul'] = 'tiket';

        $this->data['jan'] = Tiket::whereMonth('created_at', '01');
        $this->data['feb'] = Tiket::whereMonth('created_at', '02');
        $this->data['mar'] = Tiket::whereMonth('created_at', '03');
        $this->data['apr'] = Tiket::whereMonth('created_at', '04');
        $this->data['mei'] = Tiket::whereMonth('created_at', '05');
        $this->data['jun'] = Tiket::whereMonth('created_at', '06');
        $this->data['jul'] = Tiket::whereMonth('created_at', '07');
        $this->data['agu'] = Tiket::whereMonth('created_at', '08');
        $this->data['sep'] = Tiket::whereMonth('created_at', '09');
        $this->data['okt'] = Tiket::whereMonth('created_at', '10');
        $this->data['nov'] = Tiket::whereMonth('created_at', '11');
        $this->data['des'] = Tiket::whereMonth('created_at', '12');
        $this->data['thn'] = Tiket::whereYear('created_at', date('Y'));

        return view($this->data['view_utama'].'/tiket', $this->data);
    }   
}