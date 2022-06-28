<?php

namespace App\Nova\Metrics;

use App\Models\ProductRequest;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionVendor;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ProductTransactionVendorPerStatus extends Partition
{
    public function name()
    {
        return "Product Vendor Status";
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, ProductTransactionVendor::class, 'type');
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
         return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'product-vendor-per-status';
    }
}
