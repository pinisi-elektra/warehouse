<?php

namespace App\Observers;

use App\Models\ProductRequest;
use App\Services\ProductStock\DecreaseProductStock;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class ProductRequestObserver
{
    private DecreaseProductStock $decreaseProductStock;

    public function __construct(DecreaseProductStock $decreaseProductStock)
    {
        $this->decreaseProductStock = new DecreaseProductStock();
    }

    public function created(ProductRequest $productRequest)
    {
        //
    }

    public function updated(ProductRequest $productRequest)
    {
        if ($productRequest->isDirty('status')) {
            if ($productRequest->status === 'Verified') {
                $this->decreaseProductStock->handle($productRequest);
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
