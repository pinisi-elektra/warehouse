<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Company extends Model
{
    use BlameableTrait;

    protected $fillable = ['name', 'logo'];

    public function projects() {
        return $this->hasMany('App\Models\Project');
    }
}
