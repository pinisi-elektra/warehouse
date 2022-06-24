<?php

namespace App\Nova;

use App\Models\ProductTransaction as ProductTransactionModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;

class ProductTransaction extends Resource
{
    public static $model = ProductTransactionModel::class;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Product')->required(),
            BelongsTo::make('Warehouse')->required(),
            Number::make('Quantity', 'quantity')->required(),

            HasOne::make('Transaction from Vendor', 'productTransactionVendors', ProductTransactionVendor::class)
                ->nullable(),
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
