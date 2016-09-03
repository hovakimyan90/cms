<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    /**
     * User registration
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'position' => 'required',
                'phone' => 'phone:AM',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'pass' => 'required|min:6|max:12',
                'pass_confirmation' => 'required|min:6|max:12|same:pass',
                'image' => 'mimes:jpeg,png',
            ];
            Validator::make($request->all(), $rules)->validate();
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->position = $request->input('position');
            $user->role_id = 2;
            if ($request->has('phone')) {
                $user->phone = $request->input('phone');
            }
            if (!empty($request->file("image"))) {
                $generated_string = str_random(32);
                $file = $request->file("image")->store('uploads');
                $new_file = $generated_string . '.' . $request->file("image")->getClientOriginalExtension();
                Storage::move($file, 'uploads/' . $new_file);
                $img = Image::make($request->file('image'));
                $img->crop(200, 200);
                $img->save(storage_path('app/public/uploads/' . $new_file));
                $user->image = $new_file;
            }
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('pass'));
            $user->verify_token = str_random(32);
            $user->save();
            return redirect('/');
        } else {
            return view('site.auth.register');
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
            $admins = User::getUsers(0, '', 1);
            foreach ($admins as $admin) {
                $notification = new Notification();
                $notification->from = $user->id;
                $notification->to = $admin->id;
                $notification->type = 2;
                $notification->save();
            }
            $notification = new Notification();
            $notification->from = 1;
            $notification->to = $user->id;
            $notification->type = 4;
            $notification->save();
        }
        return redirect()->route('home');
    }

    /**
     * User forget password
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function forget(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'email' => 'required|email|exists:users,email'
            ];
            Validator::make($request->all(), $rules)->validate();
            $email = $request->input('email');
            $user = User::getUserByEmail($email);
            $user->reset_password_token = str_random(32);
            $user->save();
            $request->session()->flash('success', 'success');
            return redirect()->back();
        } else {
            return view('site.auth.forget');
        }
    }

    /**
     * User reset password
     *
     * @param Request $request
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function reset(Request $request, $token)
    {
        $user = User::getUserByResetPasswordToken($token);
        if (!empty($user)) {
            if ($request->isMethod('post')) {
                $rules = [
                    'pass' => 'required|min:6|max:12',
                    'pass_confirmation' => 'required|min:6|max:12|same:pass'
                ];
                Validator::make($request->all(), $rules)->validate();
                $user->password = Hash::make($request->input('pass'));
                $user->reset_password_token = '';
                $user->save();
                return redirect()->route('home');
            } else {
                return view('site.auth.reset');
            }
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * User login
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $email = $request->input('email');
            $password = $request->input('pass');
            $remember = $request->has('remember');
            if (Auth::attempt(['email' => $email, 'password' => $password, 'role_id' => 2, 'verify' => 1], $remember)) {
                $user = User::getUserById(Auth::user()->id);
                $user->online = 1;
                $user->save();
                return redirect()->route('posts');
            } else {
                $request->session()->flash('error', 'error');
                $request->flashExcept('pass');
                return redirect()->back();
            }
        } else {
            if (Auth::check() && Auth::user()->role_id == 2) {
                return redirect()->route('posts');
            } else {
                return view('site.auth.login');
            }
        }
    }

    /**
     * User logout
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $user = User::getUserById(Auth::user()->id);
        $user->online = 0;
        $user->save();
        Auth::logout();
        return redirect()->route('home');
    }
}
