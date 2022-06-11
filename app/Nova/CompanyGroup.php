<?php

namespace App\Nova;

use App\Models\CompanyGroup as CompanyGroupModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class CompanyGroup extends Resource
{
    public static $model = CompanyGroupModel::class;

    public static $title = 'name';

    public static $group = 'Company';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')
                ->required()
                ->sortable(),
            BelongsTo::make('Company')
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
