<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Famille;
use App\Categorie;
class FamilleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familles = Famille::all();
        return view('manage-products.familles.index', [ 'familles' => $familles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('manage-products.familles.create', [ 'categories' => $categories ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $famille = new Famille;
        $famille->name = $request->input('famille-name');
        $famille->categorie_id = $request->input('categorie');
        $famille->save();
        return redirect()->route('familles.index')
                         ->with('success',"Famille created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $famille = Famille::find($id);
      return response()->json([
        'name' => $famille->name,
        'date' => $famille->updated_at->format('date'),
        'marques' => $famille->marques
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
        $categories = Categorie::all();
        $famille = Famille::find($id);
        return view('manage-products.familles.edit', [ 'categories' => $categories, 'famille' => $famille ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $famille = Famille::find($id);
        $famille->name = $request->input('famille-name');
        $famille->categorie_id = $request->input('categorie');
        $famille->save();
        return redirect()->route('familles.index')
                         ->with('success',"Famille updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $famille = Famille::find($id);
        $famille->delete();
        return redirect()->route('familles.index')
                         ->with('success',"Famille deleted successfully");
    }
}
