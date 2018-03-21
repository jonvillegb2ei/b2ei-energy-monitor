<?php

namespace App\Models;

use App\Traits\TimestampedModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, TimestampedModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname', 'firstname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $dates = ['created_at', 'edited_at'];

    protected $casts = [
        'administrator' => 'boolean',
    ];

    public function getFullnameAttribute()
    {
        return sprintf("%s %s", strtoupper($this->lastname), ucfirst($this->firstname));
    }
}

