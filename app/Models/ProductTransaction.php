<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    protected $with = ['productTransactionWarehouse'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    public function productTransactionVendors(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\ProductTransactionVendor');
    }

    public function productTransactionWarehouse(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\ProductTransactionWarehouse');
    }

    public function productTransactionShipping() {
        return $this->hasOne('App\Models\ProductTransactionShipping');
    }
}
