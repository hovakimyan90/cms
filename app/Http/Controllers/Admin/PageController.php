<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PageController extends Controller
{
    /**
     * Search ang get pages
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pages = Category::getCategoriesByContentType(2, 10, $request->input('search'));
        $request->flash();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Create page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|unique:categories,name',
                'alias' => 'required|unique:categories,alias',
                'content' => 'required'
            ];
            Validator::make($request->all(), $rules)->validate();
            $page = new Category();
            $page->name = $request->input('name');
            $page->alias = $request->input('alias');
            $page->meta_keys = $request->input('meta_keys');
            $page->meta_desc = $request->input('meta_desc');
            if ($request->has('parent')) {
                $page->parent_id = $request->input('parent');
                $page->type = 2;
            } else {
                $page->type = 1;
            }
            $page->content_type = 2;
            $page->publish = $request->has('publish');
            $page->save();
            $page_content = new PageContent();
            $page_content->content = $request->input('content');
            $page_content->page_id = $page->id;
            $page_content->save();
            return redirect()->route('pages');
        } else {
            $pages = Category::getParentCategories();
            return view('admin.page.create', compact('pages'));
        }
    }

    /**
     * Edit page
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|unique:categories,name,' . $id,
                'alias' => 'required|unique:categories,alias,' . $id,
                'content' => 'required'
            ];
            Validator::make($request->all(), $rules)->validate();
            $page = Category::find($id);
            $page->name = $request->input('name');
            $page->alias = $request->input('alias');
            $page->meta_keys = $request->input('meta_keys');
            $page->meta_desc = $request->input('meta_desc');
            if ($request->has('parent')) {
                $page->parent_id = $request->input('parent');
                $page->type = 2;
            } else {
                $page->type = 1;
            }
            $page->publish = $request->has('publish');
            $page->save();
            $page_content = $page->content;
            $page_content->content = $request->input('content');
            $page_content->save();
            return redirect()->route('pages');
        } else {
            $page = Category::getCategoryById($id);
            if (empty($page)) {
                return redirect()->back();
            } else {
                $pages = Category::getParentCategories($id);
                return view('admin.page.edit', compact('pages', 'page'));
            }
        }
    }

    /**
     * Delete pages
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            foreach ($request->input('pages') as $page) {
                $page = Category::getCategoryById($page);
                if (!empty($page)) {
                    $page->delete();
                }
            }
        } else {
            $page = Category::getCategoryById($id);
            if (!empty($page)) {
                $page->delete();
            }
            return redirect()->back();
        }
    }

    public function export()
    {
        $data = array(array('Name', 'Alias', 'Meta keywords', 'Meta description', 'Parent', 'Publish', 'Views', 'Type'));
        $pages = Category::getCategoriesByContentType(2);
        foreach ($pages as $page) {
            $page_array = array();
            $name = $page['name'];
            array_push($page_array, $name);
            $alias = $page['alias'];
            array_push($page_array, $alias);
            if (empty($page['meta_keys'])) {
                $meta_keys = 'None';
            } else {
                $meta_keys = $page['meta_keys'];
            }
            array_push($page_array, $meta_keys);
            if (empty($page['meta_desc'])) {
                $meta_desc = 'None';
            } else {
                $meta_desc = $page['meta_desc'];
            }
            array_push($page_array, $meta_desc);
            if ($page['type'] == 1) {
                $parent = 'None';
            } else {
                $parent = Category::getCategoryById($page['parent_id'])['name'];
            }
            array_push($page_array, $parent);
            if ($page['publish'] == 1) {
                $publish = 'Published';
            } else {
                $publish = 'Unpublished';
            }
            array_push($page_array, $publish);
            $views = (string)$page->visits()->count();
            array_push($page_array, $views);
            if ($page['type'] == 1) {
                $type = 'Parent';
            } else {
                $type = 'Sub category';
            }
            array_push($page_array, $type);
            array_push($data, $page_array);
        }

        Excel::create('Pages', function ($excel) use ($data) {

            $excel->sheet('Pages', function ($sheet) use ($data) {

                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->cells('A1:H1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }
}
