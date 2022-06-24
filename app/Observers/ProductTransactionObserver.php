<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionVendor;

class ProductTransactionObserver
{
    /**
     * @throws \Exception
     */
    public function creating(ProductTransaction $productTransaction)
    {
        $productTransaction->created_by = auth()->id();

        $filter = [
            'product_id' => $productTransaction->product_id,
            'warehouse_id' => $productTransaction->warehouse_id,
        ];

        $productStock = ProductStock::firstOrNew($filter);

        if ($productTransaction->productTransactionVendors->type === ProductTransactionVendor::TYPE_RETURN) {
            $productStock->quantity = $productStock->quantity - $productTransaction->quantity;
        }

        if ($productTransaction->productTransactionVendors->type === ProductTransactionVendor::TYPE_PURCHASE) {
            $productStock->quantity = $productStock->quantity + $productTransaction->quantity;
        }

        $productStock->save();
    }

    public function created(ProductTransaction $productTransaction)
    {

    }

    public function updated(ProductTransaction $productTransaction)
    {
    }

    public function deleted(ProductTransaction $productTransaction)
    {
    }

    public function restored(ProductTransaction $productTransaction)
    {
    }

    public function forceDeleted(ProductTransaction $productTransaction)
    {
    }
}
