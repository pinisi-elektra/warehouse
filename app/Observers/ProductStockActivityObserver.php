<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductStockActivity;
use App\Services\ProductStock\ModifyProductStock;
use Illuminate\Support\Facades\Auth;

class ProductStockActivityObserver
{
    private ModifyProductStock $modifyProductStock;

    public function __construct(ModifyProductStock $modifyProductStock)
    {
        $this->modifyProductStock = $modifyProductStock;
    }

    public function creating(ProductStockActivity $productStockActivity)
    {
        $productStockActivity->user_id = Auth::id();
    }

    /**
     * Handle the ProductStockActivity "created" event.
     *
     * @param \App\Models\ProductStockActivity $productStockActivity
     * @return void
     */
    public function created(ProductStockActivity $productStockActivity)
    {
        $modifyProduct = $this->modifyProductStock->increase();

        if ($productStockActivity->type === 'out') {
            $modifyProduct = $modifyProduct->decrease();
        }

        $modifyProduct->modify($productStockActivity->productStock, $productStockActivity->quantity);
    }

    /**
     * Handle the ProductStockActivity "updated" event.
     *
     * @param \App\Models\ProductStockActivity $productStockActivity
     * @return void
     */
    public function updated(ProductStockActivity $productStockActivity)
    {
        //
    }

    /**
     * Handle the ProductStockActivity "deleted" event.
     *
     * @param \App\Models\ProductStockActivity $productStockActivity
     * @return void
     */
    public function deleted(ProductStockActivity $productStockActivity)
    {
        //
    }

    /**
     * Handle the ProductStockActivity "restored" event.
     *
     * @param \App\Models\ProductStockActivity $productStockActivity
     * @return void
     */
    public function restored(ProductStockActivity $productStockActivity)
    {
        //
    }

    /**
     * Handle the ProductStockActivity "force deleted" event.
     *
     * @param \App\Models\ProductStockActivity $productStockActivity
     * @return void
     */
    public function forceDeleted(ProductStockActivity $productStockActivity)
    {
        //
    }
}
