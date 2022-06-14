<?php

namespace App\Observers;

use App\Models\ProductRequest;
use App\Services\ProductStock\ModifyProductStock;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class ProductRequestObserver
{
    private ModifyProductStock $modifyProductStock;

    public function __construct()
    {
        $this->modifyProductStock= new ModifyProductStock();
    }

    public function created(ProductRequest $productRequest)
    {
        //
    }

    public function updated(ProductRequest $productRequest)
    {
        if ($productRequest->isDirty('status')) {
            if ($productRequest->status === 'Verified') {
                $this->modifyProductStock
                    ->decrease()
                    ->handle($productRequest, $productRequest->original_warehouse_id);
            }

            if ($productRequest->status === 'Delivered') {
                $this->modifyProductStock
                    ->increase()
                    ->handle($productRequest, $productRequest->destination_warehouse_id);
            }
        }
    }

    public function deleted(ProductRequest $productRequest)
    {
        //
    }

    public function restored(ProductRequest $productRequest)
    {
        //
    }

    public function forceDeleted(ProductRequest $productRequest)
    {
        //
    }
}
