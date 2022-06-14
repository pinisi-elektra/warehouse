<?php

namespace App\Services\ProductStock;

use App\Models\ProductRequest;
use App\Models\ProductStock;

class DecreaseProductStock
{
    public function handle(ProductRequest $productRequest)
    {
        $product = $productRequest->product;
        $quantity = $productRequest->quantity;

        $filter = [
            'product_id' => $product->id,
            'warehouse_id' => $productRequest->destination_warehouse_id,
        ];

        $productStock = ProductStock::where($filter)->firstOrFail();
        $productStock->update(['quantity' => $productStock->quantity - $quantity]);
    }
}
