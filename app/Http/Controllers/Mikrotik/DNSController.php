<?php

namespace App\Http\Controllers\Mikrotik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;

use Validator;

class DNSController extends Controller
{
    public function getDNS()
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
            (new Query('/ip/dns/print'));

        $data['response'] = $client->query($query)->read();
        // return $data;
        return view('backend.dns.index',$data);
    }

    public function getDNSStatic()
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
            (new Query('/ip/dns/static/print'));

        $data['responses'] = $client->query($query)->read();
        // return $data;
        return view('backend.dns.static.index',$data);
    }
}
