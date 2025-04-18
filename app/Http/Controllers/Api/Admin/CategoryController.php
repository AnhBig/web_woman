<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Danh sách danh mục
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Thêm danh mục
     *
     * @bodyParam name string required Tên của danh mục.
     * @bodyParam slug string required Slug của danh mục.
     * @bodyParam status tinyinteger Trạng thái của danh mục (1 là Hiện, 0 là Ẩn). Mặc định là 1 nếu không được cung cấp.
     */

    public function store(Request $request)
    {
        // Validation dữ liệu
        $validatedData = $request->validate([
            'name' => 'required|unique:category',
            'slug' => 'required|unique:category',
            'status' => 'nullable|integer|min:0|max:1'
        ], [
            'name.required' => 'Vui lòng nhập tên !',
            'slug.required' => 'Vui lòng nhập slug !',
            'name.unique' => 'Tên đã tồn tại !',
            'slug.unique' => 'Slug đã tồn tại !',
            'status.integer' => 'Trạng thái phải là số !',
            'status.max' => 'Trường trạng thái không được lớn hơn 1!',
            'status.min' => 'Trường trạng thái không được là số âm!',
        ]);

        $validatedData['status'] = isset($validatedData['status']) ? (int)$validatedData['status'] : 1;

        // Thêm danh mục
        $data = [
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'status' => isset($validatedData['status']) ? (int)$validatedData['status'] : 1
        ];

        $category = Category::create($data);
        return response()->json($category);
    }


    /**
     * Xem chi tiết danh mục
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Không tìm thấy danh mục'], status: 404);
        }
        return response()->json($category);
    }

    /**
     * Cập nhật danh mục
     * 
     * @bodyParam name string required Tên của danh mục.
     * @bodyParam slug string required Slug của danh mục.
     * @bodyParam status tinyinteger Trạng thái của danh mục (1 là Hiện, 0 là Ẩn). Mặc định là 1 nếu không được cung cấp.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|unique:category,name,' . $id,
                'slug' => 'required|unique:category,slug,' . $id,
                'status' => 'nullable|integer|min:0|max:1'
            ],
            [
                'name.required' => 'Vui lòng nhập tên !',
                'slug.required' => 'Vui lòng nhập slug !',
                'name.unique' => 'Tên đã tồn tại !',
                'slug.unique' => 'Slug đã tồn tại !',
                'status.integer' => 'Trạng thái phải là số !',
                'status.max' => 'Trường trạng thái không được lớn hơn 1!',
                'status.min' => 'Trường trạng thái không được là số âm!',
            ]
        );

        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], status: 404);
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);

        return response()->json($category);
    }

    /**
     * Xóa danh mục
     * 
     *@response Category
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}
