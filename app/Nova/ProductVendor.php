<?php

namespace App\Nova;

use App\Models\ProductVendor as ProductVendorModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class ProductVendor extends Resource
{
    public static $model = ProductVendorModel::class;

    public static $title = 'name';

    public static $search = [
        ''
    ];

    public static $group = 'Master Data';

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('required'),

            Text::make('Email'),

            Number::make('Phone'),

            Text::make('Address'),
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
