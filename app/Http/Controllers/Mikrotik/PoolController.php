<?php

namespace App\Http\Controllers\Mikrotik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;

use Validator;

class PoolController extends Controller
{
    public function getPool()
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
            (new Query('/ip/pool/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $data['responses'] = $client->query($query)->read();

        // return $data;
        return view('backend.ip.pool.index',$data);
    }

    public function savePool(Request $request)
    {
        $rules = [
            'name'  => 'required',
            'ranges'  => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'name.required'  => 'Name Pool wajib diisi.',
            'ranges.required'  => 'Ranges wajib diisi.',
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

            $save = (new Query('/ip/pool/add'))
                    ->equal('name',$request->name)
                    ->equal('ranges',$request->ranges)
                    ;

            $response = $client->query($save)->read();

            // dd($response);

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

    public function detailPool($id)
    {
        dd($id);
        $client = new Client([
            'host' => env('MIKROTIK_IP'),
            'user' => env('MIKROTIK_USERNAME'),
            'pass' => env('MIKROTIK_PASSWORD'),
            // 'port' => env('MIKROTIK_PORT'),
            'port' => intval(env('MIKROTIK_PORT')),
        ]);

        // Create "where" Query object for RouterOS
        $query =
            (new Query('/ip/pool/print'))
                ->where('.id', $id);

        $data = $client->query($query)->read();

        // dd($data);

        return response()->json([
            'id' => $data[0]['.id'],
            'name' => $data[0]['name'],
            'ranges' => $data[0]['ranges'],
        ],200);

    }
    public function editPool($id)
    {
        // dd($id);
        $client = new Client([
            'host' => env('MIKROTIK_IP'),
            'user' => env('MIKROTIK_USERNAME'),
            'pass' => env('MIKROTIK_PASSWORD'),
            // 'port' => env('MIKROTIK_PORT'),
            'port' => intval(env('MIKROTIK_PORT')),
        ]);

        // Create "where" Query object for RouterOS
        $query =
            (new Query('/ip/pool/print'))
                ->where('.id', $id);

        $data['response'] = $client->query($query)->read();

        // dd($data);

        return view('backend.ip.pool.edit',$data);
    }
}
