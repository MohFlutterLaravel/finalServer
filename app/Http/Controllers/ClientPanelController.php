<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use DataTables;
class ClientPanelController extends Controller
{
    public function index()
    {
      $clients = $this->getClientCount();
      return view('manage-clients.index', ['clients'=> $clients]);
    }
    public function getClientCount()
    {
      $clients = Client::count();
      return $clients;
    }
    public function clientsData()
    {
      $clients = Client::query();

    return DataTables::of($clients)
    ->addColumn('created_at', function(Client $clients) {
                    return  $clients->created_at->diffForHumans();
                })
    ->setRowId(function ($clients) {
                    return $clients->id;
                })
    ->setRowAttr([
                   'data-target' => '#modal-default',
                   'data-toggle' => 'modal',
                ])
    ->make(true);
        //return Datatables::of(Produit::query())->make(true);
      /*  $query = Produit::query();
        $table = Datatables::of($query->get());*/

    }
    public function show($id)
    {
      $client = Client::find($id);
      $orders = $client->orders;
      $rejected_orders = $orders->where('status', 'rejected')->count();
      $valide_orders = $orders->where('status', 'valide')->count();
      $cours_orders = $orders->where('status', 'shipped')->count();
      $attend_orders = $orders->where('status', 'new')->count();
      return view('manage-clients.show',
       [
         'client' => $client,
         'rejected_orders' => $rejected_orders,
         'valide_orders'=> $valide_orders,
         'cours_orders'=> $cours_orders,
         'attend_orders' => $attend_orders
       ]);
    }

    public function delete($id)
    {
      dd('delete');
    }

}
