<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStockHistory extends Model
{
    protected $fillable = ['user_id', 'product_stock_id', 'description'];

    public function productStock() {
        return $this->belongsTo('App\Models\ProductStock');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
