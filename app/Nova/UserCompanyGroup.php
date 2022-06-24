<?php

namespace App\Nova;

use App\Models\UserCompanyGroup as UserCompanyGroupModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;

class UserCompanyGroup extends Resource
{
    public static $model = UserCompanyGroupModel::class;

    public static $title = 'id';
    
    public static $group = 'Company';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('User'),
            BelongsTo::make('Company Group', 'companyGroup'),
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
