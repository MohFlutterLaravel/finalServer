<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Categorie\CategorieRequest;
use App\Categorie;
class CategorieController extends Controller
{
  public function test()
  {
    return 'test from api';
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $categories = Categorie::all();
         return view('manage-products.categories.index', [ 'categories' => $categories ]);
     }
     /* this function send categories to flutterApp */
     public function indexApi()
     {
       $categories = Categorie::all();
       foreach ($categories as $categorie) {
         $categorie->image = asset('/storage/images/'.$categorie->image);
       }
         return response()->json($categories, 200);
     }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-products.categories.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategorieRequest  $request
     * @return Response
     */
    public function store(CategorieRequest $request)
    {
        //get the get The Original Name of image
        $fileName =$request->file('categorie-image')->getClientOriginalName();

        $categorie = new Categorie;
        $categorie->name = $request->input('categorie-name');
        $categorie->color = $request->input('categorie-color');
        $categorie->image = $fileName;
        $request->file('categorie-image')->storeAs('images', $fileName, 'public');
        $categorie->save();
        return redirect()->route('categories.index')
                         ->with('success',"Categorie created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $categorie = Categorie::find($id);
      return response()->json([
        'name' => $categorie->name,
        'date' => $categorie->updated_at->format('date'),
        'familles' => $categorie->familles
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categorie = Categorie::find($id);
        return view('manage-products.categories.edit', [ 'categorie' => $categorie ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategorieRequest $request, $id)
    {
        $fileName =$request->file('categorie-image')->getClientOriginalName();
        $categorie = Categorie::find($id);
        $categorie->name = $request->input('categorie-name');
        $categorie->color = $request->input('categorie-color');

        if ($categorie->image) {
          Storage::delete('/public/images/'.$categorie->image);
        }
        $categorie->image = $fileName;
        $request->file('categorie-image')->storeAs('images', $fileName, 'public');
        $categorie->save();
        return redirect()->route('categories.index')
                         ->with('success',"Categorie updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorie = Categorie::find($id);
        $categorie->delete();
        return redirect()->route('categories.index')
                         ->with('success',"Categorie updated successfully");
    }
}
