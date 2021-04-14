<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
class Marque extends Model
{
  use SoftDeletes, HasTranslations;
  protected $guarded = ['id'];
  protected $fillable = [
    'famille_id', 'name'
  ];
  public $translatable = ['name'];

  public function famille()
  {
      return $this->belongsTo('App\Famille');
  }



  public function produits()
  {
      return $this->hasMany('App\Produit');
  }
}
