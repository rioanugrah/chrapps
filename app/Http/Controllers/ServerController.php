<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Servers;

use Validator;

class ServerController extends Controller
{
    function __construct(
        Servers $servers
    ){
        $this->servers = $servers;
    }

    public function index()
    {
        $data['servers'] = $this->servers->all();
        return view('backend.servers.index',$data);
    }

    public function simpan(Request $request)
    {
        $rules = [
            'domain'  => 'required',
            'ip_address'  => 'required',
            'gateway'  => 'required',
            'status'  => 'required',
        ];

        $messages = [
            'domain.required'   => 'Domain wajib diisi.',
            'ip_address.required'   => 'IP Address wajib diisi.',
            'gateway.required'   => 'Gateway wajib diisi.',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            $input = $request->all();
            $input['id'] = Str::uuid()->toString();
            $input['ip_public'] = gethostbyname($request->domain);

            $simpanServer = $this->servers->create($input);

            if ($simpanServer) {
                $message_title="Berhasil !";
                $message_content= "Server ".$request->domain." Berhasil Dibuat";
                $message_type="success";
                $message_succes = true;
            }

            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );

            return response()->json($array_message);

        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function detail($id)
    {
        $server = $this->servers->find($id);

        if (empty($server)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Server Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $server
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'domain'  => 'required',
            'ip_address'  => 'required',
            'gateway'  => 'required',
            'status'  => 'required',
        ];

        $messages = [
            'domain.required'   => 'Domain wajib diisi.',
            'ip_address.required'   => 'IP Address wajib diisi.',
            'gateway.required'   => 'Gateway wajib diisi.',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            $input = $request->all();
            $input['ip_public'] = gethostbyname($request->domain);

            $simpanServer = $this->servers->find($request->id)->update($input);

            if ($simpanServer) {
                $message_title="Berhasil !";
                $message_content= "Server ".$request->domain." Berhasil Diupdate";
                $message_type="success";
                $message_succes = true;
            }

            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );

            return response()->json($array_message);

        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }
}
