<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionSales extends Model
{
    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function productTransaction() {
        return $this->belongsTo(ProductTransaction::class);
    }
}
