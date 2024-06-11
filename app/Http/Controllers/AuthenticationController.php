<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function doLogin(LoginUserRequest $request): RedirectResponse {
        $auth = Auth::attempt($request->validated());

        if (!$auth) {
            return redirect('/login');
        }

        return redirect('/');
    }

    public function doLogout(): RedirectResponse {

        Auth::logout();

        return redirect('/');

    }

    public function doRegister(RegisterUserRequest $request): RedirectResponse {
        throw new \Exception("TODO: Implementation!");
    }
}
