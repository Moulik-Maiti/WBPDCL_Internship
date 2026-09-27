<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view role', only: ['index']),
            new Middleware('permission:create roles', only: ['create','store']),
            new Middleware('permission:edit roles', only: ['edit','update']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    public function index(){
        $role = Role::with('permissions')->orderBy('name','asc')->paginate(10);
        return view('roles.list',[
            'role' => $role
        ]);
        
    }

    public function create(){

        $permissions = Permission::orderBy('name','asc')->get();

        return view('roles.create', [
            'permissions' => $permissions
        ]);

        
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3'
        ]);

        if ($validator->passes()) {
            // valid data handling
            $role = Role::create([
                'name' => $request->name
            ]);

           if ($request->has('permission')) {

           $permissions = Permission::whereIn('id', $request->permission)->get();

           $role->syncPermissions($permissions);
       }

            return redirect()->route('role.index')->with('success', 'Role Added successfully.');

        } else {
            return redirect()->route('role.create')->withErrors($validator)->withInput();
        }
    }
    public function edit($id,Request $request){
        $role = Role::findOrfail($id);
        
        $permission = Permission::orderBy('name','ASC')->get();
        $hasPermission = $role->permissions->pluck('name');
        return view('roles.edit',[
            'role' => $role,
            'permissions' => $permission,
            'hasPermission'=> $hasPermission
        ]);
    }  
    public function update($id, Request $request){
        $role = Role::findOrfail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id.',id'
        ]);

        if ($validator->passes()) {
            // valid data handling
            $role->name = $request->name;
            $role->save();

           if ($request->has('permission')) {

                $permissions = Permission::whereIn('id', $request->permission)->get();

                $role->syncPermissions($permissions);
            }else {
                $role->syncPermissions([]);
            }

            return redirect()->route('role.index')->with('success', 'Role updated successfully.');

        } else {
            return redirect()->route('role.edit',$id)->withErrors($validator)->withInput();
        }
    }
    public function destroy(Request $request,$id){
        $id = $request->id;
        $role = Role::find($id);
        if($role == null){
            return response()->json([
                'status'=> false
            ]);
        }
        $role->delete();

        session()->flash('success','Role deleted Successfully.');
        return response()->json([
            'status'=>true
        ]);
    }
}


