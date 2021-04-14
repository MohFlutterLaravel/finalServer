<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Client extends Authenticatable implements JWTSubject
{

  use SoftDeletes;

  protected $fillable = [
       'first_name', 'last_name', 'password', 'gender', 'birthday', 'phone_number', 'address', 'email'
   ];

   public function locations()
   {
       return $this->hasMany('App\Location');
   }
   public function orders()
    {
        return $this->hasManyThrough('App\Order', 'App\Location');
    }
/*
/--------------------------------------------------
/     JWT methods
/--------------------------------------------------
*/
      public function getJWTIdentifier()
      {
          return $this->getKey();
      }

      public function getJWTCustomClaims()
      {
        return [];
      }
//--------------------------------------------------

}
