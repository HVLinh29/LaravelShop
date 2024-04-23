<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;

use App\Exports\ExcelExports;
use Excel;
use App\Imports\Imports;
use App\CategoryModel;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\CatePost;
use Auth;
class CategoryPost extends Controller
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

    public function add_category_post(){
        $this->AuthLogin();
        return view('admin.category_post.add_cate_post');
    }
    public function save_category_post(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        
        $category_post = new CatePost();
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        $category_post->cate_post_slug = $data['cate_post_slug'];
      
        $category_post->save();
        Session::put('message','Thêm danh mục bai viet thành công');
        return redirect('/list-category-post');

    }
    public function list_category_post(){
        $this->AuthLogin();
        $category_post = CatePost::orderBy('cate_post_id','DESC')->get();
       
        return view('admin.category_post.list_category_post')->with(compact('category_post'));
    }
    public function danh_muc_bai_viet($cate_post_slug){

    }
    public function edit_category_post($cate_post_id){
        $this->AuthLogin();
        $category_post = CatePost::find($cate_post_id);
       
        return view('admin.category_post.edit_cate_post')->with(compact('category_post'));
    }
    public function update_category_post(Request $request,$cate_id){
        
        $data = $request->all();
        $category_post = CatePost::find($cate_id);
      
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        $category_post->cate_post_slug = $data['cate_post_slug'];
      
        $category_post->save();
        Session::put('message','Cap nhat danh mục bai viet thành công');
        return redirect('/list-category-post');
    }
    public function delete_category_post($cate_id){
        $category_post = CatePost::find($cate_id);
        $category_post->delete();
        Session::put('message','Xóa danh mục bai viet thành công');
        return redirect('/list-category-post');
    }
}
