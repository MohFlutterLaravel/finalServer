<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
      'marque_id', 'name', 'description', 'pa', 'pv', 'remise'
    ];
    public $translatable = ['name', 'description'];

    public function marque()
    {
        return $this->belongsTo('App\Marque');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order')
        ->withPivot('qte', 'is_paid')
        ->withTimestamps();
    }
}
