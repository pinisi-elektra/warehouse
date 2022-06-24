<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    public function productTransactionVendors()
    {
        return $this->hasOne('App\Models\ProductTransactionVendor');
    }
}
