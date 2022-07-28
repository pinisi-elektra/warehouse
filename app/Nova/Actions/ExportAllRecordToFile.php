<?php

namespace App\Nova\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\DecodesFilters;
use Laravel\Nova\Http\Requests\NovaRequest;

class ExportAllRecordToFile extends Action
{
    private Request $request;
    private string $transactionType;

    public function setRequest(Request $request) {
        $this->request = $request;

        return $this;
    }

    public function setTransactionType(string $transactionType) {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        return Action::redirect(route('export.product-transactions', [
            'file_type' => $fields->get('file_type'),
            'transaction_type' => $this->transactionType,
            'params' => $this->request->get('filters')
        ]));
    }

    /**
     * Get the fields available on the action.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('File Type')->options([
                'csv' => 'CSV',
                'xls' => 'XLS',
                'xlsx' => 'XLSX',
            ])->displayUsingLabels()->required(),
        ];
    }
}
