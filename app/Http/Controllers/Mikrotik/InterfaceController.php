<?php

namespace App\Http\Controllers\Mikrotik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;

use Validator;

class InterfaceController extends Controller
{
    public function getInterfaces()
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
            (new Query('/interface/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $data['responses'] = $client->query($query)->read();

        // return $data;
        return view('backend.interfaces.index',$data);
    }
}
