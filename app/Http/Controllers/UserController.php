<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use DB;

class UserController extends Controller
{
    public $data = array
	(
		'judul'         	=> 'users',
		'subjudul' 		 	=> '',
		'subsubjudul' 		=> '',
		'fungsi' 		 	=> '',
		'aksi'        		=> '',
		'link'         		=> '/users',
		'link_sampah'       => '',
		'view_utama' 		=> 'users/index',
		'view_form' 	 	=> 'users/form',
		'view_sampah' 	 	=> '',
		'form_action'   	=> '',
    );
    
    public function index()
    {
        // $users = User::orderBy('created_at', 'DESC')->paginate(10);
        // return view('users.index', compact('users'));
        
        $this->data['users'] = User::where('status', '=', '1')->orderBy('created_at', 'DESC')->paginate(10);
        return view($this->data['view_utama'], $this->data);
    }

    public function create()
    {
        $this->data['aksi']     = 'tambah';
        $this->data['role']     = Role::orderBy('name', 'ASC')->get();

        return view($this->data['view_form'], $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'role'      => 'required|string|exists:roles,name'
        ]);

        $user = User::firstOrCreate([
            'email'     => $request->email
        ], [
            'name'      => $request->name,
            'password'  => bcrypt($request->password),
            'status'    => true
        ]);

        $user->assignRole($request->role);
        return redirect(route('users.index'))->with(['success' => 'User: <strong>' . $user->name . '</strong> Ditambahkan']);
    }

    public function edit($id)
    {
        // $user = User::findOrFail($id);
        // return view('users.edit', compact('user'));

        $this->data['aksi']     = 'ubah';
        $this->data['users']    = User::findOrFail($id);
        $this->data['role']     = Role::orderBy('name', 'ASC')->get();

        return view($this->data['view_form'], $this->data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|exists:users,email',
            'password'  => 'nullable|min:6',
        ]);

        $user       = User::findOrFail($id);
        $password   = !empty($request->password) ? bcrypt($request->password):$user->password;
        $user->update([
            'name'      => $request->name,
            'password'  => $password
        ]);
        return redirect(route('users.index'))->with(['success' => 'User: <strong>' . $user->name . '</strong> Diperbaharui']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with(['success' => 'User: <strong>' . $user->name . '</strong> Dihapus']);
    }

    public function roles(Request $request, $id)
    {
        // $user   = User::findOrFail($id);
        // $roles  = Role::all()->pluck('name');
        // return view('users.roles', compact('user', 'roles'));

        $this->data['view_utama']   = 'users/roles';
        $this->data['subjudul']     = 'roles';
        $this->data['user']         = User::findOrFail($id);
        $this->data['roles']        = Role::all()->pluck('name');
        return view($this->data['view_utama'], $this->data);
    }

    public function setRole(Request $request, $id)
    {
        $this->validate($request, [
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->syncRoles($request->role);
        return redirect()->back()->with(['success' => 'Role Sudah Di Set']);
    }

    public function rolePermission(Request $request)
    {
        $role           = $request->get('role');
        $permissions    = null;
        $hasPermission  = null;

        $roles = Role::all()->pluck('name');

        if (!empty($role)) {
            $getRole        = Role::findByName($role);
            $hasPermission  = DB::table('role_has_permissions')
                ->select('permissions.name')
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_id', $getRole->id)->get()->pluck('name')->all();
            $permissions = Permission::all()->pluck('name');
        }
        return view('users.role_permission', compact('roles', 'permissions', 'hasPermission'));
    }

    public function addPermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:permissions'
        ]);

        $permission = Permission::firstOrCreate([
            'name' => $request->name
        ]);
        return redirect()->back();
    }

    public function setRolePermission(Request $request, $role)
    {
        $role = Role::findByName($role);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with(['success' => 'Permission to Role Saved!']);
    }

    public function cari(Request $request)
    {
        $cari = $request->cari;
        $this->data['aksi'] 	= "cari";
        $this->data['users']    = User::where('email', 'like', '%'.$cari.'%')
                                    ->orWhereHas('profil', function($q) use ($cari) {
                                        return $q->where('nama', 'LIKE', '%' . $cari . '%');
                                    })
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(10);
        $this->data['users']->appends($request->only('cari'));                                

        return view($this->data['view_utama'], $this->data);
    }
}
