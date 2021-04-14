<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//***********************************************************************************************************
// uses 'auth' and role middleware plus all middleware from $middlewareGroups['web']
Route::group(['middleware' => ['auth', 'web', 'role:admin']], function() {

  // Manage roles routes for admin user
  Route::delete('roles/trash/destroy/{role}', 'RoleController@destroyTrash')->name('roles.trash.destroy');
  Route::put('roles/trash/restore/{role}', 'RoleController@restoreTrash')->name('roles.trash.restore');
  Route::get('roles/trash', 'RoleController@indexTrash')->name('roles.trash');
  Route::resource('roles', 'RoleController');

  // Manage permissions routes for admin user
      //Manage permissions trash
      Route::delete('permissions/trash/destroy/{permission}', 'PermissionController@destroyTrash')->name('permissions.trash.destroy');
      Route::put('permissions/trash/restore/{permission}', 'PermissionController@restoreTrash')->name('permissions.trash.restore');
      Route::get('permissions/trash', 'PermissionController@indexTrash')->name('permissions.trash');
      //create permissions and his Categorie
      Route::post('permissions/categories', 'PermissionController@storeBycategorie')->name('permissions.storeBycategorie');

  Route::resource('permissions', 'PermissionController');


});
//**********************************************************************************************************

// uses 'auth' and permission middleware plus all middleware from $middlewareGroups['web']
Route::group(['middleware' => ['auth', 'web']], function() {
  /* categories routes */
  Route::resource('categories', 'CategorieController');
  /* familles routes */
  Route::resource('familles', 'FamilleController');
  /* marques routes */
  Route::get('marques/getMarques/{id}', 'MarqueController@getMarque');
  Route::resource('marques', 'MarqueController');
  /* produits routes */
  Route::delete('/produits/img/delete','ProduitController@DeleteImgProduit');
  Route::post('/produits/img/new','ProduitController@AddImgProduit')->name('produits.img.new');
  Route::put('/produits/img/{id}','ProduitController@UpdateImgProduit')->name('produits.img.update');
  Route::get('/produits/img/{id}/edit','ProduitController@EditImgProduit')->name('produits.img.edit');
  Route::get('getproduit/{id}','ProduitController@getproduit');
  Route::get('get-produits-data', 'ProduitController@produitsData')->name('datatables.produits');
  Route::resource('produits', 'ProduitController');
  /* clients routes */
  Route::get('clients/count', 'ClientPanelController@getClientCount');
  Route::get('clients', 'ClientPanelController@index')->name('clients.index');
  Route::get('get-clients-data', 'ClientPanelController@clientsData')->name('datatables.clients');
  Route::get('clients/{id}', 'ClientPanelController@show')->name('clients.show');
  Route::delete('clients/{id}', 'ClientPanelController@delete');
  /* orders routes */
  // datatable
  Route::get('datatables/orders', 'OrderController@ordersData')->name('datatables.orders');
  Route::get('datatables/orders/new', 'OrderController@newOrdersData')->name('datatables.orders.new');
  Route::get('datatables/orders/shipped', 'OrderController@shippedOrdersData')->name('datatables.orders.shipped');
  Route::get('datatables/orders/rejected', 'OrderController@rejectedOrdersData')->name('datatables.orders.rejected');
  Route::get('datatables/orders/valide', 'OrderController@valideOrdersData')->name('datatables.orders.valide');
  // lists
  Route::get('orders', 'OrderController@index')->name('orders.index');
  Route::get('orders/new', 'OrderController@new')->name('orders.new');
  Route::get('orders/shipped', 'OrderController@shipped')->name('orders.shipped');
  Route::get('orders/valide', 'OrderController@valide')->name('orders.valide');
  Route::get('orders/rejected', 'OrderController@rejected')->name('orders.rejected');
  // details
  Route::get('orders/details/{id}', 'OrderController@details')->name('orders.details');
  Route::get('orders/count/{status}', 'OrderController@getOrdersCount');
});

Route::get('test','RoleController@test');

Route::get('design',function(){
  return view('pages.charts.chartjs');
});
