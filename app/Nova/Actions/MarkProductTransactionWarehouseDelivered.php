<?php

namespace App\Nova\Actions;

use App\Models\ProductStock;
use App\Models\ProductTransactionShipping;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class MarkProductTransactionWarehouseDelivered extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->status = 'delivered';
            $model->save();

            $filter = [
                'product_id' => $model->productTransaction->product_id,
                'warehouse_id' => $model->warehouse_id
            ];

            $productStock = ProductStock::firstOrNew($filter);
            $productStock->quantity = $productStock->quantity + $model->productTransaction->quantity;
            $productStock->save();

//            ProductTransactionShipping::create([
//                'product_transaction_id' => $model->productTransaction->id,
//                'photo_evidence' => $fields->photo_evidence,
//                'shipping_date' => $fields->shipping_date,
//            ]);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
//            Image::make('Photo Evidence')
//                ->disk('public')
//                ->nullable(),
//
//            DateTime::make('Received Date', 'shipping_date')
//                ->sortable()
//                ->rules('required'),
        ];
    }
}
