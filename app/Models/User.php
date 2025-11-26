<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // penting
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Method untuk cek apakah user admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
