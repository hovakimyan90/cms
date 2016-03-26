<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
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
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $categories = Category::getCategories(10, $request->input('search'));
        } else {
            $categories = Category::getCategories(10);
        }
        return view('admin.category.index')->with(compact('categories'));
    }

    /**
     * Create category
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|unique:categories,name',
                'alias' => 'required|unique:categories'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $category = new Category();
                $category->name = $request->input('name');
                $category->alias = $request->input('alias');
                $category->meta_keys = $request->input('meta_keys');
                $category->meta_desc = $request->input('meta_desc');
                if (!empty($request->input('parent_id'))) {
                    $category->parent_id = $request->input('parent_id');
                    $category->type = 'sub';
                } else {
                    $category->type = 'parent_id';
                }
                $category->publish = $request->has('publish');
                $category->save();
                return redirect()->route('categories');
            }
        } else {
            $categories = Category::getParentCategories();
            return view('admin.category.create')->with(compact('categories'));
        }
    }

    /**
     * Edit category
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function edit(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|unique:categories,name,' . $id,
                'alias' => 'required|unique:categories,alias,' . $id
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $category = Category::find($id);
                $category->name = $request->input('name');
                $category->alias = $request->input('alias');
                $category->meta_keys = $request->input('meta_keys');
                $category->meta_desc = $request->input('meta_desc');
                if (!empty($request->input('parent_id'))) {
                    $category->parent_id = $request->input('parent_id');
                    $category->type = 'sub';
                } else {
                    $category->type = 'parent_id';
                }
                $category->publish = $request->has('publish');
                $category->save();
                return redirect()->route('categories');
            }
        } else {
            $category = Category::getCategoryById($id);
            if (empty($category)) {
                return redirect()->back();
            } else {
                $categories = Category::getParentCategories($id);
                return view('admin.category.edit')->with(compact('categories', 'category'));
            }
        }
    }

    /**
     * Delete category
     *
     * @param Request $request
     * @param int $id
     * @return mixed
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
        $data = array(array('Name', 'Alias', 'Meta keywords', 'Meta description', 'Parent', 'Publish', 'Posts Count', 'Type'));
        $categories = Category::getCategories();
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
            if ($category['parent_id'] == 0) {
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
            $posts_count = $category->posts()->count();
            array_push($category_array, $posts_count);
            if ($category['type'] == 'parent_id') {
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

                $sheet->cells('A1:G1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }
}
