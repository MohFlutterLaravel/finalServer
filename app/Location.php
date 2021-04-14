<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
  use SoftDeletes;

  protected $fillable = [
       'title', 'lat', 'lang', 'client_id'
   ];

  public function client()
  {
      return $this->belongsTo('App\Client');
  }
  public function orders()
  {
      return $this->hasMany('App\Order');
  }
}
