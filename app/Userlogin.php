<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Userlogin extends Authenticatable
{
    use Notifiable;

    protected $table = 'userlogins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name','email', 'user_password', 'status', 'usertype',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
    ];


    public function getAuthPassword()
    {
      return $this->user_password;
    }
}