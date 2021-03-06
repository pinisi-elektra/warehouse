<?php

namespace App\Observers;

use App\Models\ProductStock;
use App\Models\ProductStockActivity;
use App\Models\ProductStockHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class ProductStockObserver
{
    const STOCK_IN = 'Stock In';
    const STOCK_OUT = 'Stock Out';

    /**
     * @throws \Exception
     */
    public function creating(ProductStock $productStock): void
    {
        if ($productStock->quantity < 0) throw new \Exception('Quantity cannot be less than 0');
    }

    /**
     * Handle the ProductStock "created" event.
     *
     * @param \App\Models\ProductStock $productStock
     * @return void
     */
    public function created(ProductStock $productStock)
    {
        $type = self::STOCK_IN;

        ProductStockHistory::create([
            'user_id' => Auth::id(),
            'product_stock_id' => $productStock->getKey(),
            'description' => "$type to {$productStock->quantity}"
        ]);
    }

    /**
     * Handle the ProductStock "updating" event.
     *
     * @param \App\Models\ProductStock $productStock
     * @return void
     * @throws \Exception
     */
    public function updating(ProductStock $productStock)
    {
        if ($productStock->quantity < 0) throw new \Exception('Quantity cannot be less than 0x');

        if ($productStock->isDirty('quantity')) {
            $type = self::STOCK_IN;

            if ($productStock->getOriginal('quantity') > $productStock->quantity) {
                $type = self::STOCK_OUT;
            }

            ProductStockHistory::create([
                'user_id' => Auth::id(),
                'product_stock_id' => $productStock->getKey(),
                'description' => "$type from {$productStock->getOriginal('quantity')} to {$productStock->quantity}"
            ]);
        }
    }

    /**
     * Handle the ProductStock "deleted" event.
     *
     * @param \App\Models\ProductStock $productStock
     * @return void
     */
    public function deleted(ProductStock $productStock)
    {
        //
    }

    /**
     * Handle the ProductStock "restored" event.
     *
     * @param \App\Models\ProductStock $productStock
     * @return void
     */
    public function restored(ProductStock $productStock)
    {
        //
    }

    /**
     * Handle the ProductStock "force deleted" event.
     *
     * @param \App\Models\ProductStock $productStock
     * @return void
     */
    public function forceDeleted(ProductStock $productStock)
    {
        //
    }
}
