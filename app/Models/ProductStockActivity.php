<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockActivity extends Model
{
    protected $fillable = ['source', 'source_name', 'product_stock_id', 'description', 'user_id', 'type'];

    public function productStock() {
        return $this->belongsTo(ProductStock::class);
    }
}
