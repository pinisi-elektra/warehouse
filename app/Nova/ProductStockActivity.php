<?php

namespace App\Nova;

use App\Models\ProductStockActivity as ProductStockActivityModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class ProductStockActivity extends Resource
{
    public static $model = ProductStockActivityModel::class;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Product Stock', 'productStock')->sortable(),
            Textarea::make('Description'),

            Number::make('Quantity')->sortable(),

            Select::make('Type')->options([
                'in' => 'In',
            ])->sortable(),

            Select::make('Source')->options([
                'Supplier' => 'Supplier',
                'Internal' => 'Internal'
            ])
                ->default('Supplier')
                ->displayUsingLabels(),

            Text::make('Source Name'),

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
