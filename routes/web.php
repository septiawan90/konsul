<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

#----
Route::resource('/konfirmasi','KonfirmasiController');
Route::get('/konfirmasi', 'KonfirmasiController@index')->name('konfirmasi');
Route::put('/konfirmasi/update/{id}', 'KonfirmasiController@update');
Route::get('/profil', 'ProfilController@index')->name('profil');

Route::get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');
#-----

// konsultasi
Route::get('/profil/cari','Aktor\Tamu\ProfilController@cari');
Route::get('/profil/telusur','Aktor\Tamu\ProfilController@telusur');
Route::get('/profil/pin/{id}','Aktor\Tamu\ProfilController@pin');
Route::get('/profil/pin_telusur/{id}','Aktor\Tamu\ProfilController@pin_telusur');
Route::get('/profil/tamu/{id}','Aktor\Tamu\ProfilController@tamu');
Route::get('/profil/tambah', 'Aktor\Tamu\ProfilController@tambah');
Route::post('/profil/store', 'Aktor\Tamu\ProfilController@store');

Route::get('/tiket/{id}', 'Aktor\Tamu\TiketController@index');
Route::get('/tiket/cari/{id}','Aktor\Tamu\TiketController@cari');
Route::get('/tiket/tambah/{id}', 'Aktor\Tamu\TiketController@tambah');
Route::post('/tiket/store/{id}', 'Aktor\Tamu\TiketController@store');

#----

Route::get('/konsultasi/{id}/{t_id}', 'Aktor\Tamu\KonsultasiController@index');
Route::get('/konsultasi/tambah/{id}/{t_id}', 'Aktor\Tamu\KonsultasiController@tambah');
Route::post('/konsultasi/store/{id}/{t_id}', 'Aktor\Tamu\KonsultasiController@store');
Route::get('/konsultasi/ubah/{id}/{t_id}/{k_id}', 'Aktor\Tamu\KonsultasiController@ubah');
Route::put('/konsultasi/update/{id}/{t_id}/{k_id}', 'Aktor\Tamu\KonsultasiController@update');
Route::get('/konsultasi/cari/{id}/{t_id}','Aktor\Tamu\KonsultasiController@cari');
Route::get('/konsultasi/hapus/{id}/{t_id}/{k_id}', 'Aktor\Tamu\KonsultasiController@hapus');
Route::get('/konsultasi/lihat/{id}/{t_id}/{k_id}','Aktor\Tamu\KonsultasiController@lihat');

#Route::get('/konsultasi/sampah', 'KonsultasiController@sampah');
#Route::get('/konsultasi/kembalikan/{id}', 'KonsultasiController@kembalikan');
#Route::get('/konsultasi/kembalikan_semua', 'KonsultasiController@kembalikan_semua');
#Route::get('/konsultasi/hapus_permanen/{id}', 'KonsultasiController@hapus_permanen');
#Route::get('/konsultasi/hapus_permanen_semua', 'KonsultasiController@hapus_permanen_semua');

#-----

Auth::routes();

