<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Slider;
use App\CatePost;
use App\Product;

class HomeController extends Controller
{

 
    public function index(Request $request)
    {
        //post
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

        //slider
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(3)->get();
       
        //seo 
        $meta_desc = "Chuyen ban dong ho";
        $meta_keywords = "Dong ho dep lam, phu kien nua";
        $meta_title = " ABCD";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id','desc')->limit(9)->get();

        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category_post',$category_post);
        // return view('pages.home')->with(compact('cate_product','brand_product','all_product'));
    }
    public function search(Request $request){

        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //seo 
        $meta_desc = "Tim kiem san pham";
        $meta_keywords = "Tim kiem san pham";
        $meta_title = " Tim kiem san pham";
        $url_canonical = $request->url();

        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();

        return view('pages.sanpham.search')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('search_product',$search_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)->with('category_post',$category_post)->with('slider',$slider);


    }
   
    public function autocomplete_ajax(Request $request){
        $data = $request->all();

        if($data['query']){
            $product = Product::where('product_status','0')->where('product_name','LIKE','%'.$data['query'].'%')->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($product as $key => $val){
                $output.='<li><a href="#">'.$val->product_name.'</a></li>';
            }
            $output.='</ul>';
            echo $output;
        }
    }
    

}
