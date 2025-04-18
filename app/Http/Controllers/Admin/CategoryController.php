<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::getCategory();
        return view('admin.category.list', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:category',
            'slug' => 'required|unique:category',
            'status' => 'nullable'
        ], [
            'name.required' => 'Vui lòng nhập tên !',
            'slug.required' => 'Vui lòng nhập slug !',
            'name.unique' => 'Tên đã tồn tại !',
            'slug.unique' => 'Slug đã tồn tại !'
        ]);

        $category = new Category();
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->status = $data['status'];

        $category->save();

        return redirect('admin/category')->with("success", "Thêm danh mục thành công");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);


        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:category,name,' . $id,
            'slug' => 'required|unique:category,slug,' . $id,
            'status' => 'nullable'
        ], [
            'name.required' => 'Vui lòng nhập tên !',
            'slug.required' => 'Vui lòng nhập slug !',
            'name.unique' => 'Tên đã tồn tại !',
            'slug.unique' => 'Slug đã tồn tại !'
        ]);

        $category = Category::find($id);
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->status = $data['status'];
        $category->save();

        return redirect('admin/category')->with("success", "Cập nhật danh mục thành công");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect('admin/category')->with("success", "Xóa danh mục thành công");
    }
}
