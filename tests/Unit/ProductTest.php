<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_a_product_has_many_orders()
    {
        $product = new Product;

        $this->assertInstanceOf(Collection::class, $product->orders);
    }
}
