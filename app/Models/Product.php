<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function productStock() {
        return $this->hasMany(ProductStock::class);
    }
}
