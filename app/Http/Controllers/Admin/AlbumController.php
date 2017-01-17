<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AlbumController extends Controller
{
    /**
     * Show all albums
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $albums = Category::getCategoriesByContentType(3, 10, $request->input('search'));
        $request->flash();
        return view('admin.album.index', compact('albums'));
    }

    /**
     * Create new albums
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
            $album = new Category();
            $album->name = $request->input('name');
            $album->alias = $request->input('alias');
            $album->meta_keys = $request->input('meta_keys');
            $album->meta_desc = $request->input('meta_desc');
            $album->content_type = 3;
            if ($request->has('parent')) {
                $album->parent_id = $request->input('parent');
                $album->type = 2;
            } else {
                $album->type = 1;
            }
            $album->publish = $request->has('publish');
            $album->save();
            return redirect()->route('albums');
        } else {
            $albums = Category::getParentCategories();
            return view('admin.album.create', compact('albums'));
        }
    }

    /**
     * Edit album
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
            $album = Category::find($id);
            $album->name = $request->input('name');
            $album->alias = $request->input('alias');
            $album->meta_keys = $request->input('meta_keys');
            $album->meta_desc = $request->input('meta_desc');
            if ($request->has('parent')) {
                $album->parent_id = $request->input('parent');
                $album->type = 2;
            } else {
                $album->type = 1;
            }
            $album->publish = $request->has('publish');
            $album->save();
            return redirect()->route('albums');
        } else {
            $album = Category::getCategoryById($id);
            if (empty($album)) {
                return redirect()->back();
            } else {
                $albums = Category::getParentCategories($id);
                return view('admin.album.edit', compact('albums', 'album'));
            }
        }
    }

    /**
     * Delete album
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            foreach ($request->input('albums') as $album) {
                $album = Category::getCategoryById($album);
                if (!empty($album)) {
                    $album->delete();
                }
            }
        } else {
            $album = Category::getCategoryById($id);
            if (!empty($album)) {
                $album->delete();
            }
            return redirect()->back();
        }
    }

    /**
     * Export albums
     */
    public function export()
    {
        $data = array(array('Name', 'Alias', 'Meta keywords', 'Meta description', 'Parent', 'Publish', 'Posts Count', 'Views', 'Type'));
        $albums = Category::getCategoriesByContentType(3);
        foreach ($albums as $album) {
            $album_array = array();
            $name = $album['name'];
            array_push($album_array, $name);
            $alias = $album['alias'];
            array_push($album_array, $alias);
            if (empty($album['meta_keys'])) {
                $meta_keys = 'None';
            } else {
                $meta_keys = $album['meta_keys'];
            }
            array_push($album_array, $meta_keys);
            if (empty($album['meta_desc'])) {
                $meta_desc = 'None';
            } else {
                $meta_desc = $album['meta_desc'];
            }
            array_push($album_array, $meta_desc);
            if ($album['type'] == 1) {
                $parent = 'None';
            } else {
                $parent = Category::getCategoryById($album['parent_id'])['name'];
            }
            array_push($album_array, $parent);
            if ($album['publish'] == 1) {
                $publish = 'Published';
            } else {
                $publish = 'Unpublished';
            }
            array_push($album_array, $publish);
            $images_count = (string)$album->images()->count();
            array_push($album_array, $images_count);
            $views = (string)$album->visits()->count();
            array_push($album_array, $views);
            if ($album['type'] == 1) {
                $type = 'Parent';
            } else {
                $type = 'Sub category';
            }
            array_push($album_array, $type);
            array_push($data, $album_array);
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
