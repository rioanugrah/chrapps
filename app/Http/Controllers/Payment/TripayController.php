<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Models\Payment;

use \RouterOS\Client;
use \RouterOS\Query;

// use Telegram\Bot\Laravel\Facades\Telegram;
// use Telegram\Bot\FileUpload\InputFile;

use \Carbon\Carbon;

class TripayController extends Controller
{
    function __construct(
        Payment $payment
    ){
        if (env('TRIPAY_IS_PRODUCTION') == false) {
            $this->tripay_api_key = env('TRIPAY_API_KEY_SANDBOX');
            $this->tripay_private_key = env('TRIPAY_PRIVATE_KEY_SANDBOX');
            $this->tripay_merchant = env('TRIPAY_MERCHANT_SANDBOX');
            $this->tripay_url = env('TRIPAY_SANDBOX');
        }else{
            $this->tripay_api_key = env('TRIPAY_API_KEY_PRODUCTION');
            $this->tripay_private_key = env('TRIPAY_PRIVATE_KEY_PRODUCTION');
            $this->tripay_merchant = env('TRIPAY_MERCHANT_PRODUCTION');
            $this->tripay_url = env('TRIPAY_PRODUCTION');
        }

        $this->payment = $payment;
    }

    public function getPayment()
    {
        $apiKey = $this->tripay_api_key;
        $url_tripay = $this->tripay_url;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => $url_tripay.'/merchant/payment-channel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ));

        $response = curl_exec($curl);
        // dd($response);
        $error = curl_error($curl);

        curl_close($curl);

        // echo empty($error) ? $response : $error;
        return $response ? $response : $error;
        // return 'test';
    }

