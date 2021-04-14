<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Famille extends Model
{
  use SoftDeletes;
  protected $guarded = ['id'];
  protected $fillable = [
    'categorie_id', 'name'
  ];

  public function categorie()
  {
      return $this->belongsTo('App\Categorie');
  }
  public function marques()
  {
      return $this->hasMany('App\Marque');
  }
}
