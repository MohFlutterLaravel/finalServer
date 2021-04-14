<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\MarqueRequest;
use App\Marque;
use App\Famille;
use App\Categorie;
class MarqueController extends Controller
{
  public function test()
  {
    $marques = Marque::all();
    return response()->json(['code' => 200, 'data' => ['marques' => $marques]]);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $marques = Marque::all();
         $categories = Categorie::all();
         return view ('manage-products.marques.index', [ 'marques' => $marques, 'categories' => $categories ]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('manage-products.marques.create', [ 'categories' => $categories ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarqueRequest $request)
    {
        $marque = new Marque;
        $marque->famille_id = $request->input('famille');
        $marque
        ->setTranslation('name', 'en',$request->input('marque-name-en'))
        ->setTranslation('name', 'ar',$request->input('marque-name-ar'))
        ->save();
        return redirect()->route('marques.index')
                         ->with('success', "Famille created successfully");
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
      $marque = Marque::find($id);
      $categories = Categorie::all();
      return view('manage-products.marques.edit', [ 'categories' => $categories , 'marque' => $marque]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MarqueRequest $request, $id)
    {
      $marque = Marque::find($id);
      $marque->name = $request->input('marque-name');
      $marque->famille_id = $request->input('famille');
      $marque->save();
      return redirect()->route('marques.index')
                       ->with('success', "Famille updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marque = Marque::find($id);
        $marque->delete();
        return redirect()->route('marques.index')
                         ->with('success', "Famille deleted successfully");
    }
    public function getMarque($id)
    {
      $famille = Famille::find($id);
      $marques = $famille->marques;
      return response()->json([
        'marques' => $marques
      ]);
    }
}
