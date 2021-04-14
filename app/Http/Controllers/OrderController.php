<?php
/*
  readme:
  the order has 4 status :
  1--- new : the new order is the order that has not yet been dealt with
  2--- shipped : the shipped order is the order that was prepared and is now on the way
  3--- rejected : the rejected order is the order that was rejected by the customer for reasons explained by the driver
  4--- valide : the valide orfer is the order that was delivered successfully
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use DataTables;
use App\Client;
use App\Location;
class OrderController extends Controller
{
  public function getOrdersCount($status)
  {
    if ($status == 'all') {
      $orders = Order::count();
    }
    else {
      $orders = Order::where('status', $status)->get()->count();
    }

    return $orders;
  }


// all orders ///////////////////////////////////////////////////
  public function index()
  {
    $orders = $this->getOrdersCount('all');
    return view('manage-orders.lists.index', ['orders'=> $orders]);
  }
  public function ordersData()
  {
    $orders = Order::query();

    return DataTables::of($orders)
    ->addColumn('date', function(Order $orders) {
                    return  $orders->created_at->format('Y/M/d');
                  })
    ->addColumn('client', function(Order $orders) {
                    $location = $orders->location;
                    $client = $location->client;
                    return  $client->first_name;
                  })
    ->setRowId(function ($orders) {
                    return $orders->id;
                    })
    ->setRowAttr([
                   'data-target' => '#modal-default',
                   'data-toggle' => 'modal',
                ])
   ->setRowClass(function ($orders) {
                    if ($orders->status == 'valide') {
                      return 'table-success';
                    }
                    if ($orders->status == 'rejected') {
                      return 'table-danger';
                    }
                    if ($orders->status == 'new') {
                      return 'table-warning';
                    }
                    if ($orders->status == 'shipped') {
                      return 'table-primary';
                    }
              })
    ->make(true);
  }
  // new orders/////////////////////////////////////////////////////////
  public function new()
  {
    $orders = $this->getOrdersCount('new');
    return view('manage-orders.lists.new', ['orders'=> $orders]);
  }

  public function newOrdersData()
  {
    $orders = Order::where('status', 'new')->get();

    return DataTables::of($orders)
    ->addColumn('date', function(Order $orders) {
                    return  $orders->created_at->format('Y/M/d');
                  })
    ->addColumn('client', function(Order $orders) {
                    $location = $orders->location;
                    $client = $location->client;
                    return  $client->first_name;
                                })
    ->setRowId(function ($orders) {
                    return $orders->id;
                    })
    ->setRowAttr([
                   'data-target' => '#modal-default',
                   'data-toggle' => 'modal',
                ])
    ->make(true);

  }

  //shipped orders /////////////////////////////////////////////////////////
  public function shipped()
  {
    $orders = $this->getOrdersCount('shipped');
    return view('manage-orders.lists.shipped', ['orders'=> $orders]);
  }
  public function shippedOrdersData()
  {
    $orders = Order::where('status', 'shipped')->get();

    return DataTables::of($orders)
    ->addColumn('date', function(Order $orders) {
                    return  $orders->created_at->format('Y/M/d');
                  })
    ->addColumn('client', function(Order $orders) {
                    $location = $orders->location;
                    $client = $location->client;
                    return  $client->first_name;
                  })
    ->setRowId(function ($orders) {
                    return $orders->id;
                    })
    ->setRowAttr([
                   'data-target' => '#modal-default',
                   'data-toggle' => 'modal',
                ])
    ->make(true);

  }
// rejected orders /////////////////////////////////////////////
public function rejected()
{
  $orders = $this->getOrdersCount('rejected');
  return view('manage-orders.lists.rejected', ['orders'=> $orders]);
}
public function rejectedOrdersData()
{
  $orders = Order::where('status', 'rejected')->get();

  return DataTables::of($orders)
  ->addColumn('date', function(Order $orders) {
                  return  $orders->created_at->format('Y/M/d');
                })
  ->addColumn('client', function(Order $orders) {
                  $location = $orders->location;
                  $client = $location->client;
                  return  $client->first_name;
                })
  ->setRowId(function ($orders) {
                  return $orders->id;
                  })
  ->setRowAttr([
                 'data-target' => '#modal-default',
                 'data-toggle' => 'modal',
              ])
  ->make(true);

}

// valide orders ////////////////////////////////////////////
public function valide()
{
  $orders = $this->getOrdersCount('valide');
  return view('manage-orders.lists.valide', ['orders'=> $orders]);
}
public function valideOrdersData()
{
  $orders = Order::where('status', 'valide')->get();

  return DataTables::of($orders)
  ->addColumn('date', function(Order $orders) {
                  return  $orders->created_at->format('Y/M/d');
                })
  ->addColumn('client', function(Order $orders) {
                  $location = $orders->location;
                  $client = $location->client;
                  return  $client->first_name;
                })
  ->setRowId(function ($orders) {
                  return $orders->id;
                  })
  ->setRowAttr([
                 'data-target' => '#modal-default',
                 'data-toggle' => 'modal',
              ])
  ->make(true);

}

  // order Details
  public function details($id)
  {
    $order = Order::find($id);
    $produits = $order->produits;
    $location = $order->location;
    $client = Client::find($location->client_id);
    return view('manage-orders.details',[
              'order' => $order,
              'produits' => $produits,
              'location' => $location,
              'client' => $client
            ]
    );
  }
  /*////////////////////////////ApiRoute/////////////////////////////////////*/
  public function requestOrdersProvider(Request $request)
  {
    // start request data
    $clientId = $request->clientId;
    $locationId = $request->locationId;
    $produits = $request->produits;
    // end request data
    // start call functions
    $order = $this->addOrder($locationId);
    $this->attachOrderProduits($order, $produits);
    // end call functions

  }

  // add new orders
  public function addOrder($locationId)
  {
    $order = new Order;
    $order->location_id = $locationId;
    $order->status = 'new';
    $order->tarif_liv = 200; // temporary
    $order->total = 0;
    $order->save();
    /*
      Here we will add a tarif_liv amount depending on the location on the map in the future inchallah
    */
    return $order;

  }
  public function attachOrderProduits($order, $produits)
  {
    //$customer->drinks()->attach($drink_id, array('customer_got_drink', 1));
    //this executes the insert-query with customer_got_drink = 1
    foreach ($produits as $produit) {
      $order->produits()->attach($produit['id'], ['qte' =>  $produit['qte'] ]);
      $order->total += $produit['total'];
      $order->save();
    }
  }
  /*
  $client = Client::find($request->clientId);
  $location = Location::find($request->locationId);
  foreach ($request->produits as $produit) {
    return $produit['id'];
  }



  return response()->json([
    'client'=> $client,
    'location'=> $location,
    //'produits' : $produits
  ]);

  */
}
