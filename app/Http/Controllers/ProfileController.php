<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\EditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function profile()
    {
        return view('profile.profile');
    }


    public function edit(EditRequest $request) {
        $user = \Auth::user();
        $return = $user->update($request->only('firstname', 'lastname', 'email'));
        $password = $request->input('password', null);
        if ($password) {
            $user->password = Hash::make($password);
            $user->save();
        }
        if ($return)
            return redirect()->back()->with('success', ['message' => 'Your profile has been updated with success.']);
        else
            return redirect()->back()->withErrors('Error during profile update.');
    }

}
