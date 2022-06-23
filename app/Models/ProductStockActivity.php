<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockActivity extends Model
{
    protected $fillable = [
        'source',
        'source_name',
        'source_external_id',
        'product_stock_id',
        'description',
        'user_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
    ];

    public function product() {
        return $this->morphTo(Product::class, 'product');
    }

    public function productStock() {
        return $this->belongsTo(ProductStock::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
