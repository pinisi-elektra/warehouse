<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductTransactionExport implements FromArray, WithHeadings
{
    protected array $productTransactions;
    protected array $headers;

    public function __construct(array $productTransactions, array $headers)
    {
        $this->productTransactions = $productTransactions;
        $this->headers = $headers;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function array(): array
    {
        return $this->productTransactions;
    }
}
