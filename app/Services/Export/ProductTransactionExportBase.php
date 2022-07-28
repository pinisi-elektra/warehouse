<?php

namespace App\Services\Export;

use App\Exports\ProductTransactionExport;
use App\Models\ProductTransaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Nova\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;

class ProductTransactionExportBase
{
    protected ProductTransactionExporter $productTransactionExporter;

    public function __construct(ProductTransactionExporter $productTransactionExporter)
    {
        $this->productTransactionExporter = $productTransactionExporter;
    }

    protected function getQuery(array $filter)
    {
        return [];
    }

    protected function formatPurchaseData(ProductTransaction $productTransaction): array
    {
        return [];
    }

    protected function getPurchaseData($query): array
    {
        $productTransactions = $query;

        $data = [];
        foreach ($productTransactions as $productTransaction) {
            $data[] = $this->formatPurchaseData($productTransaction);
        }

        return $data;
    }

    protected function checkFilter(Builder $query, array $filter): Builder
    {
        if (Arr::hasAny($filter, ['project_id', 'created_at'])) {
            if ($filter['created_at'][0] !== '') $query->whereDate('created_at', '>=', $filter['created_at'][0]);
            if ($filter['created_at'][1] !== '') $query->whereDate('created_at', '<=', $filter['created_at'][1]);

            $filter = Arr::except($filter, 'created_at');

            return $query->where($filter);
        }

        return $query;
    }

    public function export(Request $request)
    {
        $filter = [];

        if ($request->has('params')) {
            $decodedFilter = json_decode(base64_decode($request->get('params')), true);

            if (Arr::has($decodedFilter, '0.App\\Nova\\Filters\\FilterByProject')) {
                $filter['project_id'] = Arr::get($decodedFilter, '0.App\\Nova\\Filters\\FilterByProject');
                if ($filter['project_id'] == '') unset($filter['project_id']);
            }

            if (Arr::has($decodedFilter, '1.App\\Nova\\Filters\\FilterByDateStart')) {
                $filter['created_at'][0] = Arr::get($decodedFilter, '1.App\\Nova\\Filters\\FilterByDateStart');
            }

            if (Arr::has($decodedFilter, '2.App\\Nova\\Filters\\FilterByDateEnd')) {
                $filter['created_at'][1] = Arr::get($decodedFilter, '2.App\\Nova\\Filters\\FilterByDateEnd');
            }
        }

        $query = $this->getQuery($filter);

        $formattedData = $this->getPurchaseData($query);

        if (count($formattedData) == 0) {
            Log::warning('No data to export', ['filter' => $filter]);

            return redirect()
                ->back()
                ->with('error', 'No data found');
        }

        $time = Carbon::now()->toDateString();

        $fileName = "{$request->get('transaction_type', 'purchase')}_{$time}.{$request->get('file_type', 'csv')}";

        $headers = array_keys($formattedData[0]);

        return Excel::download(new ProductTransactionExport($formattedData, $headers), $fileName);
    }
}
