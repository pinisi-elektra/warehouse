<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Znck\Eloquent\Traits\BelongsToThrough;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, BelongsToThrough;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userRole()
    {
        return $this->hasOne(UserRole::class);
    }

    public function isRoleMatch(string $roleName): bool
    {
        if (is_null($this->userRole->role->name)) return false;

        return $this->userRole->role->name == $roleName;
    }

    public function company()
    {
        return $this->belongsToMany(Company::class, UserCompany::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, UserRole::class);
    }
}
