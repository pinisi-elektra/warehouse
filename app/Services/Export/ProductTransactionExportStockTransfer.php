<?php

namespace App\Services\Export;

use App\Models\ProductTransaction;
use Illuminate\Support\Arr;

class ProductTransactionExportStockTransfer extends ProductTransactionExportBase
{

    protected function getQuery(array $filter)
    {
        $query = ProductTransaction::query();

        $query = $this->checkFilter($query, $filter);

        return $query
            ->whereHas('productTransactionWarehouse')
            ->with([
                'product',
                'warehouse',
                'productTransactionWarehouse.warehouse',
                'project'
            ])->get();
    }

    protected function formatPurchaseData(ProductTransaction $productTransaction): array
    {
        return [
            'Project Name' => $productTransaction->project->name,
            'Product Name' => "{$productTransaction->product->name} ({$productTransaction->product->model})",
            'Warehouse Name' => $productTransaction->warehouse->name,
            'Quantity' => $productTransaction->quantity,
            'Quantity Unit' => $productTransaction->quantity_volume,
            'Destination Warehouse' => $productTransaction->productTransactionWarehouse->warehouse->name,
            'Status' => $productTransaction->productTransactionWarehouse->status,
            'Date' => $productTransaction->created_at,
        ];
    }


}
