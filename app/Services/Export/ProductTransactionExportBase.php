<?php

namespace App\Services\Export;

use App\Exports\ProductTransactionExport;
use App\Models\ProductTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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

    public function export(Request $request) {
        $filter = [];

        if ($request->has('params')) {
            $decodedFilter = json_decode(base64_decode($request->get('params')), true);

            if (Arr::has($decodedFilter, '0.App\\Nova\\Filters\\FilterByProject')) {
                $filter['project_id'] = Arr::get($decodedFilter, '0.App\\Nova\\Filters\\FilterByProject');
                if ($filter['project_id'] == '') unset($filter['project_id']);
            }

            if (Arr::has($decodedFilter, '1.App\\Nova\\Filters\\FilterByDateStart')) {
                $filter['created_at'][0] = Arr::get($decodedFilter, '1.App\\Nova\\Filters\\FilterByDateStart');
                if ($filter['created_at'][0] == '') unset($filter['created_at']);
            }

            if (Arr::has($decodedFilter, '2.App\\Nova\\Filters\\FilterByDateEnd')) {
                $filter['created_at'][1] = Arr::get($decodedFilter, '2.App\\Nova\\Filters\\FilterByDateEnd');
                if ($filter['created_at'][1] == '') unset($filter['created_at']);
            }
        }

        $query = $this->getQuery($filter);

        $formattedData = $this->getPurchaseData($query);

        $time = Carbon::now()->toDateString();

        $fileName = "{$request->get('transaction_type', 'purchase')}_{$time}.{$request->get('file_type', 'csv')}";

        $headers = array_keys($formattedData[0]);

        return Excel::download(new ProductTransactionExport($formattedData, $headers), $fileName);
    }
}
