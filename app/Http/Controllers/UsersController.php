<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Show users main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('administrator.users', ['users' => User::all()]);
    }

    /**
     * Return all user
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return User::all();
    }

    /**
     * Create an user
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateUserRequest $request)
    {
        $password = $request->input('password');
        $user = User::create($request->all());
        $user -> password = Hash::make($password);
        if ($user->save())
            return response()->json(['return' => true, 'message' => trans('users.create.success')]);
        else
            return response()->json(['return' => false, 'message' => trans('users.create.error')]);
    }

    /**
     * Change user administrator state
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeAdministratorState(User $user)
    {
        if ($user->id == Auth::user()->id)
            return response()->json(['return' => false, 'message' => trans('users.create.self-admin-error')]);
        $user->administrator = !$user->administrator;
        if ($user->save())
            return response()->json(['return' => true, 'message' => trans('users.create.admin-success')]);
        else
            return response()->json(['return' => false, 'message' => trans('users.create.admin-error')]);
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
            return response()->json(['return' => false, 'message' => trans('users.create.self-remove-error')]);
        else if ($user->delete())
            return response()->json(['return' => true, 'message' => trans('users.create.remove-success')]);
        else
            return response()->json(['return' => false, 'message' => trans('users.create.remove-error')]);
    }
}
