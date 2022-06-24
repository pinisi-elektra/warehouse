<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionVendor extends Model
{
    public const TYPE_PURCHASE = 'purchase';
    public const TYPE_RETURN = 'return';

    public function productTransaction() {
        return $this->belongsTo('App\Models\ProductTransaction');
    }
}
