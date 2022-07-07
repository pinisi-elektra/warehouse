<?php

namespace App\Nova;

use Alexwenzel\DependencyContainer\HasDependencies;
use App\Helpers\RoleList;
use App\Models\ProductTransaction as ProductTransactionModel;
use App\Nova\Metrics\ProductTransactionPerDay;
use App\Nova\Metrics\ProductTransactionVendorPerStatus;
use App\Nova\Metrics\ProductTransactionWarehousePerStatus;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductTransaction extends Resource
{
    use HasDependencies;

    public static $model = ProductTransactionModel::class;

    public static $group = 'Transaction';

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public static $displayInNavigation = false;

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas('product', function ($query) use ($request) {
            $query->where('company_id', $request->user()->company->company_id);
        });
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Project', 'project', Project::class)
                ->help(__("Left this null if the product is not related to a project"))
                ->nullable(),

            BelongsTo::make('Product')
                ->rules('required')
                ->showCreateRelationButton()
                ->searchable(),

            BelongsTo::make('Warehouse')
                ->rules('required')
                ->showCreateRelationButton()
                ->searchable(),

            Number::make('Quantity', 'quantity')
                ->rules('required', 'numeric', 'min:1'),

            HasOne::make('Transaction Vendor', 'productTransactionVendors', ProductTransactionVendor::class)
                ->canSee(function ($request) {
                    return is_null($this->model()->productTransactionWarehouse)
                        && $request->user()->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
                })
                ->nullable(),

            HasOne::make('Transaction Warehouse', 'productTransactionWarehouse', ProductTransactionWarehouse::class)
                ->canSee(function ($request) {
                    return is_null($this->model()->productTransactionVendors);
                })
                ->nullable(),

            HasMany::make('Transaction Shipping History', 'productTransactionShipping', ProductTransactionShipping::class)
                ->canSee(function ($request) {
                    return $request->user()->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
                })
                ->nullable(),

            BelongsTo::make('Created by', 'creator', User::class)
                ->hideWhenCreating()
                ->hideWhenUpdating(),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            new ProductTransactionPerDay(),
            new ProductTransactionWarehousePerStatus(),
            new ProductTransactionVendorPerStatus(),
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
