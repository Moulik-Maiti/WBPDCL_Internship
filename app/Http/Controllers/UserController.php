<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array 
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit','update']),
            new Middleware('permission:create users', only: ['create','store']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::orderBy('name','asc')->paginate(10);
        return view('user.list', [
            'users' =>$users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::orderBy('name','asc')->get();
        return view('user.create',[
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()){
            return redirect()->route('user.create')->withErrors($validator)->withInput();
        } else {

        $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            $roles = Role::whereIn('id', $request->role ?? [])->get();
            $user->syncRoles($roles);

            return redirect()->route('user.index')->with('success', 'User updated successfully.'); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $users = User::findOrFail($id);
        $hasRole = $users->roles->pluck('id');
        
        $roles = Role::orderBy('name','asc')->get();
        return view('user.edit', [
            'users' =>$users,
            'roles' =>$roles,
            'hasRole' => $hasRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email:dns|unique:users,email,'.$id
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $roles = Role::whereIn('id', $request->role ?? [])->get();
            $user->syncRoles($roles);

            return redirect()->route('user.index')->with('success', 'User updated successfully.'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $users = User::find($request->route('user'));

        if(!$users){
            session()->flash('error','User not Found');
            return response()->json([
                'status' => false
            ]);
        }
        else {
            $users->delete();

            session()->flash('success','User Deleted Successfully');
            return response()->json([
                'status' => true
            ]);
        }
    }
}
