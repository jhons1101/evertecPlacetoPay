<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

use App\Models\Product;

Trait PlaceToPayTrait
{

    public function WsPaymentPlaceToPay ($idOrder, $idProduct)
    {
        $product = Product::find($idProduct);
        $date = date('c');
        $seedDate = strtotime ('+4 minute' , strtotime ($date));
        $seed = date(DATE_ATOM, $seedDate);
        $secretKey = env('SECRETKEY');
        $loginPlacetoPay = env('LOGINPLACETOPAY');
        $referencePay = $idOrder;
        $expirationDate = strtotime ('+24 hour' , strtotime ($date));
        $expirationPay = date(DATE_ATOM, $expirationDate);
        $msg = "";
        $processUrl = "";

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        $nonceBase64 = base64_encode($nonce);
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

        $dataWS =  [
            'auth' => [
                'login' => $loginPlacetoPay,
                'seed' => $seed,
                'nonce' => $nonceBase64,
                'tranKey' => $tranKey
            ],
            'payment' => [
                'reference' => $referencePay,
                'description' => "Product: " . $product->name,
                'amount' => [
                    'currency' => $product->currency,
                    'total' => $product->cost
                ]
            ],
            'expiration' => $expirationPay,
            'returnUrl' => env('URLRETURNPAYMENT'),
            'ipAddress' => $this->getIp(),
            'userAgent' => env('USERAGENT')
        ];
        
        $response = Http::post('https://dev.placetopay.com/redirection/api/session/', $dataWS);
        $response = $response->json();
        
        if ($response['status']['status'] == 'OK')
        {
            $processUrl = $response['processUrl'];
        } 
        else 
        {
            $msg = "Ws Error: " . $response['status']['message'];
        }

        return [
            'status' => $response['status']['status'],
            'processUrl' => $processUrl,
            'msg' => $msg
        ];
    }

    /**
     * @func getIp()
     * @desc Obtiene la dirección IP desde donde se solicita la orden de compra
     * @date 19/09/2021
     */
    public function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}