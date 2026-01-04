<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Payment\TripayController;

use App\Models\Products;
use App\Models\Payment;
use App\Models\Orders;
use App\Models\Services;
use App\Models\Servers;

use \RouterOS\Client;
use \RouterOS\Query;

use Validator;
use \Carbon\Carbon;

class OrderController extends Controller
{
    function __construct(
        TripayController $tripayPayment,
        Orders $orders,
        Services $services,
        Servers $servers,
        Payment $payment,
        Products $products
    ){
        $this->tripay_payment = $tripayPayment;
        $this->orders = $orders;
        $this->services = $services;
        $this->servers = $servers;
        $this->products = $products;
        $this->payment = $payment;
    }

    public function index()
    {
        $data['orders'] = $this->orders->where('user_id',auth()->user()->generate)->get();
        $data['listPayments'] = json_decode($this->tripay_payment->getPayment())->data;

        $data['payment'] = $this->tripay_payment;
        return view('users.orders.index',$data);
    }

    public function create()
    {
        $data['products'] = $this->products->where('status','Active')->latest()->get();
        return view('users.orders.buat',$data);
    }

    public function checkout($id)
    {
        $data['product'] = $this->products->find($id);

        if (empty($data['product'])) {
            return redirect()->back();
        }

        $data['listPayments'] = json_decode($this->tripay_payment->getPayment())->data;

        return view('users.orders.checkout',$data);
    }

    public function buy_now(Request $request, $id)
    {
        $rules = [
            'first_name'  => 'required',
            'last_name'  => 'required',
            'email'  => 'required',
            'no_telp'  => 'required',
        ];

        $messages = [
            'first_name.required'   => 'First Name wajib diisi.',
            'last_name.required'   => 'Last Name wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'no_telp.required'   => 'No. Telp wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            try {
                $inputPayment['id'] = Str::uuid()->toString();
                $inputPayment['payment_method'] = explode('|',$request->method)[0];
                $product = $this->products->find($id);

                $input['id'] = Str::uuid()->toString();
                $input['user_id'] = auth()->user()->generate;
                $input['product_id'] = $id;
                $input['payment_id'] = $inputPayment['id'];
                $input['service_id'] = Str::uuid()->toString();
                $input['order_code'] = 'ODR-'.Carbon::now()->format('Ymd').rand(1000,9999);

                $input['order_name'] = $product->product_name;
                $input['order_price'] = $product->product_price;

                $simpanOrder = $this->orders->create($input);

                if ($simpanOrder) {

                    $input_service['id'] = $input['service_id'];
                    $input_service['server_id'] = $product->server_id;
                    $input_service['username'] = Carbon::now()->format('YmdHi').rand(100,999);

                    $input_service['password'] = substr(md5(uniqid()), 0, 15);
                    $input_service['expired_date'] = Carbon::now()->addDay($product->product_duration)->format('Y-m-d');

                    $explode_ip_address = explode('.',$product->server->gateway);
                    if ($explode_ip_address[3] <= 254) {
                        $cek_ip_address = $this->services->select('ip_address')->orderBy('created_at','desc')->max('ip_address');
                        if (empty($cek_ip_address)) {
                            $input_service['ip_address'] = $explode_ip_address[0].'.'.$explode_ip_address[1].'.'.$explode_ip_address[2].'.'.$explode_ip_address[3]+1;
                        }else{
                            $input_service['ip_address'] = $explode_ip_address[0].'.'.$explode_ip_address[1].'.'.$explode_ip_address[2].'.'.explode('.',$cek_ip_address)[3]+1;
                        }
                    }

                    $input_service['l2tp_config'] = '/interface l2tp-client add name='.$input_service['username'].' user='.$input_service['username'].' password='.$input_service['password'].' connect-to='.$product->server->domain.' disabled=no';
                    $input_service['sstp_config'] = '/interface sstp-client add name='.$input_service['username'].' user='.$input_service['username'].' password='.$input_service['password'].' connect-to='.$product->server->domain.' disabled=no';

                    $client = new Client([
                        'host' => env('MIKROTIK_IP'),
                        'user' => env('MIKROTIK_USERNAME'),
                        'pass' => env('MIKROTIK_PASSWORD'),
                        // 'port' => env('MIKROTIK_PORT'),
                        'port' => intval(env('MIKROTIK_PORT')),
                    ]);

                    $ppp_profil = (new Query('/ppp/profile/add'))
                                    ->equal('name',$input_service['username'])
                                    ->equal('local-address',$product->server->gateway)
                                    ->equal('remote-address',$input_service['ip_address'])
                                    ->equal('rate-limit',$product->rate_download.'/'.$product->rate_upload)
                                    ;

                    $ppp_secret = (new Query('/ppp/secret/add'))
                                    ->equal('name',$input_service['username'])
                                    ->equal('password',$input_service['password'])
                                    ->equal('service','l2tp')
                                    ->equal('profile',$input_service['username'])
                                    ->equal('disabled','true')
                                    ;

                    $client->query($ppp_profil)->read();
                    $id_ppp_secret = $client->query($ppp_secret)->read();

                    $input_service['service_code'] = rand(10000,99999).'|'.$id_ppp_secret['after']['ret'];

                    $kode_jenis_transaksi = 'MCR';
                    $kode_random_transaksi = $kode_jenis_transaksi.'-'.Carbon::now()->format('Ym').rand(100,999);

                    $inputPayment['payment_billing'] = json_encode([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->no_telp,
                    ]);

                    $paymentDetail = $this->tripay_payment->requestTransaction(
                        $input['order_name'],
                        $inputPayment['payment_method'],
                        $input['order_price'],
                        $request->first_name,
                        $request->last_name,
                        $request->email,
                        $request->no_telp,
                        $kode_random_transaksi,
                        // $url_return
                        route('user.order')
                        // route('b.ticket_bromo.invoice',['transaction_code' => $input['transaction_code']])
                    );

                    $inputPayment['payment_references'] = json_decode($paymentDetail)->data->reference;
                    $inputPayment['fee_admin'] = json_decode($paymentDetail)->data->total_fee;
                    $inputPayment['amount'] = explode('|',$request->method)[1];

                    $data['payment'] = $this->payment->create($inputPayment);

                    $this->services->create($input_service);

                    $message_title="Berhasil !";
                    $message_content= "Order ".$input['order_name']." Berhasil Dibuat, Anda akan diarahkan ke halaman pembayaran.";
                    $message_type="success";
                    $message_succes = true;
                }

                $array_message = array(
                    'success' => $message_succes,
                    'message_title' => $message_title,
                    'message_content' => $message_content,
                    'message_type' => $message_type,
                    'link_payment' => json_decode($this->tripay_payment->detailTransaction($inputPayment['payment_references']))->data->checkout_url
                );

                return response()->json($array_message);
            } catch (\Exception $th) {
                return $th;
            }
        }
    }

