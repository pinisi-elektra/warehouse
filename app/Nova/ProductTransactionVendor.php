<?php

namespace App\Nova;

use App\Models\ProductTransactionVendor as ProductTransactionVendorModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class ProductTransactionVendor extends Resource
{
    public static $model = ProductTransactionVendorModel::class;

    public static $group = 'Transaction';

    public static $displayInNavigation = false;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Vendor Name', 'productVendor.name')
                ->onlyOnDetail(),

            Text::make('Vendor Email', 'productVendor.email')
                ->onlyOnDetail(),

            Text::make('Vendor Phone', 'productVendor.phone')
                ->onlyOnDetail(),

            Text::make('Vendor Address', 'productVendor.address')
                ->onlyOnDetail(),

            BelongsTo::make('Product Vendor', 'productVendor', ProductVendor::class)
                ->showCreateRelationButton()
                ->rules('required'),

            BelongsTo::make('Product Transaction', 'productTransaction', Purchase::class),

            Select::make('Type')
                ->options([
                    ProductTransactionVendorModel::TYPE_PURCHASE => 'Purchase',
                    ProductTransactionVendorModel::TYPE_RETURN => 'Return',
                ])
                ->rules('required')
                ->displayUsingLabels(),
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
