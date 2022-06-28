<?php

namespace App\Nova;

use App\Models\ProductStock as ProductStockModel;
use App\Nova\Metrics\NewProductStock;
use App\Nova\Metrics\ProductStockPerWarehouse;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;

class ProductStock extends Resource
{
    public static $model = ProductStockModel::class;

    public static $title = 'product.name';

    public static $group = 'Product';

    public static $search = [
        'id'
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Product'),

            Number::make('Quantity')
                ->hideWhenUpdating()
                ->sortable(),

            BelongsTo::make('Warehouse'),

            HasMany::make('Activities', 'activities', ProductStockActivity::class),

            HasMany::make('Histories', 'histories', ProductStockHistory::class),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            new ProductStockPerWarehouse()
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
        return [];
    }
}
