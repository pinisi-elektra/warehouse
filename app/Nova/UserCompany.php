<?php

namespace App\Nova;

use App\Models\UserCompany as Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;

class UserCompany extends Resource
{
    public static $model = Model::class;

    public static $group = 'Company';

    public static $title = 'company.name';

    public static $search = [
        ''
    ];

    public static $displayInNavigation = false;

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('User'),

            BelongsTo::make('Company', 'company', 'App\Nova\Company')->showCreateRelationButton(),
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
