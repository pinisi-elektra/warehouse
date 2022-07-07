<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function productStock(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductStock::class);
    }
}
