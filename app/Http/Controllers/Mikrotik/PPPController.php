<?php

namespace App\Http\Controllers\Mikrotik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;

use Validator;

class PPPController extends Controller
{
    public function ppp_secret()
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
            (new Query('/ppp/secret/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $data['responses'] = $client->query($query)->read();

        // return $data;
        return view('backend.ppp.secret.index',$data);
    }

    public function ppp_profile()
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
            (new Query('/ppp/profile/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $data['responses'] = $client->query($query)->read();

        // return $data;
        return view('backend.ppp.profile.index',$data);
    }

    public function ppp_active_connection()
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
            (new Query('/ppp/active/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $data['responses'] = $client->query($query)->read();

        // return $data;
        return view('backend.ppp.active_connection.index',$data);
    }
}
