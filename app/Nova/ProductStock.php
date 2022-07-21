<?php

namespace App\Nova;

use App\Models\ProductStock as ProductStockModel;
use App\Nova\Filters\FilterByDateEnd;
use App\Nova\Filters\FilterByDateStart;
use App\Nova\Filters\FilterByProject;
use App\Nova\Filters\FilterByWarehouse;
use App\Nova\Metrics\NewProductStock;
use App\Nova\Metrics\ProductStockPerWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ProductStock extends Resource
{
    public static $model = ProductStockModel::class;

    public static $title = 'product.name';

    public static $group = 'Master Data';

    public static $search = [
        'id'
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        //
    }

    public function fields(Request $request): array
    {
        if (!$request->count) $request->count = 0;

        return [
            Text::make('#', function () use ($request) {
                $request->count += 1;

                return $request->page == 1 ? $request->count : $request->count + ($request->perPage * ($request->page - 1));
            })->onlyOnIndex(),

            BelongsTo::make('Product'),

            BelongsTo::make('Project'),

            BelongsTo::make('Warehouse'),

            HasMany::make('Histories', 'histories', ProductStockHistory::class),

            Number::make('Quantity')
                ->hideWhenUpdating()
                ->sortable(),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            new ProductStockPerWarehouse()
        ];
    }

    public function filters(Request $request): array
    {
        return [
            new FilterByProject(),
            new FilterByWarehouse(),
        ];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [
            new DownloadExcel()
        ];
    }
}
