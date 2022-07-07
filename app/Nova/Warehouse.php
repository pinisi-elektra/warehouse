<?php

namespace App\Nova;

use App\Helpers\RoleList;
use App\Models\Warehouse as WarehouseModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Warehouse extends Resource
{
    public static $model = WarehouseModel::class;

    public static $title = 'name';

    public static $group = 'Master Data';

    public static $search = [
        'name'
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->rules('required')
                ->sortable(),

            Text::make('Address'),

            BelongsTo::make('Company Group'),

            HasMany::make('Product Stock', 'productStock'),
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
