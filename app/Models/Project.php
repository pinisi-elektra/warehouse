<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Project extends Model
{
    use BlameableTrait;

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function productStock() {
        return $this->hasMany('App\Models\ProductStock');
    }
}
