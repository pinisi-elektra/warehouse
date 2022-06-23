<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCompanyGroup extends Model
{
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function companyGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\CompanyGroup');
    }
}
