<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

use Auth;
use App\CatePost;
use App\Gallery;
use App\Slider;
use App\Product;
use App\Comment;
use App\Rating;
use File;

class ProductController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Auth::id();

        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function add_product()
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

        return view('admin.sanpham.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }
    public function all_product()
    {
        $this->AuthLogin();

        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->orderBy('tbl_product.product_id', 'desc')->get();
        $manager_product = view('admin.sanpham.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }
    public function save_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();

        $product_price = filter_var($request->product_price,FILTER_SANITIZE_NUMBER_INT);
        $product_cost = filter_var($request->product_cost,FILTER_SANITIZE_NUMBER_INT);


        $data['product_name'] = $request->product_name;
        $data['product_tags'] = $request->product_tags;
        $data['product_slug'] = $request->product_slug;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_price'] = $product_price;
        $data['product_cost'] = $product_cost;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');

        $path = 'public/uploads/product/';
        $path_gallery = 'public/uploads/gallery/';
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            File::copy($path . $new_image, $path_gallery . $new_image);
            $data['product_image'] = $new_image;
        }

        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_name = $new_image;
        $gallery->gallery_image = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();

        Session::put('message', 'Thêm sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Không kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function active_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $manager_product = view('admin.sanpham.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product)
            ->with('brand_product', $brand_product);
        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }
    public function update_product(Request $request, $product_id)
    {
        $this->AuthLogin();
        $data = array();
        $product_price = filter_var($request->product_price,FILTER_SANITIZE_NUMBER_INT);
        $product_cost = filter_var($request->product_cost,FILTER_SANITIZE_NUMBER_INT);
        
        $data['product_name'] = $request->product_name;
        $data['product_tags'] = $request->product_tags;
        $data['product_slug'] = $request->product_slug;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_price'] = $product_price;
        $data['product_cost'] = $product_cost;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_imgae = current(explode('.', $get_name_image));
            $new_image = $name_imgae . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }

    //Trang chu giao dien
    public function details_product(Request $request, $product_slug)
    {

        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $details_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_product.product_slug', $product_slug)->get();

        foreach ($details_product as $key => $val) {
            $category_id = $val->category_id;
            $product_id = $val->product_id;
            $product_cate = $val->category_name;
            $cate_slug = $val->category_slug;
            //seo 
            $meta_desc = "$val->product_desc";
            $meta_keywords = "$val->product_slug";
            $meta_title = "$val->product_name";
            $url_canonical = $request->url();
            //--seo
        }

        //gallery
        $gallery = Gallery::where('product_id', $product_id)->get();

        //update view
        $product = Product::where('product_id', $product_id)->first();
        $product->product_view = $product->product_view + 1;
        $product->save();

        $splienquan = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_slug', [$product_slug])->get();

        $rating = Rating::where('product_id', $product_id)->avg('rating');
        $rating = round($rating);
        $ratingCount = Rating::where('product_id', $product_id)->count();

        return view('pages.sanpham.show_details')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('product_details', $details_product)->with('splienquan', $splienquan)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('category_post', $category_post)
            ->with('gallery', $gallery)->with('slider', $slider)->with('product_cate', $product_cate)
            ->with('cate_slug', $cate_slug)->with('rating', $rating)->with('ratingCount', $ratingCount);
    }
    public function tag(Request $request, $product_tag)
    {
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $tag = str_replace("-", "", $product_tag);
        $pro_tag = Product::where('product_status', '0')->where('product_name', 'LIKE', '%' . $tag . '%')
            ->orWhere('product_tags', 'LIKE', '%' . $tag . '%')->orWhere('product_slug', 'LIKE', '%' . $tag . '%')->get();

        $meta_desc = 'Tags:' . $product_tag;
        $meta_keywords = 'Tags:' . $product_tag;
        $meta_title = 'Tags:' . $product_tag;
        $url_canonical = $request->url();



        return view('pages.sanpham.tag')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('slider', $slider)->with('category_post', $category_post)->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
            ->with('product_tag', $product_tag)->with('pro_tag', $pro_tag);
    }
    public function quickview(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $gallery = Gallery::where('product_id', $product_id)->get();
        $output['product_gallery'] = '';
        foreach ($gallery as $ket => $gal) {
            $output['product_gallery'] .= '<p><img  width="100%" src="public/uploads/gallery/' . $gal->gallery_image . '"> </p>';
        }

        $output['product_name'] = $product->product_name;
        $output['product_id'] = $product->product_id;
        $output['product_price'] = number_format($product->product_price, 0, ',', '.') . 'VND';
        $output['product_desc'] = $product->product_desc;
        $output['product_content'] = $product->product_content;
        $output['product_image'] = '<p><img width="100%" src="public/uploads/product/' . $product->product_image . '"</p>';

        $output['product_button'] = ' <input type="button" value="Mua ngay"
        class="btn btn-success btn-sm add-to-cart-quickview" 
        data-id_product="' . $product->product_id . '"  name="add-to-cart">';

        $output['product_quickview_value'] = '
        <input type="hidden" value="' . $product->product_id . '"
                class="cart_product_id_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_name . ' }}"
                class="cart_product_name_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_quantity . ' }}"
                class="cart_product_quantity_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_image . ' }}"
                class="cart_product_image_' . $product->product_id . '">   
        <input type="hidden" value="' . $product->product_price . ' }}"
                 class="cart_product_price_' . $product->product_id . '">                  
        <input type="hidden" value="1"
                class="cart_product_qty_' . $product->product_id . '">';
        echo json_encode($output);
    }
    public function load_comment(Request $request)
    {
        $product_id = $request->product_id;

        $comment = Comment::where('comment_product_id', $product_id)->where('comment_parent_comment', '=', 0)->where('comment_status', 0)->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment', '>', 0)->get();
        $output = '';
        foreach ($comment as $key => $com) {
            $output .= '
            <div class="row style_comment">
            <div class="col-md-2">
            <img width="100%" src="' . url('/public/fontend/images/download.png') . '" class="img img-responsive img-thumbnail">
        </div>
        <div class="col-md-10">
            <p style="color: green">@' . $com->comment_name . '</p>
            <p style="color: #000">@' . $com->comment_date . '</p>
            <p>' . $com->comment . '</p>
        </div>
            </div><p></p>
';
            foreach ($comment_rep as $key => $rep_comment) {

                if ($rep_comment->comment_parent_comment == $com->comment_id) {
                    $output .= '
            <div class="row style_comment" style="margin:5px 40px">
            <div class="col-md-2">
            <img width="60%" src="' . url('/public/fontend/images/images.png') . '" class="img img-responsive img-thumbnail">
        </div>
        <div class="col-md-10">
            <p style="color: brown">@Admin</p>
            <p style="color: #000">' . $rep_comment->comment . '</p>
            <p></p>
        </div>
            </div><p></p>
            ';
                }
            }
        }
        echo $output;
    }
    public function send_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $comment = new Comment();
        $comment->comment_product_id = $product_id;
        $comment->comment_name = $comment_name;
        $comment->comment = $comment_content;
        $comment->comment_status = 1;
        $comment->comment_parent_comment = 0;
        $comment->save();
    }
    public function list_comment()
    {
        $comment = Comment::with('product')->orderBy('comment_status', 'desc')->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment', '>', 0)->get();
        return view('admin.comment.list_comment')->with(compact('comment', 'comment_rep'));
    }
    public function duyet_comment(Request $request)
    {
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();
    }
    public function reply_comment(Request $request)
    {
        $data = $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->comment_name = 'Admin';
        $comment->comment_status = 0;
        $comment->save();
    }
    public function delete_comment($comment_id)
    {
        // Kiểm tra xem comment_id có tồn tại không
        if ($comment_id) {
            // Xóa bình luận từ CSDL
            $deleted = Comment::where('comment_id', $comment_id)->delete();

            // Kiểm tra xem xóa bình luận thành công hay không
            if ($deleted) {
                // Nếu xóa thành công, chuyển hướng về trang trước đó hoặc trang chính của ứng dụng của bạn
                return redirect()->back()->with('success', 'Bình luận đã được xóa thành công.');
            } else {
                // Nếu xóa không thành công, thông báo lỗi
                return redirect()->back()->with('error', 'Xóa bình luận thất bại. Vui lòng thử lại sau.');
            }
        } else {
            // Nếu không có comment_id được cung cấp, thông báo lỗi
            return redirect()->back()->with('error', 'Không tìm thấy bình luận cần xóa.');
        }
    }
    public function insert_rating(Request $request)
    {
        $data = $request->all();
        $rating = new Rating();
        $rating->product_id = $data['product_id'];
        $rating->rating = $data['index'];
        $rating->save();
        return 'done';
    }
}
