<?php

namespace App\Nova;

use App\Models\Project as ProjectModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Project extends Resource
{
    public static $model = ProjectModel::class;

    public static $title = 'name';

    public static $group = 'Company';

    public static $displayInNavigation = false;

    public static $search = [
        ''
    ];


    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->required(),
            Textarea::make('Description')->nullable(),
            BelongsTo::make('Company')->required()
                ->showCreateRelationButton()
                ->searchable(),
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
