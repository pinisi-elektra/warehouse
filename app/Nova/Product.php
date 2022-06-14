<?php

namespace App\Nova;

use App\Models\Product as ProductModel;
use App\Nova\Metrics\ProductValue;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Product extends Resource
{
    public static $model = ProductModel::class;

    public static $title = 'name';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->sortable()->required(),
            Boolean::make('Is Active')->sortable()->default(true),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            new ProductValue(),
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
