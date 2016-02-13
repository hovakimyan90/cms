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
     * @return $this
     */
    public function index(Request $request)
    {
        if ($request->method() == 'POST') {
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
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            $rules = [
                'name' => 'required|unique:categories',
                'alias' => 'unique:categories'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $category = new Category();
                $category->name = $request->input('name');
                $category->alias = $request->input('alias');
                if (!empty($request->input('parent'))) {
                    $category->parent = $request->input('parent');
                    $category->type = 'sub';
                } else {
                    $category->type = 'parent';
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
     * Edit category by id
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        if ($request->method() == 'POST') {
            $rules = [
                'name' => 'required|unique:categories,name,' . $id,
                'alias' => 'unique:categories,alias,' . $id
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $category = Category::find($id);
                $category->name = $request->input('name');
                $category->alias = $request->input('alias');
                if (!empty($request->input('parent'))) {
                    $category->parent = $request->input('parent');
                    $category->type = 'sub';
                } else {
                    $category->type = 'parent';
                }
                $category->publish = $request->has('publish');
                $category->save();
                return redirect()->route('categories');
            }
        } else {
            $category = Category::getCategory($id);
            if (empty($category)) {
                return redirect()->back();
            } else {
                $category = $category->toArray();
            }
            $categories = Category::getParentCategories($id);
            return view('admin.category.edit')->with(compact('categories', 'category'));
        }
    }

    /**
     * Delete category by id
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id = 0)
    {
        if ($request->method() == 'POST') {
            foreach ($request->input('categories') as $category) {
                $category = Category::getCategory($category);
                if (!empty($category)) {
                    $category->delete();
                }
            }
        } else {
            $category = Category::getCategory($id);
            if (!empty($category)) {
                $category->delete();
            }
        }
        return redirect()->back();
    }

    /**
     * Export all categories to excel
     */
    public function export()
    {
        $data = array(array('Name', 'Alias', 'Parent', 'Publish', 'Type'));
        $categories = Category::getCategories();
        foreach ($categories as $category) {
            $category_array = array();
            $name = $category['name'];
            array_push($category_array, $name);
            if (empty($category['alias'])) {
                $alias = "None";
            } else {
                $alias = $category['alias'];
            }
            array_push($category_array, $alias);
            if ($category['parent'] == 0) {
                $parent = 'None';
            } else {
                $parent = Category::getCategory($category['parent'])['name'];
            }
            array_push($category_array, $parent);
            if ($category['publish'] == 1) {
                $publish = 'Published';
            } else {
                $publish = 'Unpublished';
            }
            array_push($category_array, $publish);
            if ($category['type'] == 'parent') {
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

                $sheet->cells('A1:E1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }
}
