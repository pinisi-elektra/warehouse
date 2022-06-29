<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class ProductTransactionShipping extends Model
{
    use BlameableTrait;

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
