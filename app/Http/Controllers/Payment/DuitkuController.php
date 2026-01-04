<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DuitkuController extends Controller
{
    public function store($data)
    {
        $duitkuConfig = new \Duitku\Config(env("DUITKU_API_KEY"), env("DUITKU_MERCHANT_KEY"));
        // false for production mode
        // true for sandbox mode
        $duitkuConfig->setSandboxMode(env('DUITKU_IS_SANDBOX'));
        // set sanitizer (default : true)
        $duitkuConfig->setSanitizedMode(true);
        // set log parameter (default : true)
        $duitkuConfig->setDuitkuLogs(true);

        // $paymentMethod      = ""; // PaymentMethod list => https://docs.duitku.com/pop/id/#payment-method
        $paymentAmount      = $data['amount']; // Amount
        $paymentMethod      = $data['payment_method'];
        $email              = $data['email']; // your customer email
        $phoneNumber        = $data['phone_number']; // your customer phone number (optional)
        $productDetails     = $data['product'];
        $merchantOrderId    = time(); // from merchant, unique
        $additionalParam    = ''; // optional
        $merchantUserInfo   = ''; // optional
        $customerVaName     = $data['customer_name']; // display name on bank confirmation display
        $callbackUrl        = $data['url_callback']; // url for callback
        $returnUrl          = $data['url_return']; // url for redirect
        $expiryPeriod       = 25; // set the expired time in minutes

        // Customer Detail
        $firstName          = $data['first_name'];
        $lastName           = $data['last_name'];

        // Address
        $alamat             = $data['address'];
        $city               = $data['city'];
        $postalCode         = $data['postal_code'];
        $countryCode        = "ID";

        $address = array(
            'firstName'     => $firstName,
            'lastName'      => $lastName,
            'address'       => $alamat,
            'city'          => $city,
            'postalCode'    => $postalCode,
            'phone'         => $phoneNumber,
            'countryCode'   => $countryCode
        );

        $customerDetail = array(
            'firstName'         => $firstName,
            'lastName'          => $lastName,
            'email'             => $email,
            'phoneNumber'       => $phoneNumber,
            'billingAddress'    => $address,
            'shippingAddress'   => $address
        );

        // Item Details
        $item1 = array(
            'name'      => $productDetails,
            'price'     => $paymentAmount,
            'quantity'  => 1
        );

        $itemDetails = array(
            $item1
        );

        $params = array(
            'paymentAmount'     => $paymentAmount,
            'paymentMethod'     => $paymentMethod,
            'merchantOrderId'   => $merchantOrderId,
            'productDetails'    => $productDetails,
            'additionalParam'   => $additionalParam,
            'merchantUserInfo'  => $merchantUserInfo,
            'customerVaName'    => $customerVaName,
            'email'             => $email,
            'phoneNumber'       => $phoneNumber,
            'itemDetails'       => $itemDetails,
            'customerDetail'    => $customerDetail,
            'callbackUrl'       => $callbackUrl,
            'returnUrl'         => $returnUrl,
            'expiryPeriod'      => $expiryPeriod
        );

        try {
            // createInvoice Request
            $responseDuitkuPop = \Duitku\Api::createInvoice($params, $duitkuConfig);

            header('Content-Type: application/json');
            return $responseDuitkuPop;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function callback()
    {
        try {
            $duitkuConfig = new \Duitku\Config(env("DUITKU_API_KEY"), env("DUITKU_MERCHANT_KEY"));
            // false for production mode
            // true for sandbox mode
            $duitkuConfig->setSandboxMode(env('DUITKU_IS_SANDBOX'));
            // set sanitizer (default : true)
            $duitkuConfig->setSanitizedMode(true);
            // set log parameter (default : true)
            $duitkuConfig->setDuitkuLogs(true);

            $callback = \Duitku\Api::callback($duitkuConfig);

            header('Content-Type: application/json');
            $notif = json_decode($callback);

            if ($notif->resultCode == "00") {

            }else if ($notif->resultCode == "01") {

            }
        } catch (\Exception $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }
}
