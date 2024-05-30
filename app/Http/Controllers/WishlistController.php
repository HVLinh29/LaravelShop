<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Wishlist;
use App\CategoryModel;
use App\Article;
use App\Slider;
use App\Brand;
class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {
        $product_id = $request->product_id;
        $customer_id = session('customer_id'); // Assuming the user is logged in

        $wishlist = new Wishlist();
        $wishlist->customer_id = $customer_id;
        $wishlist->product_id = $product_id;
        $wishlist->save();

        return response()->json(['message' => 'Đã thêm sản phẩm vào yêu thích']);
    }
    public function showWishlist(Request $request )
    {
        $category_post = Article::orderBy('article_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $category = CategoryModel::where('danhmuc_parent', 0)->orderBy('category_id', 'DESC')->get();
        $brand = Brand::where('thuonghieu_status', 0)->orderBy('brand_id', 'DESC')->get();
      
        // SEO
        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        // --SEO
        
        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderBy('brand_id','desc')->get(); 
        
        $customerId = session('customer_id');
        $wishlistItems = Wishlist::where('customer_id', $customerId)->get();
        
        return view('pages.sanpham.yeuthich', compact('wishlistItems', 'category_post', 'slider', 'meta_desc', 
        'meta_keywords', 'meta_title', 'url_canonical', 'cate_product', 'brand_product','category','brand'));
        
    }
    
}
