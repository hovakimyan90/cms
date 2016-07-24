<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryVisit;
use App\Models\Post;
use App\Models\PostVisit;

class SiteController extends Controller
{
    /**
     *
     *
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($alias)
    {
        $category = Category::getCategoryByAlias($alias);
        if (empty($category)) {
            return redirect()->back();
        } else {
            $title = $category['name'];
            $posts = Category::getCategoryApprovedPosts($category['id'], 5);
            if (!session()->get($category['id'])) {
                $category_visit = new CategoryVisit();
                $category_visit->category_id = $category['id'];
                $category_visit->save();
                session([$category['id'] => $category['id']]);
            }
            return view('site.category', compact('category', 'title', 'posts'));
        }
    }

    public function post($alias)
    {
        $post = Post::getPostByAlias($alias);
        if (empty($post)) {
            return redirect()->back();
        } else {
            $title = $post['title'];
            if (!session()->get($post['id'])) {
                $post_visit = new PostVisit();
                $post_visit->post_id = $post['id'];
                $post_visit->save();
                session([$post['id'] => $post['id']]);
            }
            return view('site.post', compact('post', 'title'));
        }
    }
}
