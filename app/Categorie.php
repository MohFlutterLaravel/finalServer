<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Categorie extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
      'name', 'color', 'image'
    ];

    public function familles()
    {
        return $this->hasMany('App\Famille');
    }
}
