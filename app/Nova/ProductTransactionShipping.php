<?php

namespace App\Nova;

use App\Models\ProductTransactionShipping as ProductTransactionShippingModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class ProductTransactionShipping extends Resource
{
    public static $model = ProductTransactionShippingModel::class;

    public static $title = 'id';

    public static $displayInNavigation = false;

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Select::make('Shipping Method')
                ->options([
                    'direct_pickup' => 'Direct Pickup',
                    'logistic' => 'Logistics',
                ])
                ->help(__("Fill this when shipping type is send"))
                ->displayUsingLabels()
                ->sortable(),

            Select::make('Shipping Type')
                ->options([
                    'send' => 'Send',
                    'received' => 'Received',
                ])
                ->displayUsingLabels()
                ->sortable(),

            Text::make('Logistic Name'),

            Text::make('Logistic Tracking Number'),

            Image::make('Photo Evidence')
                ->disk('public')
                ->nullable(),

            DateTime::make('Shipping / Received Date', 'date_shipped')
                ->sortable()
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
