<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Models\Services;
use App\Models\ServiceNatRules;
use App\Models\ServiceDomains;

use \RouterOS\Client;
use \RouterOS\Query;

use \Carbon\Carbon;

use Validator;

class ServiceController extends Controller
{
    function __construct(
        Services $services,
        ServiceNatRules $serviceNatRules,
        ServiceDomains $serviceDomains
    ){
        $this->services = $services;
        $this->serviceNatRules = $serviceNatRules;
        $this->serviceDomains = $serviceDomains;
    }

    public function index()
    {
        $data['services'] = $this->services->with('order_service')->whereHas('order_service',function($query){
                                                $query->where('user_id',auth()->user()->generate);
                                            })
                                            ->orderBy('created_at','asc')
                                            ->get();
        return view('users.services.index',$data);

    }

    public function detail($id)
    {
        $data['service'] = $this->services->with(['order_service','service_nat_rules','service_domains'])->find($id);
        return view('users.services.detail',$data);
    }

    public function serviceNatRuleSimpan(Request $request, $id)
    {
        $rules = [
            // 'port'  => 'required',
            // 'to_addresses'  => 'required',
            'to_port'  => 'required',
            'status'  => 'required',
        ];

        $messages = [
            // 'port.required'   => 'Port NAT wajib diisi.',
            // 'to_addresses.required'   => 'To Addresses wajib diisi.',
            'to_port.required'   => 'To Port Address wajib diisi.',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            $input = $request->all();
            $input['id'] = Str::uuid()->toString();
            $input['service_id'] = $id;

            $cekPortServiceNatRule = $this->serviceNatRules->select('port')->max('port');
            // dd($cekPortServiceNatRule);
            if (empty($cekPortServiceNatRule)) {
                $port = 1001;
            }else{
                $port = explode('|',$cekPortServiceNatRule)[0]+1;
            }

            $cekService = $this->services->select('username','ip_address')->find($id);
            $input['to_addresses'] = $cekService->ip_address;
            // dd($input);
            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $query = (new Query('/ip/firewall/nat/add'))
                    ->equal('comment',$cekService->username)
                    ->equal('chain','dstnat')
                    ->equal('action','dst-nat')
                    ->equal('to-addresses',$input['to_addresses'])
                    ->equal('to-ports',$request->to_port)
                    ->equal('protocol','tcp')
                    ->equal('dst-port',$port)
                    // ->equal('log','false')
                    // ->equal('log-prefix','')
                    // ->equal('invalid','false')
                    // ->equal('dynamic','false')
                    ->equal('disabled','false')
                    ;
            $response = $client->query($query)->read();

            // dd($response);

            $input['port'] = $port.'|'.$response['after']['ret'];

            $simpanServiceNatRule = $this->serviceNatRules->create($input);

            if ($simpanServiceNatRule) {
                $message_title="Berhasil !";
                $message_content= "Service NAT Rule ".$input['to_addresses']." Berhasil Dibuat";
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

    public function serviceNatRuleDetail($id, $idServiceNat)
    {
        $data = $this->serviceNatRules->where('id',$idServiceNat)
                                    ->where('service_id',$id)
                                    ->first();

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Service NAT Rule Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function serviceNatRuleUpdate(Request $request, $id)
    {
        $rules = [
            // 'port'  => 'required',
            // 'to_addresses'  => 'required',
            'to_port'  => 'required',
            'status'  => 'required',
        ];

        $messages = [
            // 'port.required'   => 'Port NAT wajib diisi.',
            // 'to_addresses.required'   => 'To Addresses wajib diisi.',
            'to_port.required'   => 'To Port Address wajib diisi.',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            $input = $request->all();

            $serviceNatRule = $this->serviceNatRules->where('id',$request->id)
                                                    ->where('service_id',$id)
                                                    ->first()
                                                    ;

            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $query = (new Query('/ip/firewall/nat/set'))
                    ->equal('.id',explode('|',$serviceNatRule->port)[1])
                    ->equal('to-ports',$request->to_port)
                    ->equal('disabled',$request->status == 'Active' ? 'false' : 'true')
                    ;
            $response = $client->query($query)->read();

            // dd($response);

            $serviceNatRule->update($input);

            if ($serviceNatRule) {
                $message_title="Berhasil !";
                $message_content= "Service NAT Rule ".$serviceNatRule->to_addresses." Berhasil Diupdate";
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

    public function serviceNatRuleDelete($id, $idServiceNat)
    {
        $serviceNatRule = $this->serviceNatRules->where('id',$idServiceNat)
                                    ->where('service_id',$id)
                                    ->first();

        if (empty($serviceNatRule)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Service NAT Rule Tidak Ditemukan'
            ]);
        }

        $client = new Client([
            'host' => env('MIKROTIK_IP'),
            'user' => env('MIKROTIK_USERNAME'),
            'pass' => env('MIKROTIK_PASSWORD'),
            // 'port' => env('MIKROTIK_PORT'),
            'port' => intval(env('MIKROTIK_PORT')),
        ]);

        $query = (new Query('/ip/firewall/nat/remove'))
                ->equal('.id',explode('|',$serviceNatRule->port)[1])
                ;

        $client->query($query)->read();

        $serviceNatRule->delete();

        $message_title="Berhasil !";
        $message_content= "Service NAT Rule ".$serviceNatRule->to_addresses." Berhasil Dihapus";
        $message_type="success";
        $message_succes = true;

        $array_message = array(
            'success' => $message_succes,
            'message_title' => $message_title,
            'message_content' => $message_content,
            'message_type' => $message_type,
        );

        return response()->json($array_message);
    }

    public function serviceDomainSimpan(Request $request, $id)
    {
        $rules = [
            'domain'  => 'required',
            'port'  => 'required',
            'status'  => 'required',
        ];

        $messages = [
            'domain.required'   => 'Domain wajib diisi.',
            'port.required'   => 'Port wajib diisi.',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            $input = $request->all();
            $input['id'] = Str::uuid()->toString();
            $input['service_id'] = $id;

            $input['port'] = $request->port == 80 ? 80 : 443;

            $cekService = $this->services->select('username','ip_address')->find($id);

            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $query = (new Query('/ip/dns/static/add'))
                    ->equal('comment',$cekService->username)
                    ->equal('name',$request->domain)
                    ->equal('address',$cekService->ip_address)
                    ->equal('disabled',$request->status == 'Active' ? 'false' : 'true')
                    ;

            $query2 = (new Query('/ip/proxy/access/add'))
                    ->equal('comment',$cekService->username)
                    ->equal('dst-port',$request->port)
                    ->equal('dst-host',$request->domain)
                    ->equal('disabled',$request->status == 'Active' ? 'false' : 'true')
                    ;

            $response1 = $client->query($query)->read();
            $response2 = $client->query($query2)->read();

            // dd($response);
            $input['port'] = $request->port.'|'.$response1['after']['ret'].'|'.$response2['after']['ret'];

            $simpanServiceNatDomain = $this->serviceDomains->create($input);

            if ($simpanServiceNatDomain) {
                $message_title="Berhasil !";
                $message_content= "Service Domain ".$input['domain']." Berhasil Dibuat";
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

    }

    public function serviceDomainDetail($id, $idServiceDomain)
    {
        $data = $this->serviceDomains->where('id',$idServiceDomain)
                                    ->where('service_id',$id)
                                    ->first();

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Service Domain Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function serviceDomainUpdate(Request $request, $id)
    {
        $rules = [
            'domain'  => 'required',
            'port'  => 'required',
            'status'  => 'required',
        ];

        $messages = [
            'domain.required'   => 'Domain wajib diisi.',
            'port.required'   => 'Port wajib diisi.',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            $input = $request->all();

            $serviceDomain = $this->serviceDomains->where('id',$request->id)
                                                    ->where('service_id',$id)
                                                    ->first()
                                                    ;

            $input['port'] = $request->port == 80 ? 80 : 443;

            $cekService = $this->services->select('username','ip_address')->find($id);

            // dd($serviceDomain);

            $client = new Client([
                'host' => env('MIKROTIK_IP'),
                'user' => env('MIKROTIK_USERNAME'),
                'pass' => env('MIKROTIK_PASSWORD'),
                // 'port' => env('MIKROTIK_PORT'),
                'port' => intval(env('MIKROTIK_PORT')),
            ]);

            $query = (new Query('/ip/dns/static/set'))
                    ->equal('.id',explode('|',$serviceDomain->port)[1])
                    ->equal('name',$request->domain)
                    ->equal('address',$cekService->ip_address)
                    ->equal('disabled',$request->status == 'Active' ? 'false' : 'true')
                    ;

            $query2 = (new Query('/ip/proxy/access/set'))
                    ->equal('.id',explode('|',$serviceDomain->port)[2])
                    ->equal('dst-port',$request->port)
                    ->equal('dst-host',$request->domain)
                    ->equal('disabled',$request->status == 'Active' ? 'false' : 'true')
                    ;

            $response1 = $client->query($query)->read();
            $response2 = $client->query($query2)->read();

            // dd($response2);
            $input['port'] = $request->port.'|'.explode('|',$serviceDomain->port)[1].'|'.explode('|',$serviceDomain->port)[2];

            $serviceDomain->update($input);

            if ($serviceDomain) {
                $message_title="Berhasil !";
                $message_content= "Service Domain ".$input['domain']." Berhasil Diupdate";
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

    public function serviceDomainDelete($id, $idServiceDomain)
    {
        $serviceDomain = $this->serviceDomains->where('id',$idServiceDomain)
                                    ->where('service_id',$id)
                                    ->first();

        if (empty($serviceDomain)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Service Domain Tidak Ditemukan'
            ]);
        }

        $client = new Client([
            'host' => env('MIKROTIK_IP'),
            'user' => env('MIKROTIK_USERNAME'),
            'pass' => env('MIKROTIK_PASSWORD'),
            // 'port' => env('MIKROTIK_PORT'),
            'port' => intval(env('MIKROTIK_PORT')),
        ]);

        $query1 = (new Query('/ip/dns/static/remove'))
                ->equal('.id',explode('|',$serviceDomain->port)[1])
                ;
        $query2 = (new Query('/ip/proxy/access/remove'))
                ->equal('.id',explode('|',$serviceDomain->port)[2])
                ;

        $client->query($query1)->read();
        $client->query($query2)->read();

        $serviceDomain->delete();

        $message_title="Berhasil !";
        $message_content= "Service Domain ".$serviceDomain->domain." Berhasil Dihapus";
        $message_type="success";
        $message_succes = true;

        $array_message = array(
            'success' => $message_succes,
            'message_title' => $message_title,
            'message_content' => $message_content,
            'message_type' => $message_type,
        );

        return response()->json($array_message);
    }
}
