<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
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
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $users = User::getUsers(10, $request->input('search'));
        } else {
            $users = User::getUsers(10);
        }
        return view('admin.user.index')->with(compact('users'));
    }

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
                'pass' => 'required|digits_between:6,12',
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
                    $request->phone = $request->input('phone');
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
                $user->password = Hash::make($request->input('pass'));
                $user->approve = 1;
                $user->verify = 1;
                $user->save();
                return redirect()->back();
            }
        } else {
            return view('admin.user.create');
        }
    }

    /**
     * Export users
     */
    public function export()
    {
        $data = array(array('Username'));
        $users = User::getUsers();
        foreach ($users as $user) {
            $users_array = array();
            $username = $user['username'];
            array_push($users_array, $username);
            array_push($data, $users_array);
        }

        Excel::create('Users', function ($excel) use ($data) {

            $excel->sheet('Users', function ($sheet) use ($data) {

                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->cells('A1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
