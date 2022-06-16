<?php

namespace App\Nova;

use App\Models\ProductRequest as ProductRequestModel;
use App\Nova\Actions\MarkProductRequestDelivered;
use App\Nova\Actions\VerifyProductRequest;
use App\Nova\Metrics\ProductPerStatus;
use App\Nova\Metrics\ProductRequestDeliveredProgress;
use App\Nova\Metrics\ProductRequestPerDay;
use App\Nova\Metrics\ProductRequestValue;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class ProductRequest extends Resource
{
    public static $model = ProductRequestModel::class;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Origin Warehouse', 'originalWarehouse', Warehouse::class),

            BelongsTo::make('Destination Warehouse', 'destinationWarehouse', Warehouse::class),

            BelongsTo::make('Product'),

            Number::make('Quantity')->required(),

            Textarea::make('Description'),

            Text::make('Shipping Type'),

            Text::make('Shipping Logistic'),

            Text::make('Shipping Receipt Number'),

            Textarea::make('Shipping Note'),

            Select::make('Status')->options([
                'Pending' => 'Pending',
                'Verified' => 'Verified',
                'Delivered' => 'Delivered',
            ])
                ->default('Pending')
                ->displayUsingLabels(),

            DateTime::make('Created At')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->sortable(),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            new ProductRequestPerDay(),
            new ProductPerStatus(),
            new ProductRequestDeliveredProgress()
        ];
    }

    public function filters(Request $request): array
    {
        return [];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [
            (new VerifyProductRequest())->showInline(),
            (new MarkProductRequestDelivered())->showInline()
        ];
    }
}
