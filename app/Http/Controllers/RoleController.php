<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Spatie\Permission\Models\Role;
use Auth;
use App\Models\Aktor\Operator\Sarana\Unit_kerja;

class RoleController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'role',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/role',
		'link_sampah'       => '',
		'view_utama' 		=> 'role/index',
		'view_form' 	 	=> 'role/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
    );
    
    public function index()
    {
        $this->data['role'] = Role::orderBy('created_at', 'DESC')->paginate(10);
        return view($this->data['view_utama'], $this->data);
    }

    public function tambah()
	{
        $this->data['aksi'] 		= "tambah";
        $this->data['form_action'] 	= "/role/store/";
        $this->data['pilih'] 		= Unit_kerja::all();
		
		return view($this->data['view_form'], $this->data);
    }

    public function store(Request $request)
    {
        $pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data sudah ada.',
        ];
        
        $this->validate($request, [
            'kode' 			=> 'nullable',
            'name'          => 'required|string|max:50|unique:roles',
            'unit_kerja_id' => 'required'
        ], $pesan);

        //$role = Role::firstOrCreate(['name' => $request->name]);
        //return redirect()->back()->with(['success' => 'Role: <strong>' . $role->name . '</strong> Ditambahkan']);

        Role::create([
    		'kode' 				=> strtolower($request->kode),
			'name' 				=> strtolower($request->name),
			'unit_kerja_id' 	=> $request->unit_kerja_id,
			'created_by' 		=> Auth::user()->profil->first()->id
    	]);
 
    	return redirect('/'.$this->data['judul'])->with(['success' => 'Role '.$request->name.' berhasil ditambahkan.']);;
    }

    public function lihat($id)
	{
		$this->data['aksi'] 		= "lihat";
		$this->data['role'] 		= Role::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
    }
    
    public function ubah($id)
	{
		$this->data['aksi'] 		= "ubah";
		$this->data['form_action'] 	= "/role/update/".$id;

		$this->data['pilih'] 		= Unit_kerja::all();
		$this->data['role'] 		= Role::find(Crypt::decrypt($id));
		
		return view($this->data['view_form'], $this->data);
	}

	public function update($id, Request $request)
	{
        $pesan = [
            'required'      => 'Wajib diisi.',
            'numeric'       => 'Wajib angka.',
			'digits'        => 'Jumlah karakter harus :digits.',
			'unique'        => 'Data sudah ada.',
		];

		$this->validate($request,[
			'kode' 				=> 'nullable',
			'name' 				=> 'required|string|max:50',
			'unit_kerja_id' 	=> 'required'
	    ], $pesan);

	    $isi 					= Role::find(Crypt::decrypt($id));

	    $isi->kode 				= strtolower($request->kode);
		$isi->name 				= strtolower($request->name);
		$isi->unit_kerja_id 	= $request->unit_kerja_id;
		$isi->updated_by 		= Auth::user()->profil->first()->id;

	    $isi->save();
	    return redirect($this->data['judul'])->with(['success' => 'Role berhasil diubah.']);
	}

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with(['success' => 'Role: <strong>' . $role->name . '</strong> Dihapus']);
    }

    public function cari(Request $request)
    {
        $cari = $request->cari;
        $this->data['aksi']     = "cari";
        $this->data['role']     = Role::where('name', 'like', '%'.$cari.'%')
                                    ->orWhere('guard_name', 'like', '%'.$cari.'%')
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(10);

        $this->data['role']->appends($request->only('cari'));                                

        return view($this->data['view_utama'], $this->data);
    }
}
