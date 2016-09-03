<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;


class PostController extends Controller
{
    /**
     * Show all posts
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $posts = Post::getPosts(4, $request->input('search'), Auth::user()->id);
        $request->flash();
        return view('site.post.index', compact('posts'));
    }

    /**
     * Create post
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod("post")) {
            $rules = [
                "title" => "required",
                "alias" => "required|unique:posts,alias",
                "content" => "required",
                'image' => 'mimes:jpeg,png'
            ];
            Validator::make($request->all(), $rules)->validate();
            $post = new Post();
            $post->title = $request->input("title");
            $post->alias = $request->input("alias");
            $post->content = $request->input("content");
            $post->meta_keys = $request->input("meta_keys");
            $post->meta_desc = $request->input("meta_desc");
            if (!empty($request->file("image"))) {
                $generated_string = str_random(32);
                $file = $request->file("image")->store('uploads');
                $new_file = $generated_string . '.' . $request->file("image")->getClientOriginalExtension();
                Storage::move($file, 'uploads/' . $new_file);
                $img = Image::make($request->file('image'));
                $img->crop(200, 200);
                $img->save(storage_path('app/public/uploads/' . $new_file));
                $img = Image::make($request->file('image'));
                $img->resize(600, 315);
                $img->save(storage_path('app/public/uploads/fb-' . $new_file));
                $post->image = $new_file;
            }
            if ($request->has("category")) {
                $post->category_id = $request->input("category");
            }
            $post->publish = $request->has("publish");
            $post->author_id = Auth::user()->id;
            $post->save();
            if ($request->has("tags")) {
                foreach ($request->input("tags") as $tag) {
                    $post_tag = new PostTag();
                    $post_tag->post_id = $post->id;
                    $post_tag->tag_id = $tag;
                    $post_tag->save();
                }
            }
            $admins = User::getUsers(0, '', 1);
            foreach ($admins as $admin) {
                if ($admin->id != Auth::user()->id) {
                    $notification = new Notification();
                    $notification->from = Auth::user()->id;
                    $notification->to = $admin->id;
                    $notification->type = 3;
                    $notification->save();
                }
            }
            return redirect()->route('posts');
        } else {
            $categories = Category::getCategoriesByPublish();
            $tags = Tag::getTags();
            return view("site.post.create", compact("categories", "tags", "post"));
        }
    }

    /**
     * Edit post
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = 0)
    {
        $post = Post::getPostById($id);
        if (empty($post)) {
            return redirect()->back();
        } else {
            if ($request->isMethod("post")) {
                $rules = [
                    "title" => "required",
                    "alias" => "required|unique:posts,alias," . $id,
                    "content" => "required",
                    'image' => 'mimes:jpeg,png'
                ];
                Validator::make($request->all(), $rules)->validate();
                $post->title = $request->input("title");
                $post->alias = $request->input("alias");
                $post->content = $request->input("content");
                $post->meta_keys = $request->input("meta_keys");
                $post->meta_desc = $request->input("meta_desc");
                if (!empty($request->file("image"))) {
                    if (Storage::exists('uploads/' . $post->image) && Storage::exists('uploads/fb-' . $post->image)) {
                        Storage::delete('uploads/' . $post->image, 'uploads/fb-' . $post->image);
                    }
                    $generated_string = str_random(32);
                    $file = $request->file("image")->store('uploads');
                    $new_file = $generated_string . '.' . $request->file("image")->getClientOriginalExtension();
                    Storage::move($file, 'uploads/' . $new_file);
                    $img = Image::make($request->file('image'));
                    $img->crop(200, 200);
                    $img->save(storage_path('app/public/uploads/' . $new_file));
                    $img = Image::make($request->file('image'));
                    $img->resize(600, 315);
                    $img->save(storage_path('app/public/uploads/fb-' . $new_file));
                    $post->image = $new_file;
                }
                if ($request->has("category")) {
                    $post->category_id = $request->input("category");
                }
                $post->publish = $request->has("publish");
                $post->save();
                $new_tags = [];
                if ($request->has("tags")) {
                    echo 'asdasd';
                    $tags = $request->input("tags");
                    foreach ($tags as $tag) {
                        array_push($new_tags, $tag);
                    }
                }
                $post->tags()->sync($new_tags);
                return redirect()->route('posts');
            } else {
                $categories = Category::getCategoriesByPublish();
                $tags = Tag::getTags();
                return view("site.post.edit", compact("post", "categories", "tags"));
            }
        }
    }

    /**
     * Delete post
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            foreach ($request->input('posts') as $post) {
                $post = Post::getPostById($post);
                if (!empty($post)) {
                    if (Storage::exists('uploads/' . $post->image) && Storage::exists('uploads/fb-' . $post->image)) {
                        Storage::delete('uploads/' . $post->image, 'uploads/fb-' . $post->image);
                    }
                    $post->delete();
                }
            }
        } else {
            $post = Post::getPostById($id);
            if (!empty($post)) {
                if (Storage::exists('uploads/' . $post->image) && Storage::exists('uploads/fb-' . $post->image)) {
                    Storage::delete('uploads/' . $post->image, 'uploads/fb-' . $post->image);
                }
                $post->delete();
            }
            return redirect()->back();
        }
    }

    /**
     * Export posts
     */
    public function export()
    {
        $data = array(array('Name', 'Alias', 'Tags', 'Category', 'Status', 'Views', 'Publish'));
        $posts = Post::getPosts(0, '', Auth::user()->id);
        foreach ($posts as $post) {
            $post_array = array();
            $alias = $post['alias'];
            array_push($post_array, $alias);
            if ($post->tags->count() == 0) {
                $tags = 'None';
            } else {
                $tags = "";
                foreach ($post->tags as $tag) {
                    $tags .= $tag['name'] . ',';
                }
            }
            array_push($post_array, $tags);
            if (empty($post['category_id'])) {
                $category = 'None';
            } else {
                $category = Category::getCategoryById($post['category_id'])['name'];
            }
            array_push($post_array, $category);
            if ($post['approve'] == 1) {
                $status = 'Approved';
            } else {
                $status = 'Not approved';
            }
            array_push($post_array, $status);
            $visits = (string)$post->visits()->count();
            array_push($post_array, $visits);
            if (empty($post['publish'])) {
                $publish = 'Unpublished';
            } else {
                $publish = 'Published';
            }
            array_push($post_array, $publish);
            array_push($data, $post_array);
        }

        Excel::create('Posts', function ($excel) use ($data) {

            $excel->sheet('Posts', function ($sheet) use ($data) {

                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->cells('A1:G1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }
}
