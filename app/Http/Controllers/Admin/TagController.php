<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TagController extends Controller
{

    /**
     * Show all tags
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $tags = Tag::getTags(10, $request->input('search'));
        } else {
            $tags = Tag::getTags(10);
        }
        return view('admin.tag.index')->with(compact('tags'));
    }

    /**
     * Create tag
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|unique:tags,name'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            } else {
                $tag = new Tag();
                $tag->name = $request->input('name');
                $tag->save();
                return redirect()->back();
            }
        } else {
            return view('admin.tag.create');
        }
    }

    /**
     * Edit tag
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function edit(Request $request, $id = 0)
    {
        $tag = Tag::getTagById($id);
        if (empty($tag)) {
            return redirect()->back();
        } else {
            if ($request->isMethod('post')) {
                $rules = [
                    'name' => 'required|unique:tags,name,' . $id
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors());
                } else {
                    $tag->name = $request->input('name');
                    $tag->save();
                    return redirect()->back();
                }
            } else {
                return view('admin.tag.edit', compact('tag'));
            }
        }
    }

    /**
     * Delete tag
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function delete(Request $request, $id = 0)
    {
        if ($request->isMethod('post')) {
            foreach ($request->input('tags') as $tag) {
                $tag = Tag::getTagById($tag);
                if (!empty($tag)) {
                    $tag->delete();
                }
            }
        } else {
            $tag = Tag::getTagById($id);
            if (!empty($tag)) {
                $tag->delete();
            }
        }
        return redirect()->back();
    }

    /**
     * Export tags
     */
    public function export()
    {
        $data = array(array('Name'));
        $tags = Tag::getTags();
        foreach ($tags as $tag) {
            $tag_array = array();
            $name = $tag['name'];
            array_push($tag_array, $name);
            array_push($data, $tag_array);
        }

        Excel::create('Tags', function ($excel) use ($data) {

            $excel->sheet('Tags', function ($sheet) use ($data) {

                $sheet->fromArray($data, null, 'A1', false, false);

                $sheet->cells('A1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });

        })->export('xls');
    }
}
