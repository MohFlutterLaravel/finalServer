<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = [
      'status', 'tarif_liv', 'total'
    ];

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function produits()
    {
        return $this->belongsToMany('App\Produit')
        ->withPivot('qte', 'is_paid')
        ->withTimestamps();
    }
}
