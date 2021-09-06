<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('admin.category.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.category.add')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        // dd($data);
        $category = Category::create($data);
        if ($category) {
            $message = 'message.add_category_success';
            return redirect()->route('category.index')->withMessage(__($message));
        } else {
            $message = 'message.add_category_fail';
            return redirect()->route('category.index')->withMessage(__($message));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categoryid)
    {
        //
        $category = $this->findCategory($categoryid);
        $categories = Category::all();
        if ($category) {
            return view('admin.category.edit', compact('category', 'categories'));
        } else {
            $errors = 'message.no_category';
            return redirect()->route('homeadmin.index')->withErrors(__($errors));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $categoryid)
    {
        //
        $category = $this->findCategory($categoryid);
        $data = $request->all();
        $category->update($data);
        if ($category) {
            $message = 'message.update_category_success';
            return redirect()->route('category.edit', $category->id)->withMessage(__($message));
        } else {
            $message = 'message.update_category_fail';
            return redirect()->route('category.edit', $category->id)->withMessage(__($message));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoryid)
    {
        //
        $category = $this->findCategory($categoryid);
        $category->delete();
        $message = 'message.delete_category_success';
        return redirect()->route('category.index')->withMessage(__($message));
    }

    public function findCategory($categoryid)
    {
        $category = Category::find($categoryid);
        if ($category) {
            return $category;
        } else {
            $errors = 'message.no_category';
            return redirect()->route('homeadmin.index')->withErrors(__($errors));
        }
    }
}
