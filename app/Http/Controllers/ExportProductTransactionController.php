<?php

namespace App\Http\Controllers;

use App\Services\Export\ProductTransactionExportRoute;
use Illuminate\Http\Request;

class ExportProductTransactionController extends Controller
{
    private ProductTransactionExportRoute $productTransactionExportRoute;

    public function __construct(ProductTransactionExportRoute $productTransactionExportRoute)
    {
        $this->productTransactionExportRoute = $productTransactionExportRoute;
    }

    public function __invoke(Request $request)
    {
        return $this
            ->productTransactionExportRoute
            ->handle($request);
    }
}
