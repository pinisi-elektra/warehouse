<?php

namespace App\Nova;

use App\Models\ProductStockActivity as ProductStockActivityModel;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class ProductStockActivity extends Resource
{
    public static $model = ProductStockActivityModel::class;

    public static $displayInNavigation = false;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public function getProductData(): array
    {
        return Product::select(['id', 'name'])
            ->get()->mapWithKeys(function ($item, $key) {
                return [$item['id'] => $item['name']];
            })->all();
    }

    public function getWarehouses(): array
    {
        return \App\Models\Warehouse::select(['id', 'name'])
            ->get()->mapWithKeys(function ($item, $key) {
                return [$item['id'] => $item['name']];
            })->all();
    }

    public function fields(Request $request): array
    {
        $products = $this->getProductData();
        $warehouses = $this->getWarehouses();

        return [
            ID::make()->sortable(),

            Select::make('Type')->options([
                'in' => 'In',
                'out' => 'Out',
            ])
                ->displayUsingLabels()
                ->required()
                ->sortable(),

            Select::make('Product', 'product_id')
                ->options($products)
                ->required()
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $request->product_id = $request->input('product_id');

                    return null;
                })->onlyOnForms(),

            Select::make('Warehouse', 'warehouse_id')
                ->options($warehouses)
                ->required()
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $request->warehouse_id = $request->input('warehouse_id');

                    return null;
                })->onlyOnForms(),

            Textarea::make('Description'),

            Number::make('Quantity')->sortable(),

            Select::make('Source')->options([
                'Supplier' => 'Supplier',
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
