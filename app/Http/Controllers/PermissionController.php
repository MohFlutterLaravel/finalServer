<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\PermissionRequest;
use Illuminate\Support\Facades\Hash;
use App\Catpermission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $catpermissions = Catpermission::all();
      /*foreach ($catpermissions as $catpermission) {
        foreach ($catpermission->permissions as $permission) {
          dd($permission->name);
        }
      }*/
      $permissions = Permission::all();
      return view('permissions.index', [ 'permissions' => $permissions, 'catpermissions' => $catpermissions ]);
    }
    /**
    * Display trashed roles
    */
    public function indexTrash()
    {
        $permissions = Permission::onlyTrashed()->get();
        return view('permissions.indexTrash', [ 'permissions' => $permissions ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catpermissions = Catpermission::all();
        return view('permissions.create', [ 'catpermissions' => $catpermissions ]);
    }

    public function restoreTrash($id)
    {
      $permissions = Permission::withTrashed()->find($id);
      $permissions->restore();
      return redirect()->route('permissions.index')
                       ->with('success',"Permission restored successfully");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
      //dd($request->input('permissions', []));
      //dd($request->input('role-name'));
      //dd($request->input('password'));
      //dd(auth()->user()->password);
    //  $password =  Hash::make($request->input('password'));
    //   dd(Hash::check($password, auth()->user()->password));
    //$role->syncPermissions($permissions);
      $permission = Permission::create(['name' => $request->input('permission-name'), 'catpermission_id' => $request->input('catpermission')]);
      $role = Role::findByName('admin');
      $role->givePermissionTo($permission->name);
      return redirect()->route('permissions.index')
                       ->with('success',"Permission created successfully");
    }

    public function storeBycategorie(PermissionRequest $request)
    {
      $catpermission = new Catpermission;
      $catpermission->name = $request->input('catpermission');
      $catpermission->save();
      $permission = Permission::create(['name' => $request->input('permission-name'), 'catpermission_id' => $catpermission->id]);
      $role = Role::findByName('admin');
      $role->givePermissionTo($permission->name);
      return redirect()->route('permissions.index')
                       ->with('success',"Permission created successfully");
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
        $permission = Permission::find($id);
        return view('permissions.edit', [ 'permission' => $permission ]);
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
        $permission = Permission::find($id);
        $permission->name = $request->input('permission-name');
        $permission->save();
        return redirect()->route('permissions.index')
                         ->with('success',"Permission updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permissions.index')
                         ->with('success',"Permission deleted successfully");
    }

    public function destroyTrash($id)
    {
      $permission = Permission::withTrashed()->find($id);
      $permission->forceDelete();
      return redirect()->route('permissions.index')
                       ->with('success',"Permission destroyed from the DB successfully");
    }
}
