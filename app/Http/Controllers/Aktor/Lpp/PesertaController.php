<?php

namespace App\Http\Controllers\Aktor\Lpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Profil;
use App\Models\Aktor\Lpp\Surat;
use App\Models\Aktor\Lpp\Kegiatan;
use App\Models\Aktor\Lpp\Peserta;
use App\Models\Home\Riwayat\Instansi;
use App\Models\Home\Riwayat\Pendidikan;
use App\Models\Aktor\Operator\Sertifikat\Tingkat_dasar;

class PesertaController extends Controller
{
	public $data = array
	(
		'judul'         	=> 'surat',
		'subjudul' 		 	=> 'kegiatan',
		'subsubjudul' 		=> 'peserta',
		'fungsi' 		 	=> 'lpp',
		'aksi'        		=> '',
		'link'         		=> '/lpp',
		'link_sampah'       => '',
		'view_utama' 		=> 'aktor/lpp/peserta/index',
		'view_form' 	 	=> 'aktor/lpp/peserta/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
	);
	
	public function index($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;
		$this->data['kegiatan_id'] 	= $kegiatan_id;

		$this->data['view'] 		= 'table';

		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($kegiatan_id));
		$this->data['peserta'] 		= Peserta::where('kegiatan_id', '=', Crypt::decrypt($kegiatan_id))->paginate(10);
		
