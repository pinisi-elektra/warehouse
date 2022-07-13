<?php

namespace App\Nova;

use App\Helpers\QuantityUnit;
use App\Helpers\RoleList;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Purchase extends Resource
{
    public static $model = ProductTransaction::class;

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    public static $group = 'Main Feature';

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas('productTransactionVendors');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Project', 'project', Project::class),

            Number::make('Quantity', 'quantity')
                ->rules('required', 'numeric', 'min:1'),

            Select::make('Quantity Unit', 'quantity_volume')
                ->options(QuantityUnit::new()->list)
                ->displayUsingLabels(),

            BelongsTo::make('Product')
                ->rules('required')
                ->showCreateRelationButton()
                ->searchable(),

            BelongsTo::make('Warehouse')
                ->rules('required')
                ->showCreateRelationButton()
                ->searchable(),

            HasOne::make('Vendor Detail', 'productTransactionVendors', ProductTransactionVendor::class)
                ->canSee(function ($request) {
                    return $request->user()->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
                })
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
