<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\WishList;

class IndexController extends Controller
{

    public function index()
    {
        $productHot = Product::where("hot", 1)->where("status", 1)->get();
        $category = Category::with('sub_category')->get();
        $product = Product::getProduct();
        $productAll = Product::productAll();
        return view('user.index', compact('category', 'productHot', 'product', 'productAll'));
    }


    public function getProductBySearch(Request $request)
    {
        $category = Category::with('sub_category')->get();

        // $data['getColor'] = Color::getColorActive();
        $data['getBrand'] = Brand::getbrand();

        $data['product'] = Product::getProductBySlug();

        // $product = Product::getProductBySearch($request->q);
        // return response()->json($request->all());
        return view('user.product.list', compact('category'), $data);
    }

    public function getProductCategoryById(Request $request)
    {
        if (!empty($request->category_id)) {
            $productByCategoryId = Product::getProductCategoryById($request->category_id, 8);
            $countProductByCategoryId = Product::getAllProductByCategoryId($request->category_id);
            $categoryId = $request->category_id;

            $view = view("user.product.product_by_category", [
                "countProductByCategoryId" => $countProductByCategoryId,
                "productByCategoryId" => $productByCategoryId,
                "categoryId" => $categoryId
            ])->render();

            return response()->json([
                'view' => $view,
                'status' => 'success'
            ], 200);
        }
    }


    public function getSeeMoreProductCategoryById(Request $request)
    {
        if (!empty($request->category_id) && !empty($request->limit)) {
            $productByCategoryId = Product::getProductCategoryById($request->category_id, $request->limit);
            $countProductByCategoryId = Product::getAllProductByCategoryId($request->category_id);
            $categoryId = $request->category_id;

            $view = view("user.product.see_more_product_by_category", [
                "countProductByCategoryId" => $countProductByCategoryId,
                "productByCategoryId" => $productByCategoryId,
                "categoryId" => $categoryId
            ])->render();

            return response()->json([
                'view' => $view,
                'status' => 'success'
            ], 200);
        }
    }

    public function seeMoreProductHome(Request $request)
    {
        if (!empty($request->limit)) {

            $productSeeMoreHome = Product::seeMoreProductHome($request->limit);

            $view = view("user.product.see_more_product_home", [
                "productSeeMoreHome" => $productSeeMoreHome,
            ])->render();

            return response()->json([
                'view' => $view,
                'status' => 'success'
            ], 200);
        }
    }
    public function getProducts()
    {
        $category = Category::with('sub_category')->get();

        $data['getBrand'] = Brand::getbrand();

        $data['product'] = Product::getProductBySlug();


        return view('user.product.list', compact('category'), $data);
    }

    public function getCategory($slug, $subslug = null)
    {
        $category = Category::with('sub_category')->get();
        $category_slug = Category::where('slug', $slug)->where('status', 1)->first();
        $category_subslug = Subcategory::where('slug', $subslug)->where('status', 1)->first();
        // $data['getColor'] = Color::getColorActive();
        $data['getBrand'] = Brand::getbrand();


        // Sản phẩm chi tiết
        $productDetail = Product::productDetailBySlug($slug);
        if (!empty($productDetail)) {
            $data['meta_title'] = $productDetail->title;
            $data['meta_description'] = $productDetail->short_description;

            $data['productDetail'] = $productDetail;
            $data['relatedProducts'] = Product::getRelatedProduct($productDetail->id, $productDetail->category_id);

            $data['getReviewByProductSlug'] = Product::getReviewByProductSlug($slug);
            // return response()->json($data['productDetail']);

            return view('user.product.detail', compact('category'), $data);
        }

        // danh mục ra sản phẩm
        if (!empty($category_slug) && !empty($category_subslug)) {
            $data['category_slug'] = $category_slug;
            $data['category_subslug'] = $category_subslug;

            $data['meta_title'] = $category_subslug->name;
            $data['meta_description'] = $category_subslug->meta_description;
            $data['meta_keywords'] = $category_subslug->meta_keywords;

            $data['product'] = Product::getProductBySlug($category_slug->id, $category_subslug->id);

            $data['getSubCategoryFilter'] = Subcategory::getSubCategoryCategory_id($category_slug->id);

            return view('user.product.list', compact('category'), $data);
        } else if (!empty($category_slug)) {
            $data['category_slug'] = $category_slug;
            $data['product'] = Product::getProductBySlug($category_slug->id);

            $data['getSubCategoryFilter'] = Subcategory::getSubCategoryCategory_id($category_slug->id);
            // return response()->json($data['getSubCategory']);

            return view('user.product.list', compact('category'), $data);
        } else {
            abort(404);
        }
    }

    public function getFilterProductAjax(Request $request)
    {
        $product = Product::getProductBySlug();
        $count = count($product);

        if ($count > 0) {
            return response()->json([
                "status" => true,
                "success" => view("user.product.__product_filter", [
                    "product" => $product
                ])->render(),
            ], 200);
        } else {
            return response()->json([
                "status" => true,
                "success" => view("user.product.__product_filter_no_product", [
                    "product" => $product
                ])->render(),
            ], 200);
        }
    }
}
