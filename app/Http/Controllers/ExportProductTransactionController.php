<?php

namespace App\Http\Controllers;

use App\Exports\ProductTransactionExport;
use App\Models\ProductTransaction;
use App\Services\Export\ProductTransactionExporter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class ExportProductTransactionController extends Controller
{
    private ProductTransactionExporter $productTransactionExporter;

    public function __construct(ProductTransactionExporter $productTransactionExporter)
    {
        $this->productTransactionExporter = $productTransactionExporter;
    }

    private function getQuery(array $filter)
    {
        $query = ProductTransaction::query();

        if (Arr::hasAny($filter, ['project_id', 'created_at'])) {
            if (Arr::has($filter, 'created_at')) {
                $query->whereBetween('created_at', $filter['created_at']);

                $filter = Arr::except($filter, 'created_at');
            }

            $query->where($filter);
        }

        return $query
            ->whereHas('productTransactionVendors')
            ->with([
                'product',
                'warehouse',
                'productTransactionVendors.productVendor',
                'project'
            ])->get();
    }

    private function formatPurchaseData(ProductTransaction $productTransaction)
    {
        return [
            'Project Name' => $productTransaction->project->name,
            'Product Name' => "{$productTransaction->product->name} ({$productTransaction->product->model})",
            'Warehouse Name' => $productTransaction->warehouse->name,
            'Quantity' => $productTransaction->quantity,
            'Quantity Unit' => $productTransaction->quantity_volume,
            'Vendor Name' => $productTransaction->productTransactionVendors->productVendor->name,
            'Vendor Phone Number' => $productTransaction->productTransactionVendors->productVendor->phone,
            'Date' => $productTransaction->created_at,
        ];
    }

    public function getPurchaseData(array $filter): array
    {
        $productTransactions = $this->getQuery($filter);

        $data = [];
        foreach ($productTransactions as $productTransaction) {
            $data[] = $this->formatPurchaseData($productTransaction);
        }

        return $data;
    }


    public function __invoke(Request $request)
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
                if ($filter['created_at'][0] == '') unset($filter['created_at']);
            }

            if (Arr::has($decodedFilter, '2.App\\Nova\\Filters\\FilterByDateEnd')) {
                $filter['created_at'][1] = Arr::get($decodedFilter, '2.App\\Nova\\Filters\\FilterByDateEnd');
                if ($filter['created_at'][1] == '') unset($filter['created_at']);
            }

        }

        $formattedData = $this->getPurchaseData($filter);

        $time = Carbon::now()->toDateString();

        $fileName = "{$request->get('transaction_type', 'product_transaction')}_{$time}.{$request->get('file_type', 'csv')}";

        $headers = array_keys($formattedData[0]);

        return Excel::download(new ProductTransactionExport($formattedData, $headers), $fileName);
    }
}
