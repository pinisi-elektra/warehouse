<?php

namespace App\Services\ProductStock;

use App\Models\ProductRequest;
use App\Models\ProductStock;

class ModifyProductStock
{
    private string $type;

    public function increase(): static
    {
        $this->type = 'increase';

        return $this;
    }

    public function decrease(): static
    {
        $this->type = 'decrease';

        return $this;
    }

    public function handle(ProductRequest $productRequest, int $warehouseId)
    {
        $product = $productRequest->product;
        $quantity = $productRequest->quantity;

        $filter = [
            'product_id' => $product->id,
            'warehouse_id' => $warehouseId,
        ];

        $productStock = ProductStock::where($filter)->first();
        if ($this->type === 'increase') {
            $newQuantity = $productStock->quantity + $quantity;
        } else {
            $newQuantity = $productStock->quantity - $quantity;
        }

        $productStock = ProductStock::updateOrCreate($filter, [
            'quantity' => $newQuantity,
        ]);

        $productStock->update(['quantity' => $newQuantity]);
    }
}