    public function detail($id)
    {
        $order = $this->orders->with('product')->find($id);

        if (empty($order)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Order Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function perpanjangan_simpan(Request $request)
    {
        $rules = [
            'first_name'  => 'required',
            'last_name'  => 'required',
            'email'  => 'required',
            'no_telp'  => 'required',
        ];

        $messages = [
            'first_name.required'   => 'First Name wajib diisi.',
            'last_name.required'   => 'Last Name wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'no_telp.required'   => 'No. Telp wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()){
            // $input = $request->all();
            // \DB::beginTransaction();

            try {
                $inputPayment['id'] = Str::uuid()->toString();
                $inputPayment['payment_method'] = explode('|',$request->method)[0];

                $order = $this->orders->find($request->id);

                $input['product_id'] = $order->product->id;
                $input['payment_id'] = $inputPayment['id'];
                $input['service_id'] = $order->service_id;
                $input['order_code'] = 'ODR-'.Carbon::now()->format('Ymd').rand(1000,9999);
                $input['order_name'] = $order->order_name;
                $input['order_price'] = $order->order_price;
                $input['status'] = 'Pending';

                $order->update($input);

                if ($order) {
                    $input_service['server_id'] = $order->service->server_id;
                    $input_service['username'] = $order->service->username;
                    $input_service['password'] = $order->service->password;
                    $input_service['expired_date'] = Carbon::create($order->service->expired_date)->addDay($order->product->product_duration);

                    $kode_jenis_transaksi = 'MCR';
                    $kode_random_transaksi = $kode_jenis_transaksi.'-'.Carbon::now()->format('Ym').rand(100,999);

                    $inputPayment['payment_billing'] = json_encode([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->no_telp,
                    ]);

                    $paymentDetail = $this->tripay_payment->requestTransaction(
                        $input['order_name'],
                        $inputPayment['payment_method'],
                        $input['order_price'],
                        $request->first_name,
                        $request->last_name,
                        $request->email,
                        $request->no_telp,
                        $kode_random_transaksi,
                        route('user.order.index')
                    );

                    $inputPayment['payment_references'] = json_decode($paymentDetail)->data->reference;
                    $inputPayment['fee_admin'] = json_decode($paymentDetail)->data->total_fee;
                    $inputPayment['amount'] = $input['order_price'];

                    $this->payment->create($inputPayment);

                    $this->services->find($order->service->id)->update($input_service);

                    $message_title="Berhasil !";
                    $message_content= "Perpanjangan ".$input['order_name']." Berhasil Dibuat, Anda akan diarahkan ke halaman pembayaran.";
                    $message_type="success";
                    $message_succes = true;
                }

                $array_message = array(
                    'success' => $message_succes,
                    'message_title' => $message_title,
                    'message_content' => $message_content,
                    'message_type' => $message_type,
                    'link_payment' => json_decode($this->tripay_payment->detailTransaction($inputPayment['payment_references']))->data->checkout_url
                );

                return response()->json($array_message);
                // DB::commit();
            } catch (\Exception $th) {
                return $th;
            }

        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
    }

    public function invoice($id)
    {
        $data['order'] = $this->orders->find($id);

        if (empty($data['order'])) {
            return redirect()->back();
        }

        return view('users.orders.invoice',$data);
    }
}
