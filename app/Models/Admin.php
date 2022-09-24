<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_JURY = 'JURY';

    protected $fillable = [
        'id',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getRole() : string
    {
        switch ($this->status) {
            case self::ROLE_ADMIN:
                return 'Администратор';
                break;
            case self::ROLE_JURY:
                return 'Жюри';
                break;
            default:
                return '';
                break;
        }
    }

    public function offers()
    {
        return $this->hasManyThrough(Offer::class);
    }
}
