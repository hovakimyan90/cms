<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryVisit;
use App\Models\Post;
use App\Models\PostVisit;
use App\Models\Tag;
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
            $tags = Tag::getTags();
            if (!session()->get($category['id'])) {
                $category_visit = new CategoryVisit();
                $category_visit->category_id = $category['id'];
                $category_visit->save();
                session([$category['id'] => $category['id']]);
            }
            $posts = Category::getCategoryApprovedPosts($category['id'], 5, $request->input('search'), $request->input('tag'));
            $request->flash();
            return view('site.category', compact('category', 'posts', 'tags'));
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
            if (!session()->get($post['id'])) {
                $post_visit = new PostVisit();
                $post_visit->post_id = $post['id'];
                $post_visit->save();
                session([$post['id'] => $post['id']]);
            }
            return view('site.post', compact('post'));
        }
    }

    /**
     * Get page
     *
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function page($alias)
    {
        $page = Category::getCategoryByAlias($alias);
        if (empty($page)) {
            return redirect()->back();
        } else {
            if (!session()->get($page['id'])) {
                $category_visit = new CategoryVisit();
                $category_visit->category_id = $page['id'];
                $category_visit->save();
                session([$page['id'] => $page['id']]);
            }
            $content = $page->content;
            return view('site.page', compact('page', 'content'));
        }
    }

    /**
     * Get album images
     *
     * @param Request $request
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function album(Request $request, $alias)
    {
        $album = Category::getCategoryByAlias($alias);
        if (empty($album)) {
            return redirect()->back();
        } else {
            $images = Category::getAlbumImages($album['id'], 5, $request->input('search'));
            $request->flash();
            return view('site.album', compact('album', 'images'));
        }
    }
}
