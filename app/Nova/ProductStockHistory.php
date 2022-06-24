<?php

namespace App\Nova;

use App\Models\ProductStockHistory as ProductStockHistoryModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class ProductStockHistory extends Resource
{
    public static $model = ProductStockHistoryModel::class;

    public static $displayInNavigation = false;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Product Stock'),
            BelongsTo::make('User'),
            Text::make('Description'),
            DateTime::make('Created At')
                ->onlyOnDetail()
                ->onlyOnIndex()
                ->sortable(),
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