    public function requestTransaction(
        $product,
        $method,$amount,
        $first_name,$last_name,$email,$phone,
        $merchantRef,$url
    )
    {
        $apiKey       = $this->tripay_api_key;
        $privateKey   = $this->tripay_private_key;
        $merchantCode = $this->tripay_merchant;
        $merchantRef  = $merchantRef;
        $amount       = $amount;
        $url_tripay   = $this->tripay_url;
        $return_url   = $url;

        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $first_name.' '.$last_name,
            'customer_email' => $email,
            'customer_phone' => $phone,
            'order_items'    => [
                [
                    'name'        => $product,
                    'price'       => $amount,
                    'quantity'    => 1,
                    // 'product_url' => 'https://tokokamu.com/product/nama-produk-1',
                    // 'image_url'   => 'https://tokokamu.com/product/nama-produk-1.jpg',
                    ]
                ],
                // 'return_url'   => 'https://domainanda.com/redirect',
                'callback_url'   => env('APP_URL').'/api/callback',
                'return_url'   => $return_url,
                'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
                'signature'    => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
            ];

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_FRESH_CONNECT  => true,
                CURLOPT_URL            => $url_tripay.'/transaction/create',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => false,
                CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
                CURLOPT_FAILONERROR    => false,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => http_build_query($data),
                CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
            ]);

            $response = curl_exec($curl);
            $error = curl_error($curl);

            curl_close($curl);
            // dd(json_decode($response)->data);
            // echo empty($error) ? $response : $error;
            return $response ? $response : $error;
    }

    public function handle(Request $request)
    {
        // dd($request->all());
        $privateKey = $this->tripay_private_key;
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        // dd($callbackSignature);
        // return $callbackSignature;
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $privateKey);
        if ($signature !== (string) $callbackSignature) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid signature',
            ]);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }

        $invoiceId = $data->merchant_ref;
        $tripayReference = $data->reference;
        // return $tripayReference;
        $status = strtoupper((string) $data->status);

        if ($data->is_closed_payment === 1) {
            $datas['payment'] = $this->payment->where('payment_references',$tripayReference)
                                            // ->where('status','Unpaid')
                                            ->first();
                                            // return $datas;
            if (!$datas['payment']) {
                return Response::json([
                    'success' => false,
                    'message' => 'No invoice found or already paid: ' . $invoiceId,
                ]);
            }
            switch ($status) {
                case 'PAID':
                    // $notifMail = $this->sendMail;
                    // $notifMail->sendMail(
                    //     $transaction->status,$transaction->transaction_code,$transaction->transaction_price,
                    //     json_decode($transaction->transaction_order)->first_name.' '.json_decode($transaction->transaction_order)->last_name,
                    //     json_decode($transaction->transaction_order)->email,json_decode($transaction->transaction_order)->phone,json_decode($transaction->transaction_order)->address,
                    //     $transaction->transaction_qty,$transaction->transaction_reference,$transaction->verifikasi_tiket->kode_tiket
                    // );

                    // \Mail::to(json_decode($datas['transaction']->payment_billing)->email)
                    //         ->cc('rioanugrah999@gmail.com')
                    //         ->send(new \App\Mail\Payment($datas['transaction']));
                    try {
                        // Telegram::sendMessage([
                        //     'chat_id' => env('TELEGRAM_CHAT_ID'),
                        //     'text' => 'Booking Code : '.$datas['transaction']['booking']['booking_code']."\n".
                        //             'Booking Name : '.$datas['transaction']['booking']['booking_name']."\n".
                        //             'Billing Name : '.json_decode($datas['transaction']['payment_billing'])->first_name.' '.json_decode($datas['transaction']['payment_billing'])->last_name."\n".
                        //             'Billing Email : '.json_decode($datas['transaction']['payment_billing'])->email."\n".
                        //             'Billing Phone : '.json_decode($datas['transaction']['payment_billing'])->phone."\n".
                        //             'Total : Rp. '.number_format($datas['transaction']['amount'],2,',','.')."\n".
                        //             'Status : '.$datas['transaction']['status']."\n".
                        //             'Tanggal Pembayaran : '.$datas['transaction']['payment_date']
                        // ]);
                        $datas['payment']->update([
                            'payment_date' => Carbon::now(),
                            'status' => 'Paid'
                        ]);

                        $datas['payment']['order']->update([
                            'status' => 'Paid'
                        ]);

                        $datas['payment']['order']['service']->update([
                            'status' => 'Active'
                        ]);

                        // return explode('|',$datas['payment']['order']['service']['service_code'])[1];

                        $client = new Client([
                            'host' => env('MIKROTIK_IP'),
                            'user' => env('MIKROTIK_USERNAME'),
                            'pass' => env('MIKROTIK_PASSWORD'),
                            // 'port' => env('MIKROTIK_PORT'),
                            'port' => intval(env('MIKROTIK_PORT')),
                        ]);

                        $ppp_secret = (new Query('/ppp/secret/set'))
                                    ->equal('.id', explode('|',$datas['payment']['order']['service']['service_code'])[1])
                                    ->equal('name',$datas['payment']['order']['service']['username'])
                                    ->equal('disabled','false')
                                    ;

                        $client->query($ppp_secret)->read();

                    } catch (\Exception $th) {

                    }
                    break;

                case 'EXPIRED':
                    $datas['payment']->update([
                        // 'transaction_reference' => $data->reference,
                        'status' => 'Expired'
                    ]);

                    $datas['payment']['order']->update([
                        'status' => 'Expired'
                    ]);

                    $datas['payment']['order']['service']->update([
                        'status' => 'Expired'
                    ]);
                    break;

                case 'FAILED':
                    $datas['payment']->update([
                        // 'transaction_reference' => $data->reference,
                        'status' => 'Expired'
                    ]);

                    $datas['payment']['order']->update([
                        'status' => 'Expired'
                    ]);

                    $datas['payment']['order']['service']->update([
                        'status' => 'Expired'
                    ]);
                    break;

                default:
                    return Response::json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ]);
            }

            return Response::json(['success' => true]);
        }
    }

    public function detailTransaction($reference)
    {
        $apiKey = $this->tripay_api_key;

        $payload = ['reference'	=> $reference];

        $curl = curl_init();

        $url_tripay = $this->tripay_url;

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => $url_tripay.'/transaction/detail?'.http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        // echo empty($error) ? $response : $error;
        return $response ? $response : $error;
    }

    public function handle_open_payment(Request $request)
    {
        // $privateKey = $this->tripay_private_key;
        // $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        // $merchantCode = $this->tripay_merchant;
        // $channel = 'BCAVA';
        // // $merchantRef = 'INV'.rand(1000000,999999);
        // $merchantRef = 'INV587214';
        // // dd($merchantRef);
        // $signature = hash_hmac('sha256', $merchantCode.$channel.$merchantRef, $privateKey);
        // // dd($signature);
        // if ($signature !== (string) $callbackSignature) {
        //     return Response::json([
        //         'success' => false,
        //         'message' => 'Invalid signature',
        //     ]);
        // }

        // if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
        //     return Response::json([
        //         'success' => false,
        //         'message' => 'Unrecognized callback event, no action was taken',
        //     ]);
        // }

        // $data = json_decode($json);

        // if (JSON_ERROR_NONE !== json_last_error()) {
        //     return Response::json([
        //         'success' => false,
        //         'message' => 'Invalid data sent by tripay',
        //     ]);
        // }

        // $invoiceId = $data->merchant_ref;
        // $tripayReference = $data->reference;
        // $status = strtoupper((string) $data->status);

        $apiKey       = $this->tripay_api_key;
        $privateKey   = $this->tripay_private_key;
        $merchantCode = $this->tripay_merchant;
        $merchantRef  = 'INV'.Carbon::now()->format('Ymd').rand(1000,9999);
        $method       = 'BCAVA';

        $data = [
            'method'        => $method,
            'merchant_ref'  => $merchantRef,
            'customer_name' => $request->customer_name,
            'signature'     => hash_hmac('sha256', $merchantCode.$method.$merchantRef, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => $this->tripay_url."/open-payment/create",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        // echo empty($error) ? $response : $error;
        return empty($error) ? $response : $error;

    }

}
