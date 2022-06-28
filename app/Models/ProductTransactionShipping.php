<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionShipping extends Model
{
    protected $fillable = [
        'photo_evidence',
        'date_shipped',
    ];

    protected $casts = [
        'date_shipped' => 'datetime',
    ];

    public function productTransaction()
    {
        return $this->belongsTo('App\Models\ProductTransaction');
    }
}
