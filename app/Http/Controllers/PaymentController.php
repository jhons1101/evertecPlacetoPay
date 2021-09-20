<?php

// Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Models\Product;

use App\Http\Traits\PlaceToPayTrait;

class PaymentController extends Controller
{
    use PlaceToPayTrait;

    /**
     * @func index()
     * @desc Carga la vista index de la orden de compra
     * @date 19/09/2021
     */
    public function index($id)
    {

        return view('payment')
                ->with('idProduct', $id)
                ->with('msg', "");
    }

    /**
     * @func store()
     * @desc Guarda la orden de compra y dirige al portal de pagos PlaceToPay
     * @date 19/09/2021
     */
    public function store(PaymentRequest $request)
    {
        try {
            
            $createOrder = Order::create([
                'id_product' => request('product_id'),
                'customer_name' => request('customer_name'),
                'customer_email' =>request('customer_email'),
                'customer_phone' =>request('customer_phone'),
                'status' => 'CREATED'
            ]);

            $returnWs = $this->WsPaymentPlaceToPay($createOrder->getAttributes()['id'], request('product_id'));
            
            if ($returnWs['status'] == 'OK')
            {
                return redirect()->away($returnWs['processUrl']);
            }
            else
            {
                return view('payment', [
                    'idProduct' => request('product_id'),
                    'msg'       => $returnWs['msg']
                ]);
            }
        
        } catch (\Throwable $th) {
            
            $msg = "Error in the file: " . $th->getFile() . ". in the line: " . $th->getLine() . " -> " .$th->getMessage();
                
            return view('payment', [
                'idProduct' => request('product_id'),
                'msg' => $msg
            ]);
        }
    }
}
