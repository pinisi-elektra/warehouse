<?php

namespace App\Nova;

use App\Models\Company as Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Storable;
use Laravel\Nova\Fields\Text;

class Company extends Resource
{
    public static $model = Model::class;

    public static $title = 'name';

    public static $group = 'Company';

    public static $search = [
        ''
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Image::make('Logo')
                ->disk('public')
                ->maxWidth(50)
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
