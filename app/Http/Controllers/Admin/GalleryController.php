<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlbumImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    /**
     * Show all images
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $images = AlbumImage::getImages(4, $request->input('search'));
        $request->flash();
        return view('admin.gallery.index', compact('images'));
    }

    /**
     * Create image
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod("post")) {
            $rules = [
                "link" => "url",
                'image' => 'required|mimes:jpeg,jpg,png'
            ];
            Validator::make($request->all(), $rules)->validate();
            $album_image = new AlbumImage();
            $album_image->title = $request->input("title");
            $album_image->link = $request->input("link");
            if (!empty($request->file("image"))) {
                $generated_string = str_random(32);
                $file = $request->file("image")->store('uploads');
                $new_file = $generated_string . '.' . $request->file("image")->getClientOriginalExtension();
                Storage::move($file, 'uploads/' . $new_file);
                $img = Image::make($request->file('image'));
                $img->crop(200, 200);
                $img->save(storage_path('app/public/uploads/' . $new_file));
                $album_image->image = $new_file;
            }
            if ($request->has("album")) {
                $album_image->album_id = $request->input("album");
            }
            $album_image->publish = $request->has("publish");
            $album_image->save();
            return redirect()->route('gallery');
        } else {
            $albums = Category::getCategoriesByContentType(3);
            return view("admin.gallery.create", compact("albums", "gallery"));
        }
    }

    /**
     * Edit image
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        if ($request->isMethod("post")) {
            $rules = [
                "link" => "url",
                'image' => 'mimes:jpeg,jpg,png'
            ];
            Validator::make($request->all(), $rules)->validate();
            $album_image = AlbumImage::getImageById($id);
            $album_image->title = $request->input("title");
            $album_image->link = $request->input("link");
            if (!empty($request->file("image"))) {
                if (!empty($album_image->image)) {
                    if (Storage::exists('uploads/' . $album_image->image) && Storage::exists('uploads/fb-' . $album_image->image)) {
                        Storage::delete('uploads/' . $album_image->image, 'uploads/fb-' . $album_image->image);
                    }
                }
                $generated_string = str_random(32);
                $file = $request->file("image")->store('uploads');
                $new_file = $generated_string . '.' . $request->file("image")->getClientOriginalExtension();
                Storage::move($file, 'uploads/' . $new_file);
                $img = Image::make($request->file('image'));
                $img->crop(200, 200);
                $img->save(storage_path('app/public/uploads/' . $new_file));
                $album_image->image = $new_file;
            }
            if ($request->has("album")) {
                $album_image->album_id = $request->input("album");
            }
            $album_image->publish = $request->has("publish");
            $album_image->save();
            return redirect()->route('gallery');
        } else {
            $gallery = AlbumImage::getImageById($id);
            $albums = Category::getCategoriesByContentType(3);
            return view("admin.gallery.edit", compact("albums", "gallery"));
        }
    }

    /**
     * Delete images
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            foreach ($request->input('images') as $image) {
                $image = AlbumImage::getImageById($image);
                if (!empty($image)) {
                    if (!empty($image->image)) {
                        if (Storage::exists('uploads/' . $image->image) && Storage::exists('uploads/fb-' . $image->image)) {
                            Storage::delete('uploads/' . $image->image, 'uploads/fb-' . $image->image);
                        }
                    }
                    $image->delete();
                }
            }
        } else {
            $image = AlbumImage::getImageById($id);
            if (!empty($image)) {
                if (!empty($image->image)) {
                    if (Storage::exists('uploads/' . $image->image) && Storage::exists('uploads/fb-' . $image->image)) {
                        Storage::delete('uploads/' . $image->image, 'uploads/fb-' . $image->image);
                    }
                }
                $image->delete();
            }
            return redirect()->back();
        }
    }
}
