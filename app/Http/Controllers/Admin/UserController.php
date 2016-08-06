<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Show all users
     *
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $users = User::getUsers(10, $request->input('search'));
        $request->flash();
        return view('admin.user.index')->with(compact('users'));
    }

    /**
     * Create user
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'position' => 'required',
                'type' => 'required',
                'phone' => 'phone:AM',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
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
                $user->role_id = $request->input('type');
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
                $user->notification = $request->has('notification');
                $user->password = Hash::make($request->input('pass'));
                $user->approve = 1;
                $user->verify = 1;
                $user->save();
                if ($user->role_id == 1) {
                    $notification = new Notification();
                    $notification->from = 1;
                    $notification->to = $user->id;
                    $notification->type = 1;
                    $notification->save();
                }
                return redirect()->route('users');
            }
        } else {
            return view('admin.user.create');
        }
    }

    /**
     * Edit user
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $user = User::getUserById($id);
        if (!empty($user)) {
            if ($request->isMethod('post')) {
                $rules = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'position' => 'required',
                    'type' => 'required',
                    'phone' => 'phone:AM',
                    'username' => 'required|unique:users,username,' . $id,
                    'email' => 'required|email|unique:users,email,' . $id,
                    'pass' => 'min:6|max:12',
                    'pass_confirmation' => 'min:6|max:12|same:pass',
                    'image' => 'mimes:jpeg,png',
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput($request->except('pass'));
                } else {
                    $user->first_name = $request->input('first_name');
                    $user->last_name = $request->input('last_name');
                    $user->position = $request->input('position');
                    $user->role_id = $request->input('type');
                    if ($request->has('phone')) {
                        $user->phone = $request->input('phone');
                    }
                    if (!empty($request->file("image"))) {
                        File::delete('/uploads/' . $user->image);
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
                    $user->notification = $request->has('notification');
                    if ($request->has('pass')) {
                        $user->password = Hash::make($request->input('pass'));
                    }
                    $user->approve = 1;
                    $user->verify = 1;
                    $user->save();
                    $notifications = Notification::getNotificationBySenderId($user->id);
                    foreach ($notifications as $notification) {
                        $notification->delete();
                    }
                    $notifications = Notification::getNotificationByReaderId($user->id);
                    foreach ($notifications as $notification) {
                        $notification->delete();
                    }
                    if ($user->role_id == 1) {
                        $notification = new Notification();
                        $notification->from = 1;
                        $notification->to = $user->id;
                        $notification->type = 1;
                        $notification->save();
                    }
                    return redirect()->route('users');
                }
            } else {
                return view('admin.user.edit')->with(compact('user'));
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * Edit admin
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function admin_edit(Request $request, $id)
    {
        $user = User::getUserById($id);
        if ($request->isMethod('post')) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'pass' => 'min:6|max:12',
                'pass_confirmation' => 'min:6|max:12|same:pass',
                'image' => 'mimes:jpeg,png',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                if (!empty($request->file("image"))) {
                    $generated_string = str_random(12);
                    $extension = $request->file("image")->getClientOriginalExtension();
                    $new_file = "uploads/" . $generated_string . "." . $extension;
                    File::move($request->file("image"), $new_file);
                    $img = Image::make($new_file);
                    $img->save("uploads/" . $generated_string . $img->crop(100, 100) . "." . $extension);
                    $user->image = $generated_string . '.' . $extension;
                }
                $user->email = $request->input('email');
                $user->notification = $request->has('notification');
                if ($request->has('pass')) {
                    $user->password = Hash::make($request->input('pass'));
                }
                $user->save();
                return redirect()->route('dashboard');
            }
        } else {
            return view('admin.user.admin_edit', compact('user'));
        }
    }

    /**
     * Delete user
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            foreach ($request->input('users') as $user) {
                $user = User::getUserById($user);
                if (!empty($user)) {
                    $user->delete();
                }
            }
        } else {
            $user = User::getUserById($id);
            if (!empty($user)) {
                $user->delete();
            }
            return redirect()->back();
        }
    }

    /**
     * Export user
     */
    public function export()
    {
        $data = array(array('First name', 'Last name', 'Phone number', 'Position', 'Type', 'Username', 'E-mail'));
        $users = User::getUsers();
        foreach ($users as $user) {
            $users_array = array();
            $first_name = $user['first_name'];
            array_push($users_array, $first_name);
            $last_name = $user['last_name'];
            array_push($users_array, $last_name);
            if (!empty($user['phone'])) {
                $phone = $user['phone'];
            } else {
                $phone = 'None';
            }
            array_push($users_array, $phone);
            $position = $user['position'];
            array_push($users_array, $position);
            if ($user['role_id'] == 1) {
                $type = 'Admin';
            } else {
                $type = 'User';
            }
            array_push($users_array, $type);
            $username = $user['username'];
            array_push($users_array, $username);
            $email = $user['email'];
            array_push($users_array, $email);
            array_push($data, $users_array);
        }

        Excel::create('Users', function ($excel) use ($data) {

            $excel->sheet('Users', function ($sheet) use ($data) {

                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->cells('A1:G1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }
}
