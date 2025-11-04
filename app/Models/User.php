<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name','email','password','role'];
    protected $hidden = ['password','remember_token'];

    // Laravel 10+ esetén hasznos: automatikus hash (ha nincs, használd bcrypt-et a controllerben)
    protected function password(): Attribute {
        return Attribute::make(
            set: fn ($value) => bcrypt($value)
        );
    }

    // Kényelmi metódusok
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isUser(): bool  { return $this->role === 'user'; }
}
