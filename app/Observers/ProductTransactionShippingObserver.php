<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductTransactionShipping;
use App\Models\ProductTransactionWarehouse;

class ProductTransactionShippingObserver
{
    public function creating(ProductTransactionShipping $productTransactionShipping)
    {
        $productTransactionShipping->created_by = auth()->id();
    }

    public function created(ProductTransactionShipping $productTransactionShipping)
    {
        if ($productTransactionShipping->productTransaction->productTransactionWarehouse->exists()) {
            if ($productTransactionShipping->shipping_type == 'send') {
                // mark status shipped
                $productTransactionShipping->productTransaction->productTransactionWarehouse->update([
                    'status' => 'shipped'
                ]);

                // decrease product stock from warehouse
                $productStock = ProductStock::firstOrNew([
                    'product_id' => $productTransactionShipping->productTransaction->product_id,
                    'warehouse_id' => $productTransactionShipping->productTransaction->warehouse_id
                ]);

                $productStock->quantity = $productStock->quantity - $productTransactionShipping->productTransaction->quantity;
                $productStock->save();
            }

            if ($productTransactionShipping->shipping_type == 'received') {
                // mark status delivered
                $productTransactionShipping->productTransaction->productTransactionWarehouse->update([
                    'status' => 'delivered'
                ]);

                // increase product stock from warehouse
                $productStock = ProductStock::firstOrNew([
                    'product_id' => $productTransactionShipping->productTransaction->product_id,
                    'warehouse_id' => $productTransactionShipping->productTransaction->productTransactionWarehouse->warehouse_id
                ]);

                $productStock->quantity = $productStock->quantity + $productTransactionShipping->productTransaction->quantity;
                $productStock->save();
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
