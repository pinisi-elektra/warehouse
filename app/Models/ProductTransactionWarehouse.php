<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionWarehouse extends Model
{
    const TYPE_IN = 'in';
    const TYPE_OUT = 'out';

    protected $fillable = ['status'];

    public function productTransaction()
    {
        return $this->belongsTo(ProductTransaction::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function getDestinationWarehouseNameAttribute(): string
    {
        if ($this->warehouse()->exists()) return $this->warehouse->name;

        return "";
    }
}
