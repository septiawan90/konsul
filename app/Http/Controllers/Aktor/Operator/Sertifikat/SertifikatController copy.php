<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use App\Sertifikat;

class SertifikatController extends Controller
{
    public function index()
    {
    	$isi = Sertifikat::orderBy('seri', 'ASC')->paginate(10);
		return view('sertifikat/index', ['sertifikat' => $isi]);
    }

    public function ubah($id)
	{
		$id 	= Crypt::decrypt($id);
		$isi 	= Sertifikat::find($id);
		
	   	return view('sertifikat/ubah', ['sertifikat' => $isi]);
	}

	public function update($id, Request $request)
	{
		$id 	= Crypt::decrypt($id);

		$pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data :unique sudah ada.',
		];
		
		$this->validate($request,[
		   	'seri' 			=> 'required|numeric',
			'file' 			=> 'required|file|mimes:pdf|max:2048',
	    ], $pesan);

		$file 				= $request->file('file');
		$nama_file 			= time()."_".$file->getClientOriginalName();
		
		// $tujuan_upload 		= 'file_sertifikat';
		
		#$file->move($path,$nama_file);

	    $isi 				= Sertifikat::find($id);		

	    $isi->seri 			= $request->seri;
    	$isi->file 			= Storage::putFile('public/file_sertifikat', $file); #$nama_file;

		$isi->save();
		
		return redirect('/sertifikat/');
	}

	public function unduh($id)
	{
		$id 	= Crypt::decrypt($id);
		
		
		$model_file = Sertifikat::findOrFail($id); //Mencari model atau objek yang dicari

		#$file = public_path() . '/storage/' . $model_file->file;//Mencari file dari model yang sudah dicari
		
		return Storage::download($model_file->file);

		#return response()->download($file, $model_file->file_name); //Download file yang dicari berdasarkan nama file
   }

   	public function cari(Request $request)
    {
        $cari 	= $request->cari;
        $isi    = Sertifikat::where('nomor','like',"%".$cari."%")
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('sertifikat/index', ['sertifikat' => $isi]);
    }
}