<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductTransactionShipping;
use App\Models\ProductTransactionWarehouse;

class ProductTransactionShippingObserver
{
    public function creating(ProductTransactionShipping $productTransactionShipping)
    {
        $filter = [
            'product_id' => $productTransactionShipping->productTransaction->product_id,
            'warehouse_id' => $productTransactionShipping->productTransaction->warehouse_id
        ];

        $productStock = ProductStock::firstOrNew($filter);
        $productStock->quantity = $productStock->quantity - $productTransactionShipping->productTransaction->quantity;
        $productStock->save();
    }

    public function created(ProductTransactionShipping $productTransactionShipping)
    {
        if ($productTransactionShipping->productTransaction->productTransactionWarehouse->exists()) {
            if ($productTransactionShipping->shipping_type == 'send') {
                $productTransactionShipping->productTransaction->productTransactionWarehouse->update([
                    'status' => 'shipped'
                ]);
            }

            if ($productTransactionShipping->shipping_type == 'received') {
                $productTransactionShipping->productTransaction->productTransactionWarehouse->update([
                    'status' => 'delivered'
                ]);
            }
        }
    }

    public function updated(ProductTransactionShipping $productTransactionShipping)
    {
    }

    public function deleted(ProductTransactionShipping $productTransactionShipping)
    {
    }

    public function restored(ProductTransactionShipping $productTransactionShipping)
    {
    }

    public function forceDeleted(ProductTransactionShipping $productTransactionShipping)
    {
    }
}
