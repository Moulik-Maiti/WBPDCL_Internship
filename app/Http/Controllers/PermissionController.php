<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:create permissions', only: ['create','store']),
            new Middleware('permission:edit permissions', only: ['edit','update']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }

    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'asc')->paginate(10);
        return view('permission.list',[
            'permissions' => $permissions
        ]);
    }
    public function create()
    {
        return view('permission.create');
    }   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name|max:100'
        ]);

        if ($validator->passes()) {
            // valid data handling
            Permission::create([
                'name' => $request->input('name')
            ]);
            return redirect()->route('permission.index')->with('success', 'Permission created successfully.');

        } else {
            return redirect()->route('permission.create')->withErrors($validator)->withInput();
        }
    }

    public function edit($id){
        $permission = Permission::findOrfail($id);
        return view('permission.edit',[
            'permission'=>$permission
        ]);
    }
    public function update($id,Request $request){
        $permission = Permission::findOrfail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
        ]);


        if ($validator->passes()) {

            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permission.index')->with('success', 'Permission updated successfully.');

        } else {
            return redirect()->route('permission.edit',$id)->withErrors($validator)->withInput();
        }   
    }
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
        return response()->json([
            'status' => false,
            'message' => 'Permission not found.'
        ]);
    }

    $permission->delete();

    session()->flash('success', 'Permission deleted successfully.');

    return response()->json([
        'status' => true
    ]);
}
}