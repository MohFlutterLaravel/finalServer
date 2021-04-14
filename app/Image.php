<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $guarded = ['id'];
  protected $fillable = [
    'name', 'rank', 'produit_id'
  ];
  public function produit()
  {
      return $this->belongsTo('App\Produit');
  }
}
