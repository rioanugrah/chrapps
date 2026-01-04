<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \RouterOS\Client;
use \RouterOS\Query;

use DataTables;
use Validator;


class TestMikrotikController extends Controller
{

    // public function ppp_secret()
    // {
    //     $client = new Client([
    //         'host' => env('MIKROTIK_IP'),
    //         'user' => env('MIKROTIK_USERNAME'),
    //         'pass' => env('MIKROTIK_PASSWORD'),
    //         // 'port' => env('MIKROTIK_PORT'),
    //         'port' => intval(env('MIKROTIK_PORT')),
    //     ]);

    //     // Create "where" Query object for RouterOS
    //     $query =
    //         (new Query('/ppp/interface/print'));
    //             // ->where('mac-address', '00:00:00:00:40:29');

    //     // Send query and read response from RouterOS
    //     $response = $client->query($query)->read();

    //     return $response;
    // }

}
