<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DataTables;
use Validator;

class PermissionController extends Controller
{
    function __construct(
        Permission $permissions
    ){
        $this->middleware('permission:permission-list', ['only' => ['index']]);
        $this->middleware('permission:permission-create', ['only' => ['store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit']]);
        $this->middleware('permission:permission-update', ['only' => ['update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);

        $this->permissions = $permissions;
    }

    public function index()
    {
        $data['permissions'] = $this->permissions->orderBy('created_at','desc')->get();
        return view('backend.permissions.index',$data);
    }

    public function create()
    {
        return view('backend.permissions.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required',
            'guard_name'  => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama wajib diisi.',
            'guard_name.required'  => 'Guard Name wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input = $request->all();
            $permissions = $this->permissions->create($input);
            $permissions->syncPermissions($request->input('permission'));

            if($permissions){
                // $message_title="Berhasil !";
                // $message_content="Permission Berhasil Ditambah";
                // $message_type="success";
                // $message_succes = true;
                return redirect()->route('admin.permission')->with('success','Permission Berhasil Dibuat');
            }

            // $array_message = array(
            //     'success' => $message_succes,
            //     'message_title' => $message_title,
            //     'message_content' => $message_content,
            //     'message_type' => $message_type,
            // );
            // return response()->json($array_message);
        }

        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );
        return redirect()->route('admin.permission')->with('error',$validator->errors());
    }

    public function edit($id)
    {
        $permission = $this->permissions->find($id);
        if (empty($permission)) {
            return redirect()->back()->with('error','Permission Tidak Ditemukan');
        }
        return view('backend.permissions.edit',compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name'  => 'required',
            'guard_name'  => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama wajib diisi.',
            'guard_name.required'  => 'Guard Name wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $permissions = $this->permissions->find($id);
            $input['name'] = $request->name;
            $input['guard_name'] = $request->guard_name;
            $permissions->update($input);
            $permissions->syncPermissions($request->input('permission'));

            if($permissions){
                // $message_title="Berhasil !";
                // $message_content="Permission Berhasil Diupdate";
                // $message_type="success";
                // $message_succes = true;
                return redirect()->route('admin.permission')->with('success','Permission Berhasil Diupdate');

            }

            // $array_message = array(
            //     'success' => $message_succes,
            //     'message_title' => $message_title,
            //     'message_content' => $message_content,
            //     'message_type' => $message_type,
            // );
            // return response()->json($array_message);
        }

        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );
        return redirect()->back()->with('errors',$validator->errors());
    }

    public function destroy($id)
    {
        $permission = $this->permissions->find($id);
        if (empty($permission)) {
            return redirect()->back()->with('error','Permission Tidak Ditemukan');
        }
        $permission->delete();
        return redirect()->route('admin.permission')->with('success','Permission Berhasil Dihapus');
    }
}
