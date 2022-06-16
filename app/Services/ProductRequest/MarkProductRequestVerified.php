<?php

namespace App\Services\ProductRequest;

use App\Models\ProductRequest;
use App\Models\ProductStock;
use Exception;

class MarkProductRequestVerified
{
    /**
     * @throws Exception
     */
    private function checkProductStock(ProductRequest $productRequest): void {
        $filter = [
            'product_id' => $productRequest->product->getKey(),
            'warehouse_id' => $productRequest->original_warehouse_id,
        ];

        $productStock = ProductStock::where($filter)->first();

        // Check if product stock is enough
        if ($productStock->quantity < $productRequest->quantity) {
            throw new Exception("Product stock is not enough!");
        }
    }

    /**
     * @throws Exception
     */
    private function checkStatusIsAlreadyVerified(ProductRequest $productRequest): void {
        if ($productRequest->status === 'Verified') {
            throw new Exception("Product request is already verified!");
        }
    }

    /**
     * @throws Exception
     */
    public function handle(ProductRequest $productRequest) {
        $this->checkStatusIsAlreadyVerified($productRequest);
        $this->checkProductStock($productRequest);

        $productRequest->update([
            'status' => 'Verified',
        ]);
    }
}
