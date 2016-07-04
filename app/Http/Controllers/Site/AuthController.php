<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    /**
     * User registration
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $title = 'Register';
        if ($request->isMethod('post')) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'position' => 'required',
                'phone' => 'phone:AM',
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'pass' => 'required|min:6|max:12',
                'pass_confirmation' => 'required|min:6|max:12|same:pass',
                'image' => 'mimes:jpeg,png',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->except('pass'));
            } else {
                $user = new User();
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->position = $request->input('position');
                $user->role_id = 2;
                if ($request->has('phone')) {
                    $user->phone = $request->input('phone');
                }
                if (!empty($request->file("image"))) {
                    $generated_string = str_random(12);
                    $extension = $request->file("image")->getClientOriginalExtension();
                    $new_file = "uploads/" . $generated_string . "." . $extension;
                    File::move($request->file("image"), $new_file);
                    $img = Image::make($new_file);
                    $img->save("uploads/" . $generated_string . $img->crop(100, 100) . "." . $extension);
                    $user->image = $generated_string . '.' . $extension;
                }
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                $user->password = Hash::make($request->input('pass'));
                $user->verify_token = str_random(32);
                $user->save();
                return redirect('/');
            }
        } else {
            return view('site.auth.register')->with(compact('title'));
        }
    }

    /**
     * User activation
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activation($token)
    {
        $user = User::getUserByVerifyToken($token);
        if (!empty($user)) {
            $user->verify = 1;
            $user->verify_token = "";
            $user->save();
        }
        return redirect()->route('home');
    }

    /**
     * User forgot password
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function forget(Request $request)
    {
        $title = "Forget Password";
        if ($request->isMethod('post')) {
            $rules = [
                'email' => 'required|email|exists:users,email'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $email = $request->input('email');
                $user = User::getUserByEmail($email);
                $user->reset_password_token = str_random(32);
                $user->save();
                $request->session()->flash('success', 'success');
                return redirect()->back();
            }
        } else {
            return view('site.auth.forget', compact('title'));
        }
    }

    /**
     * User reset password
     *
     * @param Request $request
     * @param $token
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function reset(Request $request, $token)
    {
        $title = "Reset Password";
        $user = User::getUserByResetPasswordToken($token);
        if (!empty($user)) {
            if ($request->isMethod('post')) {
                $rules = [
                    'pass' => 'required|min:6|max:12',
                    'pass_confirmation' => 'required|min:6|max:12|same:pass'
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                } else {
                    $user->password = Hash::make($request->input('pass'));
                    $user->reset_password_token = '';
                    $user->save();
                    return redirect()->route('home');
                }
            } else {
                return view('site.auth.reset', compact('title'));
            }
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * User login
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        $title = "Login";
        if ($request->isMethod('post')) {
            $email = $request->input('email');
            $password = $request->input('pass');
            $remember = $request->has('remember');
            if (Auth::attempt(['email' => $email, 'password' => $password, 'role_id' => 2, 'verify' => 1], $remember)) {
                $user = User::getUserById(Auth::user()->id);
                $user->online = 1;
                $user->save();
                return redirect('/sd');
            } else {
                $request->session()->flash('error', 'error');
                return redirect()->back()->withInput($request->except('pass'));
            }
        } else {
            if (Auth::check() && Auth::user()->role_id == 2) {
                return redirect('profile');
            } else {
                return view('site.auth.login', compact('title'));
            }
        }
    }

    public function logout()
    {
        $user = User::getUserById(Auth::user()->id);
        $user->online = 0;
        $user->save();
        Auth::logout();
        return redirect()->route('home');
    }
}
