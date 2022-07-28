<?php

namespace App\Services\Export;

use App\Models\ProductTransaction;
use Illuminate\Support\Arr;

class ProductTransactionExportPurchase extends ProductTransactionExportBase
{

    protected function getQuery(array $filter)
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

    protected function formatPurchaseData(ProductTransaction $productTransaction): array
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

}
