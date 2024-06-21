<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function doLogin(LoginUserRequest $request): RedirectResponse
    {
        $auth = Auth::attempt($request->validated());

        if (!$auth) {
            return redirect('/login')->with('error', 'username and password is wrong');
        }

        return redirect('/');
    }

    public function doLogout(Request $request): RedirectResponse
    {

        Auth::logout();

        return redirect('/');
    }

    public function doRegister(RegisterUserRequest $request): RedirectResponse
    {
        $user = $request->validated();

        User::create($user);

        return redirect('/login');
    }
}
