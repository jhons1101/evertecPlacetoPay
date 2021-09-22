<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * test_index_order()
     *
     * @return void
     */
    public function test_index_order()
    {
        $this->withoutExceptionHandling();
        Product::factory()->count(4)->make();

        $response = $this->get('/');
        $response->assertOk();
        
        $products = Product::all();
        
        $response->assertViewIs('index');
        $response->assertStatus(200);
    }

    /**
     * test_list_orders()
     *
     * @return void
     */
    public function test_list_orders()
    {
        $this->withoutExceptionHandling();
        Product::factory()->count(4)->make();

        $response = $this->get('/listOrders');
        $response->assertOk();
        
        $products = Product::all();
        $response->assertViewIs('listOrders');
        $response->assertStatus(200);

    }
    /**
     * test_get_status()
     *
     * @return void
     */
    public function test_get_status()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('GET', '/getStatus', [
            'payReference' => '45091'
        ]);

        $response->assertOk();
        $response->assertStatus(200);
        $response->assertViewIs('orderStatus');
    }

    /**
     * test_payment_again()
     *
     * @return void
     */
    public function test_payment_again()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/paymentAgain/{idOrder}', [
            'idOrder' => '45091'
        ]);
        
        $response->assertOk();
        $response->assertStatus(200);
        $response->assertViewIs('orderStatus');
    }
}
