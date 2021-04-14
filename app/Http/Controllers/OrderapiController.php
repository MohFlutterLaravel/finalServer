<?php
/*
  readme: The order delivery time is between two times ex: < 09:00 -- 10:00 >
  times:
    pm:
    < 09:00 -- 10:00 >
    < 10:00 -- 11:00 >
    < 11:00 -- 12:00 >
    am:
    < 14:00 -- 15:00 >
    < 15:00 -- 16:00 >
    < 16:00 -- 17:00 >
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
class OrderapiController extends Controller
{
  public function __construct()
  {
      // We set the guard api as default driver
      auth()->setDefaultDriver('client_api');
  }
/*
 this function recive the http data request and provide them to another functions
*/
  public function requestOrdersProvider(Request $request)
  {
    // start request data
    $time_liv = $request->time_liv;
    $clientId = $request->clientId;
    $locationId = $request->locationId;
    $produits = $request->produits;
    // end request data

    // start call functions
    $order = $this->addOrder($locationId, $time_liv);
    $this->attachOrderProduits($order, $produits);
    // end call functions
    return response()->json([
      'order'=> $order->id,
      'Status'=> 'successs'
    ]);
  }

  // add new orders
  public function addOrder($locationId, $time_liv)
  {
    $order = new Order;
    $order->location_id = $locationId;
    $order->status = 'new';
    $order->tarif_liv = 200; // temporary
    $order->liv_time = $time_liv;
    $order->total = 0;
    $order->save();
    /*
      Here we will add a tarif_liv amount depending on the location on Google map inchallah
    */
    return $order;

  }

  //  attach order with products
  public function attachOrderProduits($order, $produits)
  {
    foreach ($produits as $produit) {
      $order->produits()->attach($produit['id'], ['qte' =>  $produit['qte'] ]);
      $order->total += $produit['total'];
      $order->save();
    }
  }
}
