<?php

namespace App\Http\Controllers\Mikrotik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $resource = (new Query('/system/resource/print'));
            $secret = (new Query('/ppp/secret/print'));
            $secretactive = (new Query('/ppp/active/print'));

            $data['resource'] = $client->query($resource)->read();
            $data['secret'] = $client->query($secret)->read();
            $data['secretactive'] = $client->query($secretactive)->read();

            // return $data;
            return view('backend.dashboard.index',$data);
        } catch (\Exception $th) {
            //throw $th;
        }
    }

    public function cpu()
    {
        try {
            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $resource = (new Query('/system/resource/print'));

            $dataResource = $client->query($resource)->read();
            $data['cpu'] = $dataResource[0]['cpu-load'];
            // return $data;
            return view('backend.realtime.cpu',$data);
        } catch (\Exception $th) {
            //throw $th;
        }
    }

    public function uptime()
    {
        try {
            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $resource = (new Query('/system/resource/print'));

            $dataResource = $client->query($resource)->read();
            $data['uptime'] = $dataResource[0]['uptime'];
            // return $data;
            return view('backend.realtime.uptime',$data);
        } catch (\Exception $th) {
            //throw $th;
        }
    }
}
