<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class ProductTransaction extends Model
{
    use BlameableTrait;

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

    public function productTransactionWarehouse()
    {
        return $this->hasOne('App\Models\ProductTransactionWarehouse');
    }

    public function productTransactionSales() {
        return $this->hasOne('App\Models\ProductTransactionSales');
    }

    public function productTransactionShipping(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\ProductTransactionShipping');
    }

    public function project() {
        return $this->belongsTo('App\Models\Project');
    }
}
