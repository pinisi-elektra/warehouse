<?php

namespace App\Nova;

use App\Helpers\QuantityUnit;
use App\Models\ProductTransaction;
use App\Nova\Actions\ExportAllRecordToFile;
use App\Nova\Filters\FilterByDateEnd;
use App\Nova\Filters\FilterByDateStart;
use App\Nova\Filters\FilterByProject;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class StockTransfer extends Resource
{
    public static $model = ProductTransaction::class;

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    public static $group = 'Main Feature';

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas('productTransactionWarehouse');
    }

    public function fields(Request $request): array
    {
        if (!$request->count) $request->count = 0;

        return [
            Text::make('#', function () use ($request) {
                $request->count += 1;

                return $request->page == 1 ? $request->count : $request->count + ($request->perPage * ($request->page - 1));
            })->onlyOnIndex(),

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

            HasOne::make('Transaction Warehouse', 'productTransactionWarehouse', ProductTransactionWarehouse::class)
                ->canSee(function ($request) {
                    return is_null($this->model()->productTransactionVendors);
                })
                ->nullable(),

            HasMany::make('Transaction Shipping History', 'productTransactionShipping', ProductTransactionShipping::class)
                ->nullable(),

            DateTime::make('Created At'),
        ];
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [
            new FilterByProject(),
            new FilterByDateStart(),
            new FilterByDateEnd()
        ];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [
            ExportAllRecordToFile::make('Export All Stock Transfer Record to File')
                ->setRequest($request)
                ->setTransactionType('stock_transfer')
                ->standalone()
        ];
    }
}
