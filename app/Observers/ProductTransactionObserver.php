<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionVendor;
use App\Models\ProductTransactionWarehouse;

class ProductTransactionObserver
{
    /**
     * @throws \Exception
     */
    public function creating(ProductTransaction $productTransaction)
    {
        $productTransaction->created_by = auth()->id();
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
