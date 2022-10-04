<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Hash;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function test()
     {
       /*$user = auth()->user();
       $role = Role::create(['name' => 'admin']);
       $user->assignRole('admin');*/
       return response()->json([
         'name' => 'moh'
       ]);

     }
     public function index()
     {
         $roles = Role::all();
         return view('roles.index', [ 'roles' => $roles ]);
     }
     /**
     * Display trashed roles
     */
     public function indexTrash()
     {
         $roles = Role::onlyTrashed()->get();
         return view('roles.indexTrash', [ 'roles' => $roles ]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $permissions = Permission::all();
        return view('roles.create', [ 'permissions' => $permissions ]);
    }


   public function restoreTrash($id)
   {
     $role = Role::withTrashed()->find($id);
     $role->restore();
     return redirect()->route('roles.index')
                      ->with('success',"Role restored successfully");
   }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
      $password = $request->input('password');
      $user = auth()->user();
        //dd($request->input('permissions', []));
        //dd($request->input('role-name'));
        //dd($request->input('password'));
        //dd(auth()->user()->password);
      //  $password =  Hash::make($request->input('password'));
      //   dd(Hash::check($password, auth()->user()->password));
      if (Hash::check($password, $user->password)) {
        $permissions = $request->input('permissions', []);
        $role = Role::create(['name' => $request->input('role-name')]);
        $role->syncPermissions($permissions);
        return redirect()->route('roles.index')
                         ->with('success',"Role created successfully");
      }
      return redirect()->back()->with('success',"Password not related !");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $role = Role::find($id);
      return response()->json([
        'name' => $role->name,
        'guard' => $role->guard_name,
        'date' => $role->updated_at->format('date'),
        'permissions' => $role->getPermissionNames()
      ]);
      /*
      $role = Role::find($id);
      return response()->json([
        'name' => $role->name,
        'guard' => $role->guard_name,
        'date' => $role->updated_at->format('date'),
        'permissions' => $role->getPermissionNames()
      ]);
      */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $role = Role::find($id);
      $permissions = Permission::all();
      return view('roles.edit', [ 'role' => $role, 'permissions' => $permissions ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request ,$id)
    {
      $role = Role::find($id);
      $role->name = $request->input('role-name');

      if ($request->has('permissions')) {
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);
      }elseif ($request->has('add_permissions')) {
        $permissions = $request->input('add_permissions', []);
        $role->givePermissionTo($permissions);
      }

      $role->save();
      return redirect()->route('roles.index')
                       ->with('success',"Role updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findById($id);
        $role->delete();
        return redirect()->route('roles.index')
                         ->with('success',"Role deleted successfully");
    }
    public function destroyTrash($id)
    {
      $role = Role::withTrashed()->find($id);
      $role->forceDelete();
      return redirect()->route('roles.trash')
                       ->with('success',"Role destroyed from the DB successfully");
    }
}
