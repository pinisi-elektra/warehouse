<?php

namespace App\Nova;

use App\Models\ProductTransactionWarehouse as ProductTransactionWarehouseModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class ProductTransactionWarehouse extends Resource
{
    public static $model = ProductTransactionWarehouseModel::class;

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

            BelongsTo::make('Product Transaction', 'productTransaction', StockTransfer::class)
                ->showCreateRelationButton(),

            BelongsTo::make('Destination Warehouse', 'warehouse', Warehouse::class)
                ->showCreateRelationButton()
                ->searchable(),

            Text::make('Destination Warehouse Name')
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Textarea::make('Description')
                ->nullable(),

            Select::make('Transaction Type', 'type')
                ->options([
                    'request' => 'Request',
                    'return' => 'Return',
                ])
                ->displayUsingLabels()
                ->rules('required'),

            Text::make('Status')
                ->hideWhenCreating()
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
        return [
            // new Actions\MarkProductTransactionWarehouseDelivered,
        ];
    }
}
