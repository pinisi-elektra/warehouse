<?php

namespace App\Services\Export;

use Exception;
use Illuminate\Http\Request;

class ProductTransactionExportRoute
{
    protected ProductTransactionExporter $productTransactionExporter;

    public function __construct(ProductTransactionExporter $productTransactionExporter)
    {
        $this->productTransactionExporter = $productTransactionExporter;
    }

    /**
     * @throws Exception
     */
    private function defaultRoute()
    {
        throw new Exception('Not implemented');
    }

    /**
     * @throws Exception
     */
    public function handle(Request $request)
    {
        return match ($request->get('transaction_type')) {
            'purchase' => (new ProductTransactionExportPurchase($this->productTransactionExporter))->export($request),
            'stock_transfer' => (new ProductTransactionExportStockTransfer($this->productTransactionExporter))->export($request),
            'sales' => (new ProductTransactionExportSales($this->productTransactionExporter))->export($request),
            default => $this->defaultRoute(),
        };
    }
}