//verifikasi email user
Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function() {
	
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/home/foto/{user_id}/{profil_id}', 'HomeController@foto');
	Route::put('/home/upload/{user_id}/{profil_id}', 'HomeController@upload');
	
	//riwayat instansi
	Route::get('/riwayat/instansi/{user_id}/{profil_id}', 'Home\Riwayat\InstansiController@index');
	Route::get('/riwayat/instansi/tambah/{user_id}/{profil_id}', 'Home\Riwayat\InstansiController@tambah');
	Route::post('/riwayat/instansi/store/{user_id}/{profil_id}', 'Home\Riwayat\InstansiController@store');
	Route::get('/riwayat/instansi/lihat/{user_id}/{profil_id}/{instansi_id}', 'Home\Riwayat\InstansiController@lihat');
	Route::get('/riwayat/instansi/ubah/{user_id}/{profil_id}/{instansi_id}', 'Home\Riwayat\InstansiController@ubah');
	Route::put('/riwayat/instansi/update/{user_id}/{profil_id}/{instansi_id}', 'Home\Riwayat\InstansiController@update');
	Route::put('/riwayat/instansi/hapus/{user_id}/{profil_id}/{instansi_id}', 'Home\Riwayat\InstansiController@hapus');
	Route::get('/riwayat/instansi/cari/{user_id}/{profil_id}', 'Home\Riwayat\InstansiController@cari');

	//riwayat pendidikan
	Route::get('/riwayat/pendidikan/{user_id}/{profil_id}', 'Home\Riwayat\PendidikanController@index');
	Route::get('/riwayat/pendidikan/tambah/{user_id}/{profil_id}', 'Home\Riwayat\PendidikanController@tambah');
	Route::post('/riwayat/pendidikan/store/{user_id}/{profil_id}', 'Home\Riwayat\PendidikanController@store');
	Route::get('/riwayat/pendidikan/lihat/{user_id}/{profil_id}/{pendidikan_id}', 'Home\Riwayat\PendidikanController@lihat');
	Route::get('/riwayat/pendidikan/ubah/{user_id}/{profil_id}/{pendidikan_id}', 'Home\Riwayat\PendidikanController@ubah');
	Route::put('/riwayat/pendidikan/update/{user_id}/{profil_id}/{pendidikan_id}', 'Home\Riwayat\PendidikanController@update');
	Route::put('/riwayat/pendidikan/hapus/{user_id}/{profil_id}/{pendidikan_id}', 'Home\Riwayat\PendidikanController@hapus');
	Route::get('/riwayat/pendidikan/cari/{user_id}/{profil_id}', 'Home\Riwayat\PendidikanController@cari');

	//riwayat pengalaman pbj
	Route::get('/riwayat/pengalaman_pbj/{user_id}/{profil_id}', 'Home\Riwayat\Pengalaman_pbjController@index');
	Route::get('/riwayat/pengalaman_pbj/tambah/{user_id}/{profil_id}', 'Home\Riwayat\Pengalaman_pbjController@tambah');
	Route::post('/riwayat/pengalaman_pbj/store/{user_id}/{profil_id}', 'Home\Riwayat\Pengalaman_pbjController@store');
	Route::get('/riwayat/pengalaman_pbj/lihat/{user_id}/{profil_id}/{pengalaman_pbj_id}', 'Home\Riwayat\Pengalaman_pbjController@lihat');
	Route::get('/riwayat/pengalaman_pbj/ubah/{user_id}/{profil_id}/{pengalaman_pbj_id}', 'Home\Riwayat\Pengalaman_pbjController@ubah');
	Route::put('/riwayat/pengalaman_pbj/update/{user_id}/{profil_id}/{pengalaman_pbj_id}', 'Home\Riwayat\Pengalaman_pbjController@update');
	Route::put('/riwayat/pengalaman_pbj/hapus/{user_id}/{profil_id}/{pengalaman_pbj_id}', 'Home\Riwayat\Pengalaman_pbjController@hapus');
	Route::get('/riwayat/pengalaman_pbj/cari/{user_id}/{profil_id}', 'Home\Riwayat\Pengalaman_pbjController@cari');

	// provinsi
	Route::get('/provinsi', 'Daerah\ProvinsiController@index');
	Route::get('/provinsi/cari', 'Daerah\ProvinsiController@cari');

	// kota
	Route::get('/kota', 'Daerah\KotaController@index');
	Route::get('/kota/cari', 'Daerah\KotaController@cari');

	// kecamatan
	Route::get('/kecamatan', 'Daerah\KecamatanController@index');
	Route::get('/kecamatan/cari', 'Daerah\KecamatanController@cari');

	// kelurahan
	Route::get('/kelurahan', 'Daerah\KelurahanController@index');
	Route::get('/kelurahan/cari', 'Daerah\KelurahanController@cari');

	Route::group(['prefix' => 'petugas','middleware'=> ['role:petugas']], function(){	
		Route::get('/tiket/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Petugas\TiketController@index');
		Route::get('/tiket/cari/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Petugas\TiketController@cari');

		Route::get('/konsultasi/{user_id}/{profil_id}/{profesi_id}/{tiket_id}', 'Aktor\Petugas\KonsultasiController@index');
		Route::get('/konsultasi/cari/{user_id}/{profil_id}/{profesi_id}/{tiket_id}', 'Aktor\Petugas\KonsultasiController@cari');
		Route::get('/konsultasi/jawab/{user_id}/{profil_id}/{profesi_id}/{tiket_id}/{konsultasi_id}', 'Aktor\Petugas\KonsultasiController@jawab');
		Route::put('/konsultasi/update/{user_id}/{profil_id}/{profesi_id}/{tiket_id}/{konsultasi_id}', 'Aktor\Petugas\KonsultasiController@update');

		//Route::get('/tiket/riwayat/{id}', 'Aktor\Petugas\TiketController@riwayat');
		//Route::get('/tiket/lihat/{id}','Aktor\Petugas\TiketController@lihat');

		Route::get('/tamu/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Petugas\TamuController@index');
		Route::get('/tamu/cari/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Petugas\TamuController@cari');
		Route::get('/tamu/ubah/{user_id}/{profil_id}/{profesi_id}/{tamu_id}', 'Aktor\Petugas\TamuController@ubah');
		Route::put('/tamu/update/{user_id}/{profil_id}/{profesi_id}/{tamu_id}', 'Aktor\Petugas\TamuController@update');
		Route::get('/tamu/riwayat/{user_id}/{profil_id}/{profesi_id}/{tamu_id}', 'Aktor\Petugas\TamuController@riwayat');
		Route::get('/tamu/cari_tiket/{user_id}/{profil_id}/{profesi_id}/{tamu_id}', 'Aktor\Petugas\TamuController@cari_tiket');
		Route::get('/tamu/detil/{user_id}/{profil_id}/{profesi_id}/{tamu_id}/{tiket_id}', 'Aktor\Petugas\TamuController@detil');
		
		// Route::get('/tamu/hapus/{user_id}/{profil_id}/{profesi_id}/{tamu_id}', 'TamuController@delete');
		// Route::get('/tamu/sampah', 'TamuController@sampah');
		// Route::get('/tamu/kembalikan/{id}', 'TamuController@kembalikan');
		// Route::get('/tamu/kembalikan_semua', 'TamuController@kembalikan_semua');
		// Route::get('/tamu/hapus_permanen/{id}', 'TamuController@hapus_permanen');
		// Route::get('/tamu/hapus_permanen_semua', 'TamuController@hapus_permanen_semua');
		});
	
	Route::group(['prefix' => 'lpp','middleware'=> ['role:pelaksana ujian']], function(){
		//surat
		Route::get('/surat/{user_id}/{profil_id}/{lpp_id}', 'Aktor\Lpp\SuratController@index');
		Route::get('/surat/tambah/{user_id}/{profil_id}/{lpp_id}','Aktor\Lpp\SuratController@tambah');	
		Route::post('/surat/store/{user_id}/{profil_id}/{lpp_id}','Aktor\Lpp\SuratController@store');	
		Route::get('/surat/lihat/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\SuratController@lihat');
		Route::get('/surat/unduh/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\SuratController@unduh');
		Route::get('/surat/ubah/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\SuratController@ubah');
		Route::put('/surat/update/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\SuratController@update');
		Route::get('/surat/cari/{user_id}/{profil_id}/{lpp_id}', 'Aktor\Lpp\SuratController@cari');
		Route::get('/surat/hapus/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\SuratController@hapus');
		
		//kegiatan
		// Route::get('/kegiatan', 'Aktor\Lpp\KegiatanController@index');
		Route::get('/kegiatan/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\KegiatanController@index');
		Route::get('/kegiatan/tambah/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\KegiatanController@tambah');
		Route::post('/kegiatan/store/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\KegiatanController@store');
		Route::get('/kegiatan/cari/{user_id}/{profil_id}/{lpp_id}/{surat_id}', 'Aktor\Lpp\KegiatanController@cari');
		Route::get('/kegiatan/lihat/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}', 'Aktor\Lpp\KegiatanController@lihat');
		Route::get('/kegiatan/ubah/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}', 'Aktor\Lpp\KegiatanController@ubah');
		Route::put('/kegiatan/update/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}', 'Aktor\Lpp\KegiatanController@update');
		Route::get('/kegiatan/hapus/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}', 'Aktor\Lpp\KegiatanController@hapus');

		// venue
		Route::get('/venue/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{aksi}/{venue_id}/{kegiatan_id}', 'Aktor\Lpp\VenueController@index');
		Route::put('/venue/update/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{aksi}/{venue_id}/{kegiatan_id}', 'Aktor\Lpp\VenueController@update');

		// peserta
		Route::get('/peserta/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}', 'Aktor\Lpp\PesertaController@index');
		Route::get('/peserta/card/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}', 'Aktor\Lpp\PesertaController@card');
		Route::post('/peserta/tambah/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}', 'Aktor\Lpp\PesertaController@tambah');
		Route::get('/peserta/cari/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}/{view}', 'Aktor\Lpp\PesertaController@cari');
		Route::get('/peserta/ubah/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}/{peserta_id}', 'Aktor\Lpp\PesertaController@ubah');
		Route::put('/peserta/update/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}/{peserta_id}', 'Aktor\Lpp\PesertaController@update');
		Route::get('/peserta/batal/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}/{peserta_id}', 'Aktor\Lpp\PesertaController@batal');
		Route::get('/peserta/unduh/{user_id}/{profil_id}/{lpp_id}/{surat_id}/{kegiatan_id}/{peserta_id}', 'Aktor\Lpp\PesertaController@unduh');
	});

	Route::group(['prefix' => 'operator/jadwal','middleware'=> ['role:operator jadwal']], function(){
		//surat
		Route::get('/surat', 'Aktor\Operator\Jadwal\SuratController@index');
		Route::get('/surat/unduh/{id}', 'Aktor\Operator\Jadwal\SuratController@unduh');
		Route::get('/surat/ubah/{id}', 'Aktor\Operator\Jadwal\SuratController@ubah');
		Route::put('/surat/update/{id}', 'Aktor\Operator\Jadwal\SuratController@update');
		Route::get('/surat/cari', 'Aktor\Operator\Jadwal\SuratController@cari');
		
		//kegiatan
		Route::get('/kegiatan/{id}', 'Aktor\Operator\Jadwal\KegiatanController@index');
		Route::get('/kegiatan/lihat/{s_id}/{k_id}', 'Aktor\Operator\Jadwal\KegiatanController@lihat');
		Route::get('/kegiatan/ubah/{s_id}/{k_id}', 'Aktor\Operator\Jadwal\KegiatanController@ubah');
		Route::put('/kegiatan/update/{s_id}/{k_id}', 'Aktor\Operator\Jadwal\KegiatanController@update');
		Route::get('/kegiatan/cari/{id}', 'Aktor\Operator\Jadwal\KegiatanController@cari');
		
		//peserta
		Route::get('/kegiatan/peserta/{s_id}/{k_id}', 'Aktor\Operator\Jadwal\PesertaController@index');
		Route::get('/kegiatan/peserta/lihat/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Jadwal\PesertaController@lihat');
		Route::get('/kegiatan/peserta/ubah/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Jadwal\PesertaController@ubah');
		Route::put('/kegiatan/peserta/update/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Jadwal\PesertaController@update');
		Route::get('/kegiatan/peserta/unduh/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Jadwal\PesertaController@unduh');
		Route::get('/kegiatan/peserta/cari/{s_id}/{k_id}', 'Aktor\Operator\Jadwal\PesertaController@cari');
		//Route::get('/kegiatan/peserta/berkas/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Jadwal\KegiatanController@peserta_berkas');
	});

	Route::group(['prefix' => 'operator/monev','middleware'=> ['role:operator monev']], function(){
		//surat
		Route::get('/surat/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Monev\SuratController@index');
		Route::get('/surat/unduh/{user_id}/{profil_id}/{profesi_id}/{surat_id}', 'Aktor\Operator\Monev\SuratController@unduh');
		Route::put('/surat/status/{user_id}/{profil_id}/{profesi_id}/{surat_id}', 'Aktor\Operator\Monev\SuratController@status');
		Route::get('/surat/cari/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Monev\SuratController@cari');
		
		//kegiatan
		Route::get('/kegiatan/{id}', 'Aktor\Operator\Monev\KegiatanController@index');
		Route::get('/kegiatan/lihat/{s_id}/{k_id}', 'Aktor\Operator\Monev\KegiatanController@lihat');
		Route::get('/kegiatan/ubah/{s_id}/{k_id}', 'Aktor\Operator\Monev\KegiatanController@ubah');
		Route::put('/kegiatan/update/{s_id}/{k_id}', 'Aktor\Operator\Monev\KegiatanController@update');
		Route::get('/kegiatan/cari/{id}', 'Aktor\Operator\Monev\KegiatanController@cari');
		
		//peserta
		Route::get('/kegiatan/peserta/{s_id}/{k_id}', 'Aktor\Operator\Monev\PesertaController@index');
		Route::get('/kegiatan/peserta/lihat/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Monev\PesertaController@lihat');
		Route::get('/kegiatan/peserta/ubah/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Monev\PesertaController@ubah');
		Route::put('/kegiatan/peserta/update/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Monev\PesertaController@update');
		Route::get('/kegiatan/peserta/unduh/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Monev\PesertaController@unduh');
		Route::get('/kegiatan/peserta/cari/{s_id}/{k_id}', 'Aktor\Operator\Monev\PesertaController@cari');
		//Route::get('/kegiatan/peserta/berkas/{s_id}/{k_id}/{p_id}', 'Aktor\Operator\Monev\KegiatanController@peserta_berkas');
	});

	Route::group(['prefix' => 'operator/legal','middleware'=> ['role:operator legal']], function(){
		//sk
		Route::get('/sk/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Legal\SkController@index');
		Route::get('/sk/tambah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Legal\SkController@tambah');
		Route::post('/sk/store/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Legal\SkController@store');
		Route::get('/sk/unduh/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\SkController@unduh');
		Route::get('/sk/lihat/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\SkController@lihat');
		Route::get('/sk/ubah/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\SkController@ubah');
		Route::put('/sk/update/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\SkController@update');
		Route::get('/sk/cari/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Legal\SkController@cari');
		Route::get('/sk/hapus/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\SkController@hapus');
		Route::get('/sk/sampah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Legal\SkController@sampah');
		Route::get('/sk/kembalikan/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\SkController@kembalikan');
		Route::get('/sk/kembalikan_semua/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Legal\SkController@kembalikan_semua');
		Route::get('/sk/hapus_permanen/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\SkController@hapus_permanen');
		Route::get('/sk/hapus_permanen_semua/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Legal\SkController@hapus_permanen_semua');

		//penerima
		Route::get('/penerima/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\PenerimaController@index');
		Route::post('/penerima/tambah/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\PenerimaController@tambah');
		Route::get('/penerima/lihat/{user_id}/{profil_id}/{profesi_id}/{sk_id}/{penerima_id}', 'Aktor\Operator\Legal\PenerimaController@lihat');
		Route::get('/penerima/ubah/{user_id}/{profil_id}/{profesi_id}/{sk_id}/{penerima_id}', 'Aktor\Operator\Legal\PenerimaController@ubah');
		Route::put('/penerima/update/{user_id}/{profil_id}/{profesi_id}/{sk_id}/{penerima_id}', 'Aktor\Operator\Legal\PenerimaController@update');
		Route::get('/penerima/cari/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\PenerimaController@cari');
		Route::get('/penerima/hapus/{user_id}/{profil_id}/{profesi_id}/{sk_id}/{penerima_id}', 'Aktor\Operator\Legal\PenerimaController@hapus');
		Route::get('/penerima/sampah/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\PenerimaController@sampah');
		Route::get('/penerima/kembalikan/{user_id}/{profil_id}/{profesi_id}/{sk_id}/{penerima_id}', 'Aktor\Operator\Legal\PenerimaController@kembalikan');
		Route::get('/penerima/kembalikan_semua/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\PenerimaController@kembalikan_semua');
		Route::get('/penerima/hapus_permanen/{user_id}/{profil_id}/{profesi_id}/{sk_id}/{penerima_id}', 'Aktor\Operator\Legal\PenerimaController@hapus_permanen');
		Route::get('/penerima/hapus_permanen_semua/{user_id}/{profil_id}/{profesi_id}/{sk_id}', 'Aktor\Operator\Legal\PenerimaController@hapus_permanen_semua');
	});

	Route::group(['prefix' => 'operator/bmn','middleware'=> ['role:operator bmn']], function(){
		//asset
		Route::get('/aset', 'Aktor\Operator\Bmn\AsetController@index');
		Route::get('/aset/tambah', 'Aktor\Operator\Bmn\AsetController@tambah');
		Route::post('/aset/store', 'Aktor\Operator\Bmn\AsetController@store');
		Route::get('/aset/unduh/{id}', 'Aktor\Operator\Bmn\AsetController@unduh');
		Route::get('/aset/lihat/{id}', 'Aktor\Operator\Bmn\AsetController@lihat');
		Route::get('/aset/ubah/{id}', 'Aktor\Operator\Bmn\AsetController@ubah');
		Route::put('/aset/update/{id}', 'Aktor\Operator\Bmn\AsetController@update');
		Route::get('/aset/cari', 'Aktor\Operator\Bmn\AsetController@cari');
		Route::get('/aset/hapus/{id}', 'Aktor\Operator\Bmn\AsetController@hapus');
		Route::get('/aset/sampah', 'Aktor\Operator\Bmn\AsetController@sampah');
		Route::get('/aset/kembalikan/{id}', 'Aktor\Operator\Bmn\AsetController@kembalikan');
		Route::get('/aset/kembalikan_semua', 'Aktor\Operator\Bmn\AsetController@kembalikan_semua');
		Route::get('/aset/hapus_permanen/{id}', 'Aktor\Operator\Bmn\AsetController@hapus_permanen');
		Route::get('/aset/hapus_permanen_semua', 'Aktor\Operator\Bmn\AsetController@hapus_permanen_semua');
	});

	Route::group(['prefix' => 'operator/sarana','middleware'=> ['role:operator sarana']], function(){
		// klpd
		Route::get('/klpd/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\KlpdController@index');
		Route::get('/klpd/tambah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\KlpdController@tambah');
		Route::post('/klpd/store/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\KlpdController@store');
		Route::get('/klpd/lihat/{user_id}/{profil_id}/{profesi_id}/{klpd_id}', 'Aktor\Operator\Sarana\KlpdController@lihat');
		Route::get('/klpd/ubah/{user_id}/{profil_id}/{profesi_id}/{klpd_id}', 'Aktor\Operator\Sarana\KlpdController@ubah');
		Route::put('/klpd/update/{user_id}/{profil_id}/{profesi_id}/{klpd_id}', 'Aktor\Operator\Sarana\KlpdController@update');
		Route::get('/klpd/hapus/{user_id}/{profil_id}/{profesi_id}/{klpd_id}', 'Aktor\Operator\Sarana\KlpdController@hapus');
		Route::get('/klpd/sampah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\KlpdController@sampah');
		Route::get('/klpd/kembalikan/{user_id}/{profil_id}/{profesi_id}/{klpd_id}', 'Aktor\Operator\Sarana\KlpdController@kembalikan');
		Route::get('/klpd/kembalikan_semua/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\KlpdController@kembalikan_semua');
		Route::get('/klpd/hapus_permanen/{user_id}/{profil_id}/{profesi_id}/{klpd_id}', 'Aktor\Operator\Sarana\KlpdController@hapus_permanen');
		Route::get('/klpd/hapus_permanen_semua/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\KlpdController@hapus_permanen_semua');
		Route::get('/klpd/cari/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\KlpdController@cari');
		Route::get('/klpd/cari_sampah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\KlpdController@cari_sampah');

		// jenis
		Route::get('/jenis/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\JenisController@index');
		Route::get('/jenis/tambah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\JenisController@tambah');
		Route::post('/jenis/store/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\JenisController@store');
		Route::get('/jenis/lihat/{user_id}/{profil_id}/{profesi_id}/{jenis_id}', 'Aktor\Operator\Sarana\JenisController@lihat');
		Route::get('/jenis/ubah/{user_id}/{profil_id}/{profesi_id}/{jenis_id}', 'Aktor\Operator\Sarana\JenisController@ubah');
		Route::put('/jenis/update/{user_id}/{profil_id}/{profesi_id}/{jenis_id}', 'Aktor\Operator\Sarana\JenisController@update');
		Route::get('/jenis/hapus/{user_id}/{profil_id}/{profesi_id}/{jenis_id}', 'Aktor\Operator\Sarana\JenisController@hapus');
		Route::get('/jenis/sampah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\JenisController@sampah');
		Route::get('/jenis/kembalikan/{user_id}/{profil_id}/{profesi_id}/{jenis_id}', 'Aktor\Operator\Sarana\JenisController@kembalikan');
		Route::get('/jenis/kembalikan_semua', 'Aktor\Operator\Sarana\JenisController@kembalikan_semua');
		Route::get('/jenis/hapus_permanen/{user_id}/{profil_id}/{profesi_id}/{jenis_id}', 'Aktor\Operator\Sarana\JenisController@hapus_permanen');
		Route::get('/jenis/hapus_permanen_semua/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\JenisController@hapus_permanen_semua');
		Route::get('/jenis/cari/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\JenisController@cari');
		Route::get('/jenis/cari_sampah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\JenisController@cari_sampah');

		// unit_kerja
		Route::get('/unit_kerja', 'Aktor\Operator\Sarana\Unit_kerjaController@index');
		Route::get('/unit_kerja/tambah', 'Aktor\Operator\Sarana\Unit_kerjaController@tambah');
		Route::post('/unit_kerja/store', 'Aktor\Operator\Sarana\Unit_kerjaController@store');
		Route::get('/unit_kerja/lihat/{id}', 'Aktor\Operator\Sarana\Unit_kerjaController@lihat');
		Route::get('/unit_kerja/ubah/{id}', 'Aktor\Operator\Sarana\Unit_kerjaController@ubah');
		Route::put('/unit_kerja/update/{id}', 'Aktor\Operator\Sarana\Unit_kerjaController@update');
		Route::get('/unit_kerja/hapus/{id}', 'Aktor\Operator\Sarana\Unit_kerjaController@hapus');
		Route::get('/unit_kerja/sampah', 'Aktor\Operator\Sarana\Unit_kerjaController@sampah');
		Route::get('/unit_kerja/kembalikan/{id}', 'Aktor\Operator\Sarana\Unit_kerjaController@kembalikan');
		Route::get('/unit_kerja/kembalikan_semua', 'Aktor\Operator\Sarana\Unit_kerjaController@kembalikan_semua');
		Route::get('/unit_kerja/hapus_permanen/{id}', 'Aktor\Operator\Sarana\Unit_kerjaController@hapus_permanen');
		Route::get('/unit_kerja/hapus_permanen_semua', 'Aktor\Operator\Sarana\Unit_kerjaController@hapus_permanen_semua');
		Route::get('/unit_kerja/cari', 'Aktor\Operator\Sarana\Unit_kerjaController@cari');
		Route::get('/unit_kerja/cari_sampah', 'Aktor\Operator\Sarana\Unit_kerjaController@cari_sampah');

		// profesi
		Route::get('/profesi', 'Aktor\Operator\Sarana\ProfesiController@index');
		Route::get('/profesi/tambah', 'Aktor\Operator\Sarana\ProfesiController@tambah');
		Route::post('/profesi/store', 'Aktor\Operator\Sarana\ProfesiController@store');
		Route::get('/profesi/lihat/{id}', 'Aktor\Operator\Sarana\ProfesiController@lihat');
		Route::get('/profesi/ubah/{id}', 'Aktor\Operator\Sarana\ProfesiController@ubah');
		Route::put('/profesi/update/{id}', 'Aktor\Operator\Sarana\ProfesiController@update');
		Route::get('/profesi/hapus/{id}', 'Aktor\Operator\Sarana\ProfesiController@hapus');
		Route::get('/profesi/sampah', 'Aktor\Operator\Sarana\ProfesiController@sampah');
		Route::get('/profesi/kembalikan/{id}', 'Aktor\Operator\Sarana\ProfesiController@kembalikan');
		Route::get('/profesi/kembalikan_semua', 'Aktor\Operator\Sarana\ProfesiController@kembalikan_semua');
		Route::get('/profesi/hapus_permanen/{id}', 'Aktor\Operator\Sarana\ProfesiController@hapus_permanen');
		Route::get('/profesi/hapus_permanen_semua', 'Aktor\Operator\Sarana\ProfesiController@hapus_permanen_semua');
		Route::get('/profesi/cari', 'Aktor\Operator\Sarana\ProfesiController@cari');
		Route::get('/profesi/cari_sampah', 'Aktor\Operator\Sarana\ProfesiController@cari_sampah');

		// venue
		Route::get('/venue', 'Aktor\Operator\Sarana\VenueController@index');
		Route::get('/venue/tambah', 'Aktor\Operator\Sarana\VenueController@tambah');
		Route::post('/venue/store', 'Aktor\Operator\Sarana\VenueController@store');
		Route::get('/venue/lihat/{id}', 'Aktor\Operator\Sarana\VenueController@lihat');
		Route::get('/venue/ubah/{id}', 'Aktor\Operator\Sarana\VenueController@ubah');
		Route::put('/venue/update/{id}', 'Aktor\Operator\Sarana\VenueController@update');
		Route::get('/venue/hapus/{id}', 'Aktor\Operator\Sarana\VenueController@hapus');
		Route::get('/venue/sampah', 'Aktor\Operator\Sarana\VenueController@sampah');
		Route::get('/venue/kembalikan/{id}', 'Aktor\Operator\Sarana\VenueController@kembalikan');
		Route::get('/venue/kembalikan_semua', 'Aktor\Operator\Sarana\VenueController@kembalikan_semua');
		Route::get('/venue/hapus_permanen/{id}', 'Aktor\Operator\Sarana\VenueController@hapus_permanen');
		Route::get('/venue/hapus_permanen_semua', 'Aktor\Operator\Sarana\VenueController@hapus_permanen_semua');
		Route::get('/venue/cari', 'Aktor\Operator\Sarana\VenueController@cari');
		Route::get('/venue/cari_sampah', 'Aktor\Operator\Sarana\VenueController@cari_sampah');

		// lpp
		Route::get('/lpp/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\LppController@index');
		Route::get('/lpp/tambah/{user_id}/{profil_id}/{profesi_id}/{owner_id}', 'Aktor\Operator\Sarana\LppController@tambah');
		Route::post('/lpp/store/{user_id}/{profil_id}/{profesi_id}/{owner_id}', 'Aktor\Operator\Sarana\LppController@store');		
		Route::get('/lpp/lihat/{user_id}/{profil_id}/{profesi_id}/{lpp_id}', 'Aktor\Operator\Sarana\LppController@lihat');
		Route::get('/lpp/ubah/{user_id}/{profil_id}/{profesi_id}/{lpp_id}', 'Aktor\Operator\Sarana\LppController@ubah');
		Route::put('/lpp/update/{user_id}/{profil_id}/{profesi_id}/{lpp_id}', 'Aktor\Operator\Sarana\LppController@update');
		Route::get('/lpp/hapus/{user_id}/{profil_id}/{profesi_id}/{lpp_id}', 'Aktor\Operator\Sarana\LppController@hapus');
		Route::get('/lpp/riwayat/{user_id}/{profil_id}/{profesi_id}/{lpp_id}', 'Aktor\Operator\Sarana\LppController@riwayat');
		Route::get('/lpp/sampah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\LppController@sampah');
		Route::get('/lpp/kembalikan/{user_id}/{profil_id}/{profesi_id}/{lpp_id}', 'Aktor\Operator\Sarana\LppController@kembalikan');
		Route::get('/lpp/kembalikan_semua/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\LppController@kembalikan_semua');
		Route::get('/lpp/hapus_permanen/{user_id}/{profil_id}/{profesi_id}/{lpp_id}', 'Aktor\Operator\Sarana\LppController@hapus_permanen');
		Route::get('/lpp/hapus_permanen_semua/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sarana\LppController@hapus_permanen_semua');
		Route::get('/lpp/cari_owner/{user_id}/{profil_id}/{profesi_id}','Aktor\Operator\Sarana\LppController@cari_owner');
		Route::get('/lpp/telusur/{user_id}/{profil_id}/{profesi_id}','Aktor\Operator\Sarana\LppController@telusur');
		Route::get('/lpp/cari/{user_id}/{profil_id}/{profesi_id}','Aktor\Operator\Sarana\LppController@cari');
	});
		
	Route::group(['prefix' => 'operator/konsultasi','middleware'=> ['role:operator konsultasi']], function(){	
		//tiket
		Route::get('/tiket', 'Aktor\Operator\Konsultasi\TiketController@index');
		Route::get('/tiket/cari', 'Aktor\Operator\Konsultasi\TiketController@cari');
		Route::get('/tiket/hapus/{id}', 'Aktor\Operator\Konsultasi\TiketController@delete');
		Route::get('/tiket/sampah', 'Aktor\Operator\Konsultasi\TiketController@sampah');
		Route::get('/tiket/kembalikan/{id}', 'Aktor\Operator\Konsultasi\TiketController@kembalikan');
		Route::get('/tiket/kembalikan_semua', 'Aktor\Operator\Konsultasi\TiketController@kembalikan_semua');

		// subjek
		Route::get('/subjek', 'Aktor\Operator\Konsultasi\SubjekController@index');
		Route::get('/subjek/cari', 'Aktor\Operator\Konsultasi\SubjekController@cari');
		Route::get('/subjek/cari_sampah', 'Aktor\Operator\Konsultasi\SubjekController@cari_sampah');
		Route::get('/subjek/tambah', 'Aktor\Operator\Konsultasi\SubjekController@tambah');
		Route::post('/subjek/store', 'Aktor\Operator\Konsultasi\SubjekController@store');
		Route::get('/subjek/lihat/{id}', 'Aktor\Operator\Konsultasi\SubjekController@lihat');
		Route::get('/subjek/ubah/{id}', 'Aktor\Operator\Konsultasi\SubjekController@ubah');
		Route::put('/subjek/update/{id}', 'Aktor\Operator\Konsultasi\SubjekController@update');
		Route::get('/subjek/hapus/{id}', 'Aktor\Operator\Konsultasi\SubjekController@delete');
		Route::get('/subjek/sampah', 'Aktor\Operator\Konsultasi\SubjekController@sampah');
		Route::get('/subjek/kembalikan/{id}', 'Aktor\Operator\Konsultasi\SubjekController@kembalikan');
		Route::get('/subjek/kembalikan_semua', 'Aktor\Operator\Konsultasi\SubjekController@kembalikan_semua');
		Route::get('/subjek/hapus_permanen/{id}', 'Aktor\Operator\Konsultasi\SubjekController@hapus_permanen');
		Route::get('/subjek/hapus_permanen_semua', 'Aktor\Operator\Konsultasi\SubjekController@hapus_permanen_semua');
		
		// petugas
		Route::get('/petugas', 'Aktor\Operator\Konsultasi\PetugasController@index');
		Route::get('/petugas/tambah', 'Aktor\Operator\Konsultasi\PetugasController@tambah');
		Route::post('/petugas/store', 'Aktor\Operator\Konsultasi\PetugasController@store');
		Route::get('/petugas/ubah/{id}', 'Aktor\Operator\Konsultasi\PetugasController@ubah');
		Route::put('/petugas/update/{id}', 'Aktor\Operator\Konsultasi\PetugasController@update');
		Route::get('/petugas/hapus/{id}', 'Aktor\Operator\Konsultasi\PetugasController@delete');
		Route::get('/petugas/cari', 'Aktor\Operator\Konsultasi\PetugasController@cari');
		Route::get('/petugas/cari_sampah', 'Aktor\Operator\Konsultasi\PetugasController@cari_sampah');
		Route::get('/petugas/sampah', 'Aktor\Operator\Konsultasi\PetugasController@sampah');
		Route::get('/petugas/kembalikan/{id}', 'Aktor\Operator\Konsultasi\PetugasController@kembalikan');
		Route::get('/petugas/kembalikan_semua', 'Aktor\Operator\Konsultasi\PetugasController@kembalikan_semua');
		Route::get('/petugas/hapus_permanen/{id}', 'Aktor\Operator\Konsultasi\PetugasController@hapus_permanen');
		Route::get('/petugas/hapus_permanen_semua', 'Aktor\Operator\Konsultasi\PetugasController@hapus_permanen_semua');
		
		// statistik
		Route::get('/statistik', 'Aktor\Operator\Konsultasi\StatistikController@index');
		Route::get('/statistik/petugas', 'Aktor\Operator\Konsultasi\StatistikController@petugas');
		Route::get('/statistik/tamu', 'Aktor\Operator\Konsultasi\StatistikController@tamu');
		Route::get('/statistik/tamu_subjek', 'Aktor\Operator\Konsultasi\StatistikController@tamu_subjek');
		Route::get('/statistik/tiket', 'Aktor\Operator\Konsultasi\StatistikController@tiket');

		// tamu
		Route::get('/tamu', 'Aktor\Operator\Konsultasi\TamuController@index');
		Route::get('/tamu/ubah/{id}', 'Aktor\Operator\Konsultasi\TamuController@ubah');
		Route::put('/tamu/update/{id}', 'Aktor\Operator\Konsultasi\TamuController@update');
		Route::get('/tamu/hapus/{id}', 'Aktor\Operator\Konsultasi\TamuController@delete');
		Route::get('/tamu/riwayat/{id}', 'Aktor\Operator\Konsultasi\TamuController@riwayat');
		Route::get('/tamu/sampah', 'Aktor\Operator\Konsultasi\TamuController@sampah');
		Route::get('/tamu/kembalikan/{id}', 'Aktor\Operator\Konsultasi\TamuController@kembalikan');
		Route::get('/tamu/kembalikan_semua', 'Aktor\Operator\Konsultasi\TamuController@kembalikan_semua');
		Route::get('/tamu/hapus_permanen/{id}', 'Aktor\Operator\Konsultasi\TamuController@hapus_permanen');
		Route::get('/tamu/hapus_permanen_semua', 'Aktor\Operator\Konsultasi\TamuController@hapus_permanen_semua');
	});

	// operator sertifikat
	Route::group(['prefix' => 'operator/sertifikat','middleware'=> ['role:operator sertifikat']], function(){
		Route::get('/tingkat_dasar/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@index');
		Route::get('/tingkat_dasar/tambah/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@tambah');
		Route::post('/tingkat_dasar/store/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@store');
		Route::get('/tingkat_dasar/unduh/{user_id}/{profil_id}/{profesi_id}/{sertifikat_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@unduh');
		Route::get('/tingkat_dasar/lihat/{user_id}/{profil_id}/{profesi_id}/{sertifikat_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@lihat');
		Route::get('/tingkat_dasar/ubah/{user_id}/{profil_id}/{profesi_id}/{sertifikat_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@ubah');
		Route::put('/tingkat_dasar/update/{user_id}/{profil_id}/{profesi_id}/{sertifikat_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@update');
		Route::get('/tingkat_dasar/cari/{user_id}/{profil_id}/{profesi_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@cari');
		// Route::get('/tingkat_dasar/hapus/{user_id}/{profil_id}/{profesi_id}/{sertifikat_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@hapus');
		// Route::get('/tingkat_dasar/sampah', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@sampah');
		// Route::get('/tingkat_dasar/kembalikan/{user_id}/{profil_id}/{profesi_id}/{sertifikat_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@kembalikan');
		// Route::get('/tingkat_dasar/kembalikan_semua', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@kembalikan_semua');
		// Route::get('/tingkat_dasar/hapus_permanen/{user_id}/{profil_id}/{profesi_id}/{sertifikat_id}', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@hapus_permanen');
		// Route::get('/tingkat_dasar/hapus_permanen_semua', 'Aktor\Operator\Sertifikat\Tingkat_dasarController@hapus_permanen_semua');
	});

	/* Route::group(['middleware' => ['role:operator']], function () {
		Route::get('/sertifikat', 'SertifikatController@index');
		Route::get('/sertifikat/ubah/{id}', 'SertifikatController@ubah');
		Route::get('/sertifikat/unduh/{id}', 'SertifikatController@unduh');
		Route::put('/sertifikat/update/{id}', 'SertifikatController@update');
		Route::get('/sertifikat/cari', 'SertifikatController@cari');
	}); */

 Route::group(['middleware' => ['role:admin']], function () {
	Route::resource('/role', 'RoleController')->except([
			'create', 'show', 'edit', 'update'
		]);
	
	//Route::get('/home', 'Admin\HomeController@index')->name('home');

	// role
	Route::get('/role/tambah', 'RoleController@tambah');
	Route::post('/role/store', 'RoleController@store');
	Route::get('/role/cari', 'RoleController@cari')->name('role.cari');
	Route::get('/role/lihat/{id}', 'RoleController@lihat');
	Route::get('/role/ubah/{id}', 'RoleController@ubah')->name('role.ubah');
	Route::put('/role/update/{id}', 'RoleController@update');

	Route::resource('/users', 'UserController')->except([
			'show'
		]);

		// users
		Route::get('/users/cari', 'UserController@cari')->name('users.cari');
		Route::get('/users/roles/{id}', 'UserController@roles')->name('users.roles');
		Route::put('/users/roles/{id}', 'UserController@setRole')->name('users.set_role');
		Route::post('/users/permission', 'UserController@addPermission')->name('users.add_permission');
		Route::get('/users/role-permission', 'UserController@rolePermission')->name('users.roles_permission');
		Route::put('/users/permission/{role}', 'UserController@setRolePermission')->name('users.setRolePermission');

		// suspend
		Route::get('/admin/suspend', 'Admin\SuspendController@index');
		Route::get('/admin/suspend/kirim_ulang/{id}', 'Admin\SuspendController@ubah');
		Route::get('/admin/suspend/cari', 'Admin\SuspendController@cari');
		Route::get('/admin/suspend/hapus/{id}', 'Admin\SuspendController@hapus');

		//verifikasi ulang
		Route::post('/admin/suspend/kirim_ulang/{id}', 'Auth\VerificationController@resend_email');
		# ---
	});

});