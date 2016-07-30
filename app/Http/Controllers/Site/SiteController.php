<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryVisit;
use App\Models\Post;
use App\Models\PostVisit;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Get category and category posts
     *
     * @param Request $request
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function category(Request $request, $alias)
    {
        $category = Category::getCategoryByAlias($alias);
        if (empty($category)) {
            return redirect()->back();
        } else {
            $title = $category['name'];
            if ($request->isMethod('post')) {
                $posts = Category::getCategoryApprovedPosts($category['id'], 5, $request->input('search'));
            } else {
                $posts = Category::getCategoryApprovedPosts($category['id'], 5);
            }
            if (!session()->get($category['id'])) {
                $category_visit = new CategoryVisit();
                $category_visit->category_id = $category['id'];
                $category_visit->save();
                session([$category['id'] => $category['id']]);
            }
            return view('site.category', compact('category', 'title', 'posts'));
        }
    }

    /**
     * Get post
     *
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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
