<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionWarehouse extends Model
{
    const TYPE_IN = 'in';
    const TYPE_OUT = 'out';

    public function productTransaction()
    {
        return $this->belongsTo(ProductTransaction::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
