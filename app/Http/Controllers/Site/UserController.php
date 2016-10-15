<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Edit profile
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = User::getUserById(Auth::user()->id);
        if ($request->isMethod('post')) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'position' => 'required',
                'phone' => 'phone:AM',
                'username' => 'required|unique:users,username,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'pass' => 'min:6|max:12',
                'pass_confirmation' => 'min:6|max:12|same:pass',
                'image' => 'mimes:jpeg,jpg,png',
            ];
            Validator::make($request->all(), $rules)->validate();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->position = $request->input('position');
            if ($request->has('phone')) {
                $user->phone = $request->input('phone');
            }
            if (!empty($request->file("image"))) {
                if (!empty($user->image)) {
                    if (Storage::exists('uploads/' . $user->image)) {
                        Storage::delete('uploads/' . $user->image);
                    }
                }
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
            $user->notification = $request->has('notification');
            if ($request->has('pass')) {
                $user->password = Hash::make($request->input('pass'));
            }
            $user->save();
            return redirect('/');
        } else {
            return view('site.user.edit', compact('user'));
        }
    }
}
