<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
            if (Auth::check()) {
                return redirect(config('app.admin_path') . '/dashboard');
            } else {
                return view('admin.login');
            }
        }
    }

    /**
     * Admin logout
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->guest(config('app.admin_path'));
    }
}
