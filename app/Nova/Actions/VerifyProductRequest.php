<?php

namespace App\Nova\Actions;

use App\Services\ProductRequest\MarkProductRequestVerified;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class VerifyProductRequest extends Action
{
    use InteractsWithQueue, Queueable;

    private MarkProductRequestVerified $markProductRequestVerified;

    public function __construct()
    {
        $this->markProductRequestVerified = new MarkProductRequestVerified();
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     * @throws \Exception
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $this->markProductRequestVerified->handle($model);
        }

        return Action::message('Verify product request success!');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
