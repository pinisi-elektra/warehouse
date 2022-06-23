<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductStockActivity;
use App\Services\ProductStock\ModifyProductStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class ProductStockActivityObserver
{
    private ModifyProductStock $modifyProductStock;

    public function __construct(ModifyProductStock $modifyProductStock)
    {
        $this->modifyProductStock = $modifyProductStock;
    }

    public function creating(ProductStockActivity $productStockActivity)
    {
        // update auth id
        $productStockActivity->user_id = Auth::id();

        if (!is_null($productStockActivity->product_stock_id)) return;

        // find product stock
        $productStock = Nova::whenServing(function (NovaRequest $request) use ($productStockActivity): ?ProductStock {
            $filter = [
                'warehouse_id' => $request->input('warehouse_id'),
                'product_id' => $request->input('product_id'),
            ];

            $productStock = ProductStock::where($filter)->first();
            if ($productStock) return $productStock;

            // fill initial quantity
            $filter['quantity'] = 0;

            return ProductStock::create($filter);
        });

        $productStockActivity->product_stock_id = $productStock->getKey();
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
