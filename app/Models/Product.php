<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => "$this->name - $this->model",
        );
    }

    protected function nameWithDetails(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => "$this->name - $this->model (quantity in $this->quantity_unit)",
        );
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function productStock() {
        return $this->hasMany(ProductStock::class);
    }
}
