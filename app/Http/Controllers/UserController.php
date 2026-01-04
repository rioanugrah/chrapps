<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Cache;

class UserController extends Controller
{
    function __construct(
        User $user,
        Role $role
    ){
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit']]);
        $this->middleware('permission:user-update', ['only' => ['update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->user = $user;
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $data['users'] = $this->user->orderBy('created_at','desc')->get();
        return view('backend.users.index',$data)->with('i', ($request->input('page', 1) - 1) * 5);;
    }

    public function create()
    {
        $data['roles'] = $this->role->pluck('name','name')->all();
        return view('backend.users.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['generate'] = Str::uuid()->toString();
        $input['username'] = strtolower(Str::of($request->name)->explode(' ')->get(0)) . mt_rand(11111, 99999);
        $input['password'] = Hash::make($request->password);

        // dd($input);

        $user = $this->user->create($input);

        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users')
                        ->with('success','User Berhasil Dibuat');
    }

    public function edit($generate)
    {
        $user = $this->user->where('generate',$generate)->first();
        if (empty($user)) {
            return redirect()->back()->with('error','User Tidak Ditemukan');
        }
        // dd($user->roles);
        $roles = $this->role->pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('backend.users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $generate)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ],[
            'name.required' => 'Nama User Wajib diisi',
            'email.required' => 'Email User Wajib diisi',
            'password.same' => 'Password User Harus Sama',
            'roles.required' => 'Roles User Wajib diisi',
        ]);

        // $input = $request->all();
        if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }

        $input['roles'] = $request->roles;

        $user = $this->user->where('generate',$generate)->first();
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$user->id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users')
                        ->with('success','User Berhasil Diupdate');
    }
}
