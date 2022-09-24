<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Authorizable;

    protected $fillable = [
        'id',
        'name',
        'iin',
        'phone',
        'email',
        'password',
        'photo_path',
    ];

    protected $hidden = [
        'password',
        'email_verified_at',
        'remember_token',
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
