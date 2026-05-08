<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customers extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'fullname',
        'gender',
        'phone_number',
        'email',
        'password',
        'address',
        'department',
        'grade_year',
        'program',
        'is_verified',
    ];

    protected $hidden = [
        'password',
    ];
}
