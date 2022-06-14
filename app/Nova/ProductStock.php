<?php

namespace App\Nova;

use App\Models\ProductStock as ProductStockModel;
use App\Nova\Metrics\NewProductStock;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;

class ProductStock extends Resource
{
    public static $model = ProductStockModel::class;

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Product'),

            Number::make('Quantity')
                ->sortable()
                ->rules('required', 'integer'),

            BelongsTo::make('Warehouse'),
        ];
    }

    public function cards(Request $request): array
    {
        return [];
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
        return [];
    }
}
