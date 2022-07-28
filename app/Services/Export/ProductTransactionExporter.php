<?php

namespace App\Services\Export;

use App\Exports\ProductTransactionExport;
use App\Models\ProductTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ProductTransactionExporter
{
    private string $fileName;
    private Request $request;
    private array $data;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getFileName(string $fileName): string
    {
        $time = Carbon::now()->toDateString();

        return "{$this->request->get('transaction_type', 'product_transaction')}_{$time}.{$this->request->get('file_type', 'csv')}";
    }

    public function getPurchaseData(Collection $productTransactions): array
    {
        $data = [];
        foreach ($productTransactions as $productTransaction) {
            $data[] = $this->formatPurchaseData($productTransaction);
        }

        return $data;
    }

    public function getHeader(): array
    {
        return array_keys($this->data[0]);
    }

    public function export()
    {
        $records = $this->getQuery($this->productTransaction);

        foreach ($records as $key => $record) {
            $this->data[] = $this->mapData($key, $record);
        }

        return Excel::download(new ProductTransactionExport($this->data, $this->getHeader()), $this->getFileName());
    }
}
