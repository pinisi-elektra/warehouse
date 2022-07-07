<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductTransactionVendor;

class ProductTransactionVendorObserver
{
    public function creating(ProductTransactionVendor $productTransactionVendor)
    {
        $filter = [
            'product_id' => $productTransactionVendor->productTransaction->product_id,
            'warehouse_id' => $productTransactionVendor->productTransaction->warehouse_id,
            'project_id' => $productTransactionVendor->productTransaction->project_id,
        ];

        $productStock = ProductStock::firstOrNew($filter);

        if ($productTransactionVendor->type === ProductTransactionVendor::TYPE_RETURN) {
            $productStock->quantity = $productStock->quantity - $productTransactionVendor->productTransaction->quantity;
        }

        if ($productTransactionVendor->type === ProductTransactionVendor::TYPE_PURCHASE) {
            $productStock->quantity = $productStock->quantity + $productTransactionVendor->productTransaction->quantity;
        }

        $productStock->save();
    }

    public function created(ProductTransactionVendor $productTransactionVendor)
    {

    }

    public function updated(ProductTransactionVendor $productTransactionVendor)
    {
    }

    public function deleted(ProductTransactionVendor $productTransactionVendor)
    {
    }

    public function restored(ProductTransactionVendor $productTransactionVendor)
    {
    }

    public function forceDeleted(ProductTransactionVendor $productTransactionVendor)
    {
    }
}
