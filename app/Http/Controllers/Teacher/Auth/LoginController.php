<?php

namespace App\Http\Controllers\Teacher\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\LoginRequest;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:teacher', ['except' => ['logout']]);
    }

    public function getLogin()
    {

        return view('teacher.auth.login');
    }

    public function login(LoginRequest $request)
    {

        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('teacher')->attempt(['phone' => $request->input("phone"), 'password' => $request->input("password")], $remember_me)) {

            if (auth()->guard('teacher')->user()->is_active) {
                return redirect()->route('teacher.dashboard');

            } else {
                Auth::guard('teacher')->logout();
                return redirect()->back()->with(['error' => __('crud.account_blocked')]);
            }
        }

        return redirect()->back()->with(['error' => __('crud.login_failed')]);
    }


    public function logout()
    {
        Auth::guard('teacher')->logout();

        return redirect()->guest(route('teacher.get.login'));


    }
}
