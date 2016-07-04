<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Admin login
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $username = $request->input('username');
            $password = $request->input('password');
            $remember_me = $request->input('remember_me');
            if (Auth::attempt(['username' => $username, 'password' => $password], $remember_me)) {
                return response()->json(['message' => 'success'], 200);
            } else {
                return response()->json(['message' => 'failed'], 422);
            }
        } else {
            if (Auth::check() && Auth::user()->role_id == 1) {
                return redirect(config('app.admin_route_name') . '/dashboard');
            } else {
                return view('admin.login');
            }
        }
    }

    /**
     * Admin logout
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect(config('app.admin_route_name'));
    }
}
