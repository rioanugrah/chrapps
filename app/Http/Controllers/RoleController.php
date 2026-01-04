<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    function __construct(
        Role $role,
        Permission $permission
    ){
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit']]);
        $this->middleware('permission:role-update', ['only' => ['update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);

        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $data['roles'] = $this->role->orderBy('created_at','desc')->get();
        return view('backend.roles.index',$data);
    }

    public function create()
    {
        DB::statement("SET SQL_MODE=''");
        $role_permission = $this->permission->select('name','id')->groupBy('name')->get();
        $data['custom_permission'] = array();
        foreach($role_permission as $per){
            $key = substr($per->name, 0, strpos($per->name, "-"));
            if(str_starts_with($per->name, $key)){
                $data['custom_permission'][$key][] = $per;
            }
        }
        return view('backend.roles.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = $this->role->create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.roles')
                        ->with('success','Role created successfully');
    }

    public function detail($id)
    {
        $data['role'] = $this->role->find($id);
        DB::statement("SET SQL_MODE=''");
        $role_permission = $this->permission->select('name','id')->groupBy('name')->get();
        $data['custom_permission'] = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, "-"));
            if(str_starts_with($per->name, $key)){
                $data['custom_permission'][$key][] = $per;
            }

        }

        return view('backend.roles.view',$data);
    }

    public function edit($id)
    {
        $data['role'] = $this->role->find($id);
        DB::statement("SET SQL_MODE=''");
        $role_permission = $this->permission->select('name','id')->groupBy('name')->get();
        $data['custom_permission'] = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, "-"));
            if(str_starts_with($per->name, $key)){
                $data['custom_permission'][$key][] = $per;
            }

        }

        return view('backend.roles.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = $this->role->find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.roles')
                        ->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        // DB::table("roles")->where('id',$id)->delete();
        $role = $this->role->find($id);
        if (empty($role)) {
            return redirect()->back()->with('error','Role tidak ditemukan');
        }
        $role->delete();
        return redirect()->route('admin.roles')
                        ->with('success','Role deleted successfully');
    }
}
