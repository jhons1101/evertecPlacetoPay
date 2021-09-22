<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Http\Traits\PlaceToPayTrait;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    use PlaceToPayTrait;

    /**
     * @func index()
     * @desc Carga la vista index para la consulta de la orden de compra
     * @date 19/09/2021
     */
    public function index()
    {
        return view('orderStatus')->with('msg', "")->with('arrStatus', array());
    }
    /**
     * @func listOrders()
     * @desc Carga la vista index para la consulta de todas las ordenes de compra
     * @date 19/09/2021
     */
    public function listOrders()
    {
        $arrOrders = DB::select('SELECT * FROM products p, orders o WHERE o.id_product = p.id');
        return view('listOrders')->with('arrOrders', $arrOrders);
    }

    /**
     * @func getStatus()
     * @desc Carga la vista index para la consulta de la orden de compra
     * @date 19/09/2021
     */
    public function getStatus(OrderStatusRequest $request)
    {
        $date = date('c');
        $seedDate = strtotime('+4 minute', strtotime($date));
        $seed = date(DATE_ATOM, $seedDate);
        $secretKey = env('SECRETKEY');
        $loginPlacetoPay = env('LOGINPLACETOPAY');
        $expirationDate = strtotime('+24 hour', strtotime($date));
        $expirationPay = date(DATE_ATOM, $expirationDate);

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        $nonceBase64 = base64_encode($nonce);
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

        $dataWS = [
            'auth' => [
                'login' => $loginPlacetoPay,
                'seed' => $seed,
                'nonce' => $nonceBase64,
                'tranKey' => $tranKey,
            ],
        ];

        $response = Http::post('https://dev.placetopay.com/redirection/api/session/' . $request->payReference, $dataWS);
        $response = $response->json();

        $statusOrder = $response['status']['status'];

        if ($statusOrder != 'FAILED') {
            $payReference = $response['request']['payment']['reference'];
            $amountPaid = $response['request']['payment']['amount']['total'];
            $currencyPaid = $response['request']['payment']['amount']['currency'];
            $paymentMethod = is_array($response['payment']) ? $response['payment'][0]['paymentMethod'] : "";
            $requestId = $response['requestId'];
        }

        if ($statusOrder == 'APPROVED') {
            $orden = Order::where('id', $payReference)->update(["status" => "PAYED"]);
        } else if ($statusOrder == 'REJECTED') {
            $orden = Order::where('id', $payReference)->update(["status" => "REJECTED"]);
        } else if ($statusOrder == 'FAILED') {

            return view('orderStatus')
                ->with('msg', $response['status']['message'])
                ->with('arrStatus', array());
        }

        $arrStatus = [
            'paymentReference' => $payReference,
            'amountPaid' => $amountPaid,
            'currencyPaid' => $currencyPaid,
            'statusOrder' => $statusOrder,
            'paymentMethod' => $paymentMethod,
            'requestId' => $requestId,
        ];

        return view('orderStatus')
            ->with('msg', "")
            ->with('arrStatus', $arrStatus);
    }

    /**
     * @func paymentAgain()
     * @desc solicita el proceso de pago de orden de compra rechazada
     * @date 19/09/2021
     */
    public function paymentAgain($idOrder)
    {
        try {

            $order = Order::find($idOrder);
            $idProduct = $order->getAttributes()['id_product'];
            $returnWs = $this->WsPaymentPlaceToPay($idOrder, $idProduct);

            if ($returnWs['status'] == 'OK') {
                return redirect()->away($returnWs['processUrl']);
            } else {
                return view('orderStatus', [
                    'arrStatus' => array(),
                    'msg' => $returnWs['msg'],
                ]);
            }
        } catch (\Throwable $th) {

            $msg = "Error in the file: " . $th->getFile() . ". in the line: " . $th->getLine() . " -> " . $th->getMessage();

            return view('orderStatus', [
                'arrStatus' => array(),
                'msg' => $msg,
            ]);
        }
    }
}
