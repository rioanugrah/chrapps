<?php

namespace App\Http\Controllers\Mikrotik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;

use Validator;

class FirewallController extends Controller
{
    public function firewall()
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
            (new Query('/ip/firewall/filter/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $response = $client->query($query)->read();

        return $response;
    }

    public function firewall_nat()
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
            (new Query('/ip/firewall/nat/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $response = $client->query($query)->read();

        return $response;
    }

    public function firewall_mangle()
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
            (new Query('/ip/firewall/mangle/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $response = $client->query($query)->read();

        return $response;
    }

    public function firewall_raw()
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
            (new Query('/ip/firewall/raw/print'));
                // ->where('mac-address', '00:00:00:00:40:29');

        // Send query and read response from RouterOS
        $response = $client->query($query)->read();

        return $response;
    }
}
