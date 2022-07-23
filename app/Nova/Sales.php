<?php

namespace App\Nova;

use App\Helpers\QuantityUnit;
use App\Helpers\RoleList;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionSales as ProductTransactionSalesModel;
use App\Nova\Filters\FilterByDateEnd;
use App\Nova\Filters\FilterByDateStart;
use App\Nova\Filters\FilterByProject;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Sales extends Resource
{
    public static $model = ProductTransaction::class;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas('productTransactionSales');
    }

    public static $group = 'Main Feature';

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

            HasOne::make('Sales Detail', 'productTransactionSales', ProductTransactionSales::class)
                ->canSee(function ($request) {
                    return true;
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
            (new DownloadExcel())
                ->askForWriterType()
                ->withHeadings()
                ->only(
                    'Project',
                    'Warehouse',
                    'Product',
                    'Quantity',
                    'Quantity Unit',
                    'created_at',
                )
        ];
    }
}
