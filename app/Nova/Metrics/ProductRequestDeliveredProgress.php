<?php

namespace App\Nova\Metrics;

use App\Models\Product;
use App\Models\ProductRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Progress;

class ProductRequestDeliveredProgress extends Progress
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $target = ProductRequest::count();

        return $this->count($request, ProductRequest::class, function ($query) {
            return $query->whereNot('status', 'Verified');
        }, target: $target);
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'product-request-delivered-progress';
    }
}
