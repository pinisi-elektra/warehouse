<?php

namespace App\Nova;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\DependencyContainer\HasDependencies;
use App\Helpers\RoleList;
use App\Models\ProductTransactionShipping as ProductTransactionShippingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class ProductTransactionShipping extends Resource
{
    use HasDependencies;

    public static string $model = ProductTransactionShippingModel::class;

    public static $title = 'id';

    public static $displayInNavigation = false;

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Select::make('Shipping Type', 'shipping_type')
                ->options(function () {
                    return array_filter([
                        'send' => Auth::user()->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN) ? 'Send' : null,
                        'received' => 'Received'
                    ]);
                })
                ->displayUsingLabels()
                ->sortable(),

            DependencyContainer::make([
                Select::make('Shipping Method')
                    ->options([
                        'direct_pickup' => 'Direct Pickup',
                        'logistic' => 'Logistics',
                    ])
                    ->help(__("Fill this when shipping type is send"))
                    ->displayUsingLabels()
                    ->sortable(),

                Text::make('Logistic Name'),

                Text::make('Logistic Tracking Number'),
            ])->dependsOn('shipping_type', 'send'),

            Image::make('Photo Evidence')
                ->disk('public')
                ->nullable(),

            DateTime::make('Shipping / Received Date', 'date_shipped')
                ->sortable()
                ->rules('required'),

            BelongsTo::make('Created by', 'creator', User::class)
                ->hideWhenCreating()
                ->hideWhenUpdating(),
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
