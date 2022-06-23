<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data['users'] = User::orderBy('id','asc')->paginate(15);
        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['roles'] = Role::orderBy('id','desc')->get();

        return view('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $u = new User();
        $u->name = $request->name;
        $u->firstname = $request->firstname;
        $u->lastname = $request->lastname;
        $u->email = $request->email;
        $u->password = Hash::make($request->password);
        $u->role_id = $request->role;

        $u->save();

        return redirect()->route('user.index')
            ->with('success','User has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data['user'] = $user;
        $data['roles'] = Role::orderBy('id','desc')->get();

        return view('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $u = User::find($user->id);
        $u->name = $request->name;
        $u->firstname = $request->firstname;
        $u->lastname = $request->lastname;
        $u->email = $request->email;
        $u->password = $request->password ? Hash::make($request->password) : $user->password;
        $u->role_id = $request->role;

        $u->save();

        return redirect()->route('user.index')
            ->with('success','User has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()
            ->with('success','User has been deleted successfully');
    }
}
