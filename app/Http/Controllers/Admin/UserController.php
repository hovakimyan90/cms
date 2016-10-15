<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Show all approved user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approved(Request $request)
    {
        $users = User::getApprovedUsers(10, $request->input('search'));
        $request->flash();
        return view('admin.user.approved', compact('users'));
    }

    /**
     * Show all disapproved users
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function disapproved(Request $request)
    {
        $users = User::getDisapprovedUsers(10, $request->input('search'));
        $request->flash();
        return view('admin.user.disapproved', compact('users'));
    }

    /**
     * Create user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
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
                'image' => 'mimes:jpeg,jpg,png',
            ];
            Validator::make($request->all(), $rules)->validate();

            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->position = $request->input('position');
            $user->role_id = $request->input('type');
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
            return redirect()->route('approved_users');
        } else {
            $user_roles = UserRole::getRoles();
            return view('admin.user.create', compact('user_roles'));
        }
    }

    /**
     * Edit user
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
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
                    'image' => 'mimes:jpeg,jpg,png',
                ];
                Validator::make($request->all(), $rules)->validate();

                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->position = $request->input('position');
                $user->role_id = $request->input('type');
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
                return redirect()->route('approved_users');
            } else {
                $user_roles = UserRole::getRoles();
                return view('admin.user.edit', compact('user', 'user_roles'));
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * Approve user
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id) {
        $user=User::getUserById($id);
        if(!empty($user)) {
            $user->approve=1;
            $user->save();
        }
        return redirect()->back();
    }

    /**
     * Disapprove user
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disapprove($id) {
        $user=User::getUserById($id);
        if(!empty($user)) {
            $user->approve=0;
            $user->save();
        }
        return redirect()->back();
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
                    if (!empty($user->image)) {
                        if (Storage::exists('uploads/' . $user->image)) {
                            Storage::delete('uploads/' . $user->image);
                        }
                    }
                    $user->delete();
                }
            }
        } else {
            $user = User::getUserById($id);
            if (!empty($user)) {
                if (!empty($user->image)) {
                    if (Storage::exists('uploads/' . $user->image)) {
                        Storage::delete('uploads/' . $user->image);
                    }
                }
                $user->delete();
            }
            return redirect()->back();
        }
    }

    /**
     * Export users
     *
     * @param int $type
     */
    public function export($type = 1)
    {
        $data = array(array('First name', 'Last name', 'Phone number', 'Position', 'Type', 'Username', 'E-mail'));
        if ($type = 1) {
            $users = User::getApprovedUsers();
        } else {
            $users = User::getDisapprovedUsers();
        }
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
