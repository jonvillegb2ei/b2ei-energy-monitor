<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function create(CreateUserRequest $request)
    {
        $user = User::create($request->all());
        if ($user)
            return redirect()->back()->with('create-success', ['message' => 'User created.']);
        else
            return redirect()->back()->with('create-error', ['message' => 'Error during user creation.']);
    }

    public function changeAdministratorState(User $user)
    {
        if ($user->id == Auth::user()->id)
            return redirect()->back()->with('table-error', ['message' => 'You can\'t delete yourself.']);
        $user->administrator = !$user->administrator;
        if ($user->save())
            return redirect()->back()->with('table-success', ['message' => 'Administrator state changed.']);
        else
            return redirect()->back()->with('table-error', ['message' => 'Error during administrator state change.']);
    }


    /**
     * Remove an equipment.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @internal param User $equipment
     */
    public function remove (User $user)
    {
        if ($user->id == Auth::user()->id)
            return redirect()->back()->with('table-error', ['message' => 'You can\'t delete yourself.']);
        else if ($user->delete())
            return redirect()->back()->with('table-success', ['message' => 'User deleted.']);
        else
            return redirect()->back()->with('table-error', ['message' => 'Error during user deletion.']);
    }
}