		return view($this->data['view_utama'], $this->data);
	}

	public function card($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;
		$this->data['kegiatan_id'] 	= $kegiatan_id;

		$this->data['view'] 		= 'card';

		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($kegiatan_id));
		$this->data['peserta'] 		= Peserta::where('kegiatan_id', '=', Crypt::decrypt($kegiatan_id))->paginate(10);
		
		return view($this->data['view_utama'], $this->data);
	}

	public function tambah($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id, Request $request)
	{
		// 1. Ambil data peserta
		// 2. cek pemilikan Email berdasarkan NIK, jika lebih dari satu maka ditolak 
		// 3. cek foto
		// 4. cek instansi
		// 5. cek pendidikan terakhir
		// 6. cek pemilikan sertifikat nik + email + nip
		// 7. cek calon peserta terdaftar di kegiatan lain, jika masih daftar maka ditolak
		// 8. cek peserta terakhir ujian
		// 9. daftar kegiatan
		// 10. kloning data persyaratan ke tabel daftar

		$pesan = [
            'required'      => 'Wajib diisi.',
            'email'      	=> 'Format email',
		];
		
		$this->validate($request,[
			'email' 		=> 'required|email',
		], $pesan);

		// 1. Ambil data peserta
		$cek1 			= User::where('email', '=', $request->email)->first();
		
		if(is_null($cek1))
		{
			return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
					->with(['warning' => 'Peserta <b>'.$request->email.'</b> tidak ditemukan. [#01]']);
		}
		else
		{
			$p_user_id 		= $cek1->id;		
			$p_profil_id 	= Profil::select('id')->where('user_id', '=', $p_user_id)->first()->id;

			# ---
			// 2. periksa pemilikan Email berdasarkan NIK, jika lebih dari satu maka ditolak 
			$cek2 			= User::where('nik', '=', $cek1->nik)->count();
			
			if($cek2 > 1)
			{
				return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
						->with(['warning' => 'Peserta <b>'.$request->email.'</b> memiliki lebih dari 1 (satu) email, silahkan konfirmasi terlebih dahulu. [#02]']);
			}
			else
			{
				// 3. cek foto
				$cek3 = Profil::find($p_profil_id)->file;
				
				if(is_null($cek3) || empty($cek3))
				{
					return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
							->with(['warning' => 'Peserta <b>'.$request->email.'</b> belum mengunggah foto. [#03]']);
				}
				else
				{
					// 4. cek instansi untuk ambil nomor anggota/pegawai
					$cek4 = Instansi::where('profil_id', '=', $p_profil_id);

					if($cek4->count() == 0)
					{
						return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
							->with(['warning' => 'Peserta <b>'.$request->email.'</b> belum mengisi riwayat instansi. [#04]']);
					}
					else
					{
						// 5. cek pendidikan
						$cek5 = Pendidikan::where('profil_id', '=', $p_profil_id);

						if($cek5->count() == 0)
						{
							return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
								->with(['warning' => 'Peserta <b>'.$request->email.'</b> belum mengisi riwayat pendidikan. [#05]']);
						}
						else
						{
							//6. cek syarat pendidikan 3 = SMA
							$cek6 = $cek5->join('strata', 'strata.id', '=', 'riwayat_pendidikan.strata_id')
									->orderBy('strata.level', 'DESC')
									->first();

							if($cek6->level < 3)
							{
								return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
											->with(['warning' => 'Peserta <b>'.$request->email.'</b> tidak memiliki kualifikasi pendidikan yang disyaratkan. [#06]']);
							}
							else
							{
								// 7. cek pemilikan sertifikat
								$cek7 = Tingkat_dasar::where('nik', '=', $cek1->nik)
														->orWhere('nip', '=', $cek4->first()->nomor_pegawai);
								
								if($cek7->count() > 0)
								{
									return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
										->with(['warning' => 'Peserta <b>'.$request->email.'</b> telah memiliki sertifikat tingkat dasar dengan nomor sertifikat '.$cek7->first()->nomor].'. [#07]');
								}
								else
								{
									// 8. periksa calon peserta terdaftar di kegiatan lain, jika masih terdaftar maka ditolak
									$cek8 = Peserta::where('profil_id', '=', $p_profil_id)->where('status', '=', 'verifikasi')->count();

									if($cek8 > 0)
									{
										$info = Peserta::whereHas('kegiatan')->whereHas('profil', function($q) use($p_user_id)
										{
											return $q->where('user_id', '=', $p_user_id);
										})->first();

										return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
												->with(['warning' => 'Peserta <b>'.$request->email.'</b> masih terdaftar ujian pada tanggal '.date("d-m-Y", strtotime($info->kegiatan->tanggal)).' dengan kode peserta '.$info->kode.'. [#08]' ]);
									}
									else
									{
										//9. cek peserta terakhir ujian
										$cek9 	= Kegiatan::whereHas('peserta', function($q) use($p_profil_id) {
														return $q->where('profil_id', '=', $p_profil_id)
																	->where('status', '=', 'disetujui')
																	->orderBy('created_at', 'DESC');
														})->first();

										if($cek9)
										{
											$tgl_kegiatan	= Kegiatan::select('tanggal')->find(Crypt::decrypt($kegiatan_id))->tanggal;
											$tgl_batas 		= date('Y-m-d', strtotime($tgl_kegiatan.' + 10 days'));

											if($cek9->tanggal <= $tgl_batas)
											{
												return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
														->with(['warning' => 'Peserta <b>'.$request->email.'</b> masih dalam ketentuan batas waktu pendaftaran 14 hari kerja terhitung sejak tanggal ujian '.tanggal($cek9->tanggal).'. [#09]']);
											}
											else
											{
												//10. daftar kegiatan
												$kegiatan 			= Kegiatan::select('kode')->where('id', '=', Crypt::decrypt($kegiatan_id))->first();
												$angka 				= Peserta::where('kegiatan_id', '=', Crypt::decrypt($kegiatan_id))->count();
												$urutan 			= is_null($angka) || empty($angka) ? 1 : $angka + 1;
												$kode 				= str_pad($urutan,3,"0",STR_PAD_LEFT);

												Peserta::create([
													'kode' 			=> $kegiatan->kode.''.$kode,
													'kegiatan_id' 	=> Crypt::decrypt($kegiatan_id),
													'profil_id' 	=> $p_profil_id,
													'status' 		=> 'verifikasi',
													'created_by'	=> $profil_id
												]);

												# ------> kloning data peserta ke tabel baru -> belum dibuat 
												// profil (foto)
												// riwayat instansi (nip)
												// riwayat pendidikan
												// 
												
												return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
														->with(['success' => 'Peserta <b>'.$request->email.'</b> berhasil didaftarkan.']);
											}
											
										}
										else
										{
											//6. daftar kegiatan
											$kegiatan 			= Kegiatan::select('kode')->where('id', '=', Crypt::decrypt($kegiatan_id))->first();
											$angka 				= Peserta::where('kegiatan_id', '=', Crypt::decrypt($kegiatan_id))->count();
											$urutan 			= is_null($angka) || empty($angka) ? 1 : $angka + 1;
											$kode 				= str_pad($urutan,3,"0",STR_PAD_LEFT);

											Peserta::create([
												'kode' 			=> $kegiatan->kode.''.$kode,
												'kegiatan_id' 	=> Crypt::decrypt($kegiatan_id),
												'profil_id' 	=> $p_profil_id,
												'status' 		=> 'verifikasi',
												'created_by'	=> $profil_id
											]);

											# ------> kloning data peserta ke tabel baru -> belum dibuat

											return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
													->with(['success' => 'Peserta <b>'.$request->email.'</b> berhasil didaftarkan.']);
										}
									}
								}
							}
						}
					}
				}
			}
			# ---
		}
	}

	public function ubah($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id, $peserta_id)
	{
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;
		$this->data['kegiatan_id'] 	= $kegiatan_id;

		$this->data['form_action'] 	= "/".$this->data['fungsi']."/".$this->data['subsubjudul']."/update/".$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id.'/'.$peserta_id;

		$this->data['aksi'] 		= 'ubah';
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($kegiatan_id));
		$this->data['peserta'] 		= Peserta::find(Crypt::decrypt($peserta_id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id, $peserta_id, Request $request)
	{
		$pesan = [
            'required'      => 'Wajib diisi.',
			'max'      		=> 'Maksimal dokumen :max ',
			'mimes'      	=> 'Dokumen harus :mimes ',
		];
		
		$this->validate($request,[
			'file' 			=> 'nullable|file|mimes:pdf|max:2048',
		], $pesan);

		$file 				= $request->file('file');
		$isi 				= Peserta::find(Crypt::decrypt($peserta_id));
		$isi->status 		= $request->status;
		
		if($file)
		{
			$isi->file 		= Storage::putFile('public/file_peserta', $request->file('file'));
		}
		
		$isi->updated_by 	= $profil_id;
		$isi->save();

		return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
						->with(['success' => 'Peserta <b>'.$isi->profil->user->email.'</b> berhasil diubah.']);
	}
	
	public function batal($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id, $peserta_id)
	{
		$isi 				= Peserta::find(Crypt::decrypt($peserta_id));
		$isi->deleted_by 	= $profil_id;
		
		$isi->delete();
		$isi->save();

	    return redirect($this->data['link'].'/'.$this->data['subsubjudul'].'/'.$user_id.'/'.$profil_id.'/'.$lpp_id.'/'.$surat_id.'/'.$kegiatan_id)
				->with(['success' => 'Peserta berhasil dibatalkan.']);
	}

	public function unduh($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id, $peserta_id)
	{
		$model_file = Peserta::findOrFail(Crypt::decrypt($peserta_id)); //Mencari model atau objek yang dicari
		return Storage::download($model_file->file);
   	}

	public function cari($user_id, $profil_id, $lpp_id, $surat_id, $kegiatan_id, $view, Request $request)
    {
		$this->data['user_id'] 		= $user_id;
		$this->data['profil_id'] 	= $profil_id;
		$this->data['lpp_id'] 		= $lpp_id;
		$this->data['surat_id'] 	= $surat_id;
		$this->data['kegiatan_id'] 	= $kegiatan_id;
		
		$this->data['view'] 		= 'card';

		$cari 	= $request->cari;

		$this->data['aksi'] 		= "cari";
		$this->data['surat'] 		= Surat::find(Crypt::decrypt($surat_id));
		$this->data['kegiatan'] 	= Kegiatan::find(Crypt::decrypt($kegiatan_id));

		$this->data['peserta']    	= Peserta::where('kode','like',"%".$cari."%")
										->orWhere('created_at','like',"%".date("Y-m-d", strtotime($cari))."%")
										->orWhere('status','like',"%".$cari."%")
										->orWhereHas('profil', function($q) use($cari)
										{
											return $q->where('nama', 'like', '%'.$cari.'%')
														->orWhereHas('user', function($q) use($cari)
														{
															return $q->where('email', 'like', '%'.$cari.'%');
														});
										})
										->where('kegiatan_id', '=', Crypt::decrypt($kegiatan_id))
										->orderBy('created_at', 'DESC')
										->paginate(10);

		$this->data['peserta']->appends($request->only('cari'));									
		
		return view($this->data['view_utama'], $this->data);
	}
}