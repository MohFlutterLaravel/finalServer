<?php

use Illuminate\Database\Seeder;
use App\Produit;
use Illuminate\Support\Str;
class ProduitSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Produit::class, 2000)->create();
    }
}
