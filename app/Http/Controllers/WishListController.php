<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function wishList()
    {
        $wishlists = WishList::with('product')->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        // return response()->json($wishlists);
        return view('user.wishlist.wishlist', compact('wishlists'));
    }

    public function addProductWishList(Request $request)
    {
        if (!empty($request->product_id) && !empty($request->user_id)) {
            $wishlist = WishList::where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)
                ->first();

            if (!$wishlist) {
                $wishlist = new WishList();
                $wishlist->product_id = $request->product_id;
                $wishlist->user_id = $request->user_id;
                $wishlist->save();

                $countWishlist = WishList::wishlistAll()->count();

                return response()->json([
                    "status" => "success",
                    'count' => "($countWishlist)",
                    "message" => "Đã thêm sản phẩm yêu thích"
                ]);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Sản phẩm này đã có trong danh sách yêu thích"
                ]);
            }
        }
    }

    public function removeWishlist($id)
    {
        if (!empty($id)) {
            $wishlist = WishList::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->first();
            if ($wishlist) {
                $wishlist->delete();
                return redirect()->back()->with('success', 'Xoá sản phẩm thành công !');
            }

            $wishlists = WishList::wishlistAll();
            if (count($wishlists) == 0) {
                return redirect("/")->with('success', 'Danh sách yêu thích trống !');
            }
        }
    }
}
