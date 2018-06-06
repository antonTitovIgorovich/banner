<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $status
 */
class User extends Authenticatable
{
    use Notifiable;

    const STATUS_ACTIVE = 'active';
    const STATUS_WAIT = 'wait';

    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
