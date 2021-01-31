<?php


namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends Eloquent implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name', 'username', 'role'
    ];

    protected $hidden = [
        'password',
    ];

    protected $primaryKey ='username';


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
