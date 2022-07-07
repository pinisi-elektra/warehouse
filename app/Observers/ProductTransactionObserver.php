<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionVendor;
use App\Models\ProductTransactionWarehouse;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isNull;

class ProductTransactionObserver
{
    /**
     * @throws \Exception
     */
    public function creating(ProductTransaction $productTransaction)
    {
        $productTransaction->created_by = auth()->id();

        if(is_null($productTransaction->productTransactionWarehouse)) return;

        if ($productTransaction->productTransactionWarehouse->type == 'return') {
            $filter = [
                'product_id' => $productTransaction->product_id,
                'warehouse_id' => $productTransaction->warehouse_id,
                'project_id' => $productTransaction->project_id,
            ];

            $productStock = ProductStock::firstOrNew($filter);

            $productStock->quantity = $productStock->quantity - $productTransaction->quantity;

            $productStock->save();
        }
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
