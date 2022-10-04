<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\ProduitRequest;
use App\Produit;
use App\Image;
use App\Categorie;
use DataTables;
class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $produits = Produit::count();
      return view('manage-products.produits.index', ['produits'=> $produits]);
    }
    public function produitsData()
    {
      $produits = Produit::query();

    return DataTables::of($produits)
    ->addColumn('marque', function(Produit $produit) {
                    return  $produit->marque->name;
                })
    ->setRowId(function ($produit) {
                    return $produit->id;
                })
    ->make(true);
        //return Datatables::of(Produit::query())->make(true);
      /*  $query = Produit::query();
        $table = Datatables::of($query->get());*/

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('manage-products.produits.create', [ 'categories' => $categories ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //get the get The Original Name of image
       $fileName =$request->file('product-image')->getClientOriginalName();

        $produit = new Produit;
        $produit->marque_id = $request->input('marque-id');
        $produit->name = $request->input('product-name');
        $produit->description = $request->input('product-description');
        $produit->pa = $request->input('product-pa');
        $produit->pv = $request->input('product-pv');
        $produit->remise = $request->input('product-re');
        // check value en-stock 1-> true / null->false
        if ($request->input('en-stock')) {
          $produit->active = 1;
        }else {
          $produit->active = 0;
        }
        $produit->save();
        $produit_id = $produit->id;
        $image = new Image;
        $image->name = $fileName;
        $image->rank = 1;
        $image->produit_id = $produit_id;
        $image->save();
        $request->file('product-image')->storeAs('images/produits', $fileName, 'public');
        return redirect()->route('produits.index')
                         ->with('success', "Produit created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $categories = Categorie::all();
      $produit = Produit::find($id);
      return view('manage-products.produits.edit', ['produit'=>$produit, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProduitRequest $request, $id)
    {

        $produit = Produit::find($id);
        $produit->marque_id = $request->input('marque-id');
        $produit->name = $request->input('product-name');
        $produit->description = $request->input('product-description');
        $produit->pa = $request->input('product-pa');
        $produit->pv = $request->input('product-pv');
        $produit->remise = $request->input('product-re');
        if ($request->input('en-stock')) {
          $produit->active = 1;
        }else {
          $produit->active = 0;
        }
        $produit->save();
        return redirect()->route('produits.index')
                         ->with('success', "Produit updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produit = Produit::find($id);
        $produit->delete();
        return redirect()->route('produits.index')
                         ->with('success', "Produit deleted successfully");
    }
    public function getproduit($id)
    {
      $produit = Produit::find($id);
      return response()->json([
        'images' => $produit->images,
      ]);

    }
    public function EditImgProduit($id)
    {
      $produit =Produit::find($id);
      return view('manage-products.produits.editImage', ['produit'=>$produit]);
    }
    public function UpdateImgProduit(Request $request, $id)
    {
      $image = Image::find($id);
      $oldrank = $image->rank;//1
      $image->rank = 0;
      $image->save();
      $image_sible = Image::where('produit_id', $request->input('product_id'))->where('rank', $request->input('rank'))->get();
      if (count($image_sible) > 0) {
        $image_sible[0]->rank = $oldrank;
        $image_sible[0]->save();
      }
      $image = Image::find($id);
      $image->rank = $request->input('rank');
      if ($request->hasFile('image')) {
        $fileName =$request->file('image')->getClientOriginalName();
        Storage::delete('/public/images/produits/'.$image->name);
        $image->name = $fileName;
        $request->file('image')->storeAs('images/produits', $fileName, 'public');
        $image->save();
        return redirect()->route('produits.img.edit',$image->produit->id)
                         ->with('success', "image  updated successfully");
      }
      $image->save();
      return redirect()->route('produits.img.edit',$image->produit->id)
      ->with('success', "image  updated successfully");

    }
    public function AddImgProduit(Request $request)
    {
      $validatedData = $request->validate([
        'add_img' => 'required|image'
    ]);
    $rank_conflit = null;
    $rank = null;
     $fileName =$request->file('add_img')->getClientOriginalName();
     $image_conflit = Image::where('produit_id', $request->input('produitID'))->where('name', $fileName)->first();
      $produit = Produit::find($request->input('produitID'));
      if ($image_conflit != null) {
        $rank_conflit = $image_conflit->rank;
        $image_conflit->forceDelete();
      }
      if ($rank_conflit != null) {
        $rank = $rank_conflit;
      }else {
        $rank = count($produit->images) + 1;
      }
      $image = new Image;
      $image->name = $fileName;
      $image->rank = $rank;
      $image->produit_id = $request->input('produitID');
      $image->save();
      $request->file('add_img')->storeAs('images/produits', $fileName, 'public');
      return redirect()->route('produits.img.edit',$produit->id)
                       ->with('success', "image created successfully");
    }

    public function DeleteImgProduit( Request $request)
    {
      $image = Image::find($request->id); // find the image we will delete
      $deletedImageProduct_id = $image->produit_id; // find the id_produit of the image we will delete
      $deletedImageRank = $image->rank; // find the rank of the image we will delete
      Storage::delete('/public/images/produits/'.$image->name);
      $image->delete();
      $images = Image::where('produit_id',$deletedImageProduct_id )->get();  //find all images of the same produit_id of the image we will delete
      foreach ($images as $image) {
        if ($image->rank == $deletedImageRank+1 ) {
          $image->rank = $deletedImageRank;
          $deletedImageRank++;
          $image->save();
        }

      }
      return response()->json([
        'success' => true
      ]);
    }
}
