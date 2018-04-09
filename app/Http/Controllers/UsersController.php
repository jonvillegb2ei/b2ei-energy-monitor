<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('administrator.users', ['users' => User::all()]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return User::all();
    }

    public function create(CreateUserRequest $request)
    {
        $password = $request->input('password');
        $user = User::create($request->all());
        $user -> password = Hash::make($password);
        if ($user->save())
            return response()->json(['return' => true, 'message' => 'User created.']);
        else
            return response()->json(['return' => false, 'message' => 'Error during user creation.']);
    }

    public function changeAdministratorState(User $user)
    {
        if ($user->id == Auth::user()->id)
            return response()->json(['return' => false, 'message' => 'You can\'t delete yourself.']);
        $user->administrator = !$user->administrator;
        if ($user->save())
            return response()->json(['return' => true, 'message' => 'Administrator state changed.']);
        else
            return response()->json(['return' => false, 'message' => 'Error during administrator state change.']);
    }


    /**
     * Remove an user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @internal param User $equipment
     */
    public function remove (User $user)
    {
        if ($user->id == Auth::user()->id)
            return response()->json(['return' => false, 'message' => 'You can\'t delete yourself.']);
        else if ($user->delete())
            return response()->json(['return' => true, 'message' => 'User deleted.']);
        else
            return response()->json(['return' => false, 'message' => 'Error during user deletion.']);
    }
}
