<?php

namespace App\Nova;

use App\Models\ProductTransactionSales as ProductTransactionSalesModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Textarea;

class ProductTransactionSales extends Resource
{
    public static $model = ProductTransactionSalesModel::class;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public static $displayInNavigation = false;

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Product Transaction', 'productTransaction', Sales::class),

            Textarea::make('Description', 'description')
                ->rules('required'),
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
