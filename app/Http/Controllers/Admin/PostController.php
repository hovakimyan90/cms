<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {

    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'title' => 'required',
                'alias' => 'unique:posts',
                'content' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $post = new Post();
                $post->title = $request->input('title');
                $post->alias = $request->input('alias');
                $post->content = $request->input('content');
                $post->meta_keys = $request->input('meta_keys');
                $post->meta_desc = $request->input('meta_desc');
                if (!empty($request->file('image'))) {
                    $generated_string = str_random(12);
                    $new_file = 'uploads/' . $generated_string . '.' . $request->file('image')->getClientOriginalExtension();
                    File::move($request->file('image'), $new_file);
                    $img = Image::make($new_file);
                    $img->save('uploads/' . $generated_string . $img->crop(200, 200) . '.' . $request->file('image')->getClientOriginalExtension());
                    $post->image = $generated_string;
                }
                if ($request->has('category')) {
                    $post->category_id = $request->input('category');
                }
                $post->publish = $request->has('publish');
                $post->save();
            }
        }
        $categories = Category::getCategories();
        return view('admin.post.create', compact('categories'));
    }
}
