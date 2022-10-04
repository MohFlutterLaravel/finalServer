<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produit;
use Faker\Generator as Faker;

$factory->define(Produit::class, function (Faker $faker) {
    return [
      'marque_id' => $faker->numberBetween($min = 1, $max = 1),
      'name' => $faker->name,
      'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
      'pa' => $faker->buildingNumber,
      'pv' => $faker->buildingNumber,
      'remise' => $faker->numberBetween($min = 1, $max = 50),
      'active' => $faker->numberBetween($min = 0, $max = 1)
    ];
});
