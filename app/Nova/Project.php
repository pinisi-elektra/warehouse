<?php

namespace App\Nova;

use App\Models\Project as ProjectModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Project extends Resource
{
    public static $model = ProjectModel::class;

    public static $title = 'name';

    public static $group = 'Master Data';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        if (!$request->count) $request->count = 0;

        return [
            Text::make('#', function () use ($request) {
                $request->count += 1;

                return $request->page == 1 ? $request->count : $request->count + ($request->perPage * ($request->page - 1));
            })->onlyOnIndex(),

            Text::make('Name')->rules('required'),

            Textarea::make('Description')->nullable(),

            BelongsTo::make('Company')
                ->rules('required')
                ->showCreateRelationButton()
                ->searchable(),

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
