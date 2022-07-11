<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductTransactionSales;

class ProductTransactionSalesObserver
{
    public function creating(ProductTransactionSales $productTransactionSales)
    {
        $filter = [
            'product_id' => $productTransactionSales->productTransaction->product_id,
            'warehouse_id' => $productTransactionSales->productTransaction->warehouse_id,
            'project_id' => $productTransactionSales->productTransaction->project_id,
        ];

        $productStock = ProductStock::firstOrNew($filter);

        $productStock->quantity = $productStock->quantity - $productTransactionSales->productTransaction->quantity;

        $productStock->save();
    }

    /**
     * Handle the ProductTransactionSales "created" event.
     *
     * @param \App\Models\ProductTransactionSales $productTransactionSales
     * @return void
     */
    public function created(ProductTransactionSales $productTransactionSales)
    {
        //
    }

    /**
     * Handle the ProductTransactionSales "updated" event.
     *
     * @param \App\Models\ProductTransactionSales $productTransactionSales
     * @return void
     */
    public function updated(ProductTransactionSales $productTransactionSales)
    {
        //
    }

    /**
     * Handle the ProductTransactionSales "deleted" event.
     *
     * @param \App\Models\ProductTransactionSales $productTransactionSales
     * @return void
     */
    public function deleted(ProductTransactionSales $productTransactionSales)
    {
        //
    }

    /**
     * Handle the ProductTransactionSales "restored" event.
     *
     * @param \App\Models\ProductTransactionSales $productTransactionSales
     * @return void
     */
    public function restored(ProductTransactionSales $productTransactionSales)
    {
        //
    }

    /**
     * Handle the ProductTransactionSales "force deleted" event.
     *
     * @param \App\Models\ProductTransactionSales $productTransactionSales
     * @return void
     */
    public function forceDeleted(ProductTransactionSales $productTransactionSales)
    {
        //
    }
}
