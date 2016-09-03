<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    /**
     * Site settings
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $settings = Settings::getSettings();
        if ($request->isMethod('post')) {
            $rules = [
                'url' => 'required',
                'email' => 'required|email',
                'title' => 'required',
                'desc' => 'required',
                'keys' => 'required',
                'logo' => 'mimes:jpeg,png',
                'favicon' => 'mimes:jpeg,png',
            ];
            Validator::make($request->all(), $rules);
            $settings->url = $request->input('url');
            $settings->email = $request->input('email');
            $settings->title = $request->input('title');
            $settings->desc = $request->input('desc');
            $settings->keys = $request->input('keys');
            if (!empty($request->file("logo"))) {
                if (Storage::exists('uploads/' . $settings->logo)) {
                    Storage::delete('uploads/' . $settings->logo);
                }
                $generated_string = str_random(32);
                $file = $request->file("logo")->store('uploads');
                $new_file = $generated_string . '.' . $request->file("logo")->getClientOriginalExtension();
                Storage::move($file, 'uploads/' . $new_file);
                $img = Image::make($request->file('logo'));
                $img->crop(200, 26);
                $img->save(storage_path('app/public/uploads/' . $new_file));
                $settings->logo = $new_file;
            }
            if (!empty($request->file("favicon"))) {
                if (Storage::exists('uploads/' . $settings->favicon)) {
                    Storage::delete('uploads/' . $settings->favicon);
                }
                $generated_string = str_random(32);
                $file = $request->file("favicon")->store('uploads');
                $new_file = $generated_string . '.' . $request->file("favicon")->getClientOriginalExtension();
                Storage::move($file, 'uploads/' . $new_file);
                $img = Image::make($request->file('favicon'));
                $img->crop(16, 16);
                $img->save(storage_path('app/public/uploads/' . $new_file));
                $settings->favicon = $new_file;
            }
            if ($request->input('maintenance') == '0') {
                Artisan::call('down');
            } else {
                Artisan::call('up');
            }
            $settings->maintenance = $request->input('maintenance');
            $settings->save();
            return redirect()->back();
        } else {
            return view('admin.settings', compact('settings'));
        }
    }
}
