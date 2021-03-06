<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'project_id',
    ];

    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function histories() {
        return $this->hasMany(ProductStockHistory::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
