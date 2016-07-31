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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;


class PostController extends Controller
{
    /**
     * Show all posts
     *
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $title = "All Posts";
        if ($request->isMethod('post')) {
            $posts = Post::getPosts(4, $request->input('search'), Auth::user()->id);
        } else {
            $posts = Post::getPosts(4, '', Auth::user()->id);
        }
        return view('site.post.index')->with(compact('posts', 'title'));
    }

    /**
     * Create post
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $title = 'Create Post';
        if ($request->isMethod("post")) {
            $rules = [
                "title" => "required",
                "alias" => "required|unique:posts,alias",
                "content" => "required",
                'image' => 'mimes:jpeg,png'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $post = new Post();
                $post->title = $request->input("title");
                $post->alias = $request->input("alias");
                $post->content = $request->input("content");
                $post->meta_keys = $request->input("meta_keys");
                $post->meta_desc = $request->input("meta_desc");
                if (!empty($request->file("image"))) {
                    $generated_string = str_random(12);
                    $extension = $request->file("image")->getClientOriginalExtension();
                    $new_file = "uploads/" . $generated_string . '.' . $extension;
                    File::move($request->file("image"), $new_file);
                    $img = Image::make($new_file);
                    $img->save("uploads/fb-" . $generated_string . $img->crop(600, 315) . '.' . $extension);
                    $img = Image::make($new_file);
                    $img->save("uploads/" . $generated_string . $img->crop(200, 200) . '.' . $extension);
                    $post->image = $generated_string . '.' . $extension;
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
            }
        } else {
            $categories = Category::getCategoriesByPublish();
            $tags = Tag::getTags();
            return view("site.post.create", compact("categories", "tags", "post", "title"));
        }
    }

    /**
     * Edit post
     *
     * @param Request $request
     * @param int $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = 0)
    {
        $title = 'Edit Post';
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
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                } else {
                    $post->title = $request->input("title");
                    $post->alias = $request->input("alias");
                    $post->content = $request->input("content");
                    $post->meta_keys = $request->input("meta_keys");
                    $post->meta_desc = $request->input("meta_desc");
                    if (!empty($request->file("image"))) {
                        File::delete('uploads/' . $post->image, 'uploads/gb-' . $post->image);
                        $generated_string = str_random(12);
                        $extension = $request->file("image")->getClientOriginalExtension();
                        $new_file = "uploads/" . $generated_string . "." . $extension;
                        File::move($request->file("image"), $new_file);
                        $img = Image::make($new_file);
                        $img->save("uploads/fb-" . $generated_string . $img->crop(600, 315) . '.' . $extension);
                        $img = Image::make($new_file);
                        $img->save("uploads/" . $generated_string . $img->crop(200, 200) . "." . $extension);
                        $post->image = $generated_string . "." . $extension;
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
                }
            } else {
                $categories = Category::getCategoriesByPublish();
                $tags = Tag::getTags();
                return view("site.post.edit", compact("post", "categories", "tags", "title"));
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
                    $post->delete();
                }
            }
        } else {
            $post = Post::getPostById($id);
            if (!empty($post)) {
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
            $title = $post['title'];
            array_push($post_array, $title);
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
            $visits = $post->visits()->count();
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

                $sheet->cells('A1:F1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }
}
