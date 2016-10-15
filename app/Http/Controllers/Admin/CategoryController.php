<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Show all categories
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = Category::getCategoriesByContentType(1, 10, $request->input('search'));
        $request->flash();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Create category
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|unique:categories,name',
                'alias' => 'required|unique:categories,alias'
            ];
            Validator::make($request->all(), $rules)->validate();
            $category = new Category();
            $category->name = $request->input('name');
            $category->alias = $request->input('alias');
            $category->meta_keys = $request->input('meta_keys');
            $category->meta_desc = $request->input('meta_desc');
            $category->content_type = 1;
            if ($request->has('parent')) {
                $category->parent_id = $request->input('parent');
                $category->type = 2;
            } else {
                $category->type = 1;
            }
            $category->publish = $request->has('publish');
            $category->save();
            return redirect()->route('categories');
        } else {
            $categories = Category::getParentCategories();
            return view('admin.category.create', compact('categories'));
        }
    }

    /**
     * Edit category
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
                'alias' => 'required|unique:categories,alias,' . $id
            ];
            Validator::make($request->all(), $rules)->validate();
            $category = Category::find($id);
            $category->name = $request->input('name');
            $category->alias = $request->input('alias');
            $category->meta_keys = $request->input('meta_keys');
            $category->meta_desc = $request->input('meta_desc');
            if ($request->has('parent')) {
                $category->parent_id = $request->input('parent');
                $category->type = 2;
            } else {
                $category->type = 1;
            }
            $category->publish = $request->has('publish');
            $category->save();
            return redirect()->route('categories');
        } else {
            $category = Category::getCategoryById($id);
            if (empty($category)) {
                return redirect()->back();
            } else {
                $categories = Category::getParentCategories($id);
                return view('admin.category.edit', compact('categories', 'category'));
            }
        }
    }

    /**
     * Delete category
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            foreach ($request->input('categories') as $category) {
                $category = Category::getCategoryById($category);
                if (!empty($category)) {
                    $category->delete();
                }
            }
        } else {
            $category = Category::getCategoryById($id);
            if (!empty($category)) {
                $category->delete();
            }
            return redirect()->back();
        }
    }

    /**
     * Export categories
     */
    public function export()
    {
        $data = array(array('Name', 'Alias', 'Meta keywords', 'Meta description', 'Parent', 'Publish', 'Posts Count', 'Views', 'Type'));
        $categories = Category::getCategoriesByContentType(1);
        foreach ($categories as $category) {
            $category_array = array();
            $name = $category['name'];
            array_push($category_array, $name);
            $alias = $category['alias'];
            array_push($category_array, $alias);
            if (empty($category['meta_keys'])) {
                $meta_keys = 'None';
            } else {
                $meta_keys = $category['meta_keys'];
            }
            array_push($category_array, $meta_keys);
            if (empty($category['meta_desc'])) {
                $meta_desc = 'None';
            } else {
                $meta_desc = $category['meta_desc'];
            }
            array_push($category_array, $meta_desc);
            if ($category['type'] == 1) {
                $parent = 'None';
            } else {
                $parent = Category::getCategoryById($category['parent_id'])['name'];
            }
            array_push($category_array, $parent);
            if ($category['publish'] == 1) {
                $publish = 'Published';
            } else {
                $publish = 'Unpublished';
            }
            array_push($category_array, $publish);
            $posts_count = (string)$category->posts()->count();
            array_push($category_array, $posts_count);
            $views = (string)$category->visits()->count();
            array_push($category_array, $views);
            if ($category['type'] == 1) {
                $type = 'Parent';
            } else {
                $type = 'Sub category';
            }
            array_push($category_array, $type);
            array_push($data, $category_array);
        }

        Excel::create('Categories', function ($excel) use ($data) {

            $excel->sheet('Categories', function ($sheet) use ($data) {

                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->cells('A1:I1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }
}
