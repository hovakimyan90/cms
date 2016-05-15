<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    /**
     * Site settings
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function site(Request $request)
    {
        $settings = SiteSettings::getSettings();
        if ($request->isMethod('post')) {
            $rules = [
                'url' => 'required',
                'email' => 'required|email',
                'title' => 'required',
                'desc' => 'required',
                'keys' => 'required',
                'image' => 'mimes:jpeg,png',
                'favicon' => 'mimes:ico',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $settings->url = $request->input('url');
                $settings->email = $request->input('email');
                $settings->title = $request->input('title');
                $settings->desc = $request->input('desc');
                $settings->keys = $request->input('keys');
                if (!empty($request->file("image"))) {
                    File::delete('uploads/' . $settings->image);
                    $generated_string = str_random(12);
                    $extension = $request->file("image")->getClientOriginalExtension();
                    $new_file = "uploads/" . $generated_string . "." . $extension;
                    File::move($request->file("image"), $new_file);
                    $img = Image::make($new_file);
                    $img->save("uploads/" . $generated_string . $img->crop(100, 100) . "." . $extension);
                    $settings->image = $generated_string . '.' . $extension;
                }
                if (!empty($request->file("favicon"))) {
                    File::delete('/uploads/' . $settings->favicon);
                    $generated_string = str_random(12);
                    $extension = $request->file("favicon")->getClientOriginalExtension();
                    $new_file = "uploads/" . $generated_string . "." . $extension;
                    File::move($request->file("favicon"), $new_file);
                    $img = Image::make($new_file);
                    $img->save("uploads/" . $generated_string . $img->crop(16, 16) . "." . $extension);
                    $settings->image = $generated_string . '.' . $extension;
                }
                $settings->site = $request->input('site');
                $settings->save();
                return redirect()->back();
            }
        } else {
            return view('admin.settings.site')->with(compact('settings'));
        }
    }
}
