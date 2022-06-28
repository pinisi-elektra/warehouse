<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionShipping extends Model
{
    public function productTransaction()
    {
        return $this->belongsTo('App\Models\ProductTransaction');
    }
}
