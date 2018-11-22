<?php

namespace Stock\User\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserEntity extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    
    protected $fillable = [
        'name', 'email', 'password','api_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
