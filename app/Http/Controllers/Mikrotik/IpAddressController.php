<?php

namespace App\Http\Controllers\Mikrotik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;

use Validator;

class IpAddressController extends Controller
{
    public function getIpAddresses(Request $request)
    {
        $client = new Client([
            'host' => env('MIKROTIK_IP'),
            'user' => env('MIKROTIK_USERNAME'),
            'pass' => env('MIKROTIK_PASSWORD'),
            // 'port' => env('MIKROTIK_PORT'),
            'port' => intval(env('MIKROTIK_PORT')),
        ]);

        // Create "where" Query object for RouterOS
        $query =
            (new Query('/ip/address/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        $getInterfaces = new Query('/interface/print');
        // Send query and read response from RouterOS
        $data['getInterfaces'] = $client->query($getInterfaces)->read();
        $data['responses'] = $client->query($query)->read();

        // return $data;
        return view('backend.address.index',$data);
    }

    public function saveIpAddresses(Request $request)
    {
        $rules = [
            'disabled'  => 'required',
            'address'  => 'required',
            'network'  => 'required',
            'interface'  => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'disabled.required'  => 'Enable wajib diisi.',
            'address.required'  => 'Address wajib diisi.',
            'network.required'  => 'Network wajib diisi.',
            'interface.required'  => 'Interface wajib diisi.',
        ]; // Ini buat nampilkan pesan ketika error

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $save = (new Query('/ip/address/add'))
                    ->equal('disabled',$request->disabled)
                    ->equal('address',$request->address)
                    ->equal('network',$request->network)
                    ->equal('interface',$request->interface)
                    ;

            $response = $client->query($save)->read();

            if ($response) {
                $message_title="Berhasil !";
                $message_content= "Berhasil Disimpan, Silahkan Refresh!";
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

    public function detailIpAddresses($id)
    {
        $client = new Client([
            'host' => env('MIKROTIK_IP'),
            'user' => env('MIKROTIK_USERNAME'),
            'pass' => env('MIKROTIK_PASSWORD'),
            // 'port' => env('MIKROTIK_PORT'),
            'port' => intval(env('MIKROTIK_PORT')),
        ]);

        // Create "where" Query object for RouterOS
        $query =
            (new Query('/ip/address/print'))
                ->where('.id', $id);

        $data = $client->query($query)->read();

        return response()->json([
            'id' => $data['.id'],
        ],200);
    }

    public function editIpAddresses($id)
    {
        $client = new Client([
            'host' => env('MIKROTIK_IP'),
            'user' => env('MIKROTIK_USERNAME'),
            'pass' => env('MIKROTIK_PASSWORD'),
            // 'port' => env('MIKROTIK_PORT'),
            'port' => intval(env('MIKROTIK_PORT')),
        ]);

        // Create "where" Query object for RouterOS
        $query =
            (new Query('/ip/address/print'))
                ->where('.id', $id);

        $getInterfaces = new Query('/interface/print');

        $data['getInterfaces'] = $client->query($getInterfaces)->read();
        $data['response'] = $client->query($query)->read();

        // return $data;
        return view('backend.address.edit',$data);
    }

    public function updateIpAddresses(Request $request, $id)
    {
        $rules = [
            'disabled'  => 'required',
            'address'  => 'required',
            'network'  => 'required',
            'interface'  => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'disabled.required'  => 'Enable wajib diisi.',
            'address.required'  => 'Address wajib diisi.',
            'network.required'  => 'Network wajib diisi.',
            'interface.required'  => 'Interface wajib diisi.',
        ]; // Ini buat nampilkan pesan ketika error

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $update = (new Query('/ip/address/set'))
                    ->equal('.id', $id)
                    ->equal('disabled',$request->disabled)
                    ->equal('address',$request->address)
                    ->equal('network',$request->network)
                    ->equal('interface',$request->interface)
                    ;

            $response = $client->query($update)->read();

            // return $response;
            // $getInterfaces = new Query('/interface/print');
            // $data['getInterfaces'] = $client->query($getInterfaces)->read();

            return redirect()->route('getIpAddresses')->with('success','Berhasil Update!');
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function deleteIpAddresses($id)
    {
        $client = new Client([
            'host' => env('MIKROTIK_IP'),
            'user' => env('MIKROTIK_USERNAME'),
            'pass' => env('MIKROTIK_PASSWORD'),
            // 'port' => env('MIKROTIK_PORT'),
            'port' => intval(env('MIKROTIK_PORT')),
        ]);

        // Create "where" Query object for RouterOS
        $query =
            (new Query('/ip/address/remove'))
                ->where('.id', $id);
        // $query =
        //     (new Query('/ip/address/remove', array(
        //         ".id" => "$id"
        //     )));

        $data = $client->query($query)->read();

        // dd($data);

        return response()->json([
            'success' => true,
            'message_type' => 'success',
            'message_title' => 'Berhasil',
            'message_content' => 'IP Address Berhasil Dihapus'
        ]);
    }
}
