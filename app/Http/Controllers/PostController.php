<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use Auth;
use App\Post;
use App\CatePost;
class PostController extends Controller
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
    public function add_post(){
        $this->AuthLogin();
        $cate_post =CatePost::orderBy('cate_post_id','DESC')->get();
     
      
        return view('admin.post.add_post')->with(compact('cate_post'));
    }
    public function save_post(Request $request){
        $this->AuthLogin();
        $data = $request->all();
       $post = new Post();
       $post->post_title = $data['post_title'];
       $post->post_desc = $data['post_desc'];
       $post->post_content = $data['post_content'];
       $post->post_meta_desc = $data['post_meta_desc'];
       $post->post_meta_keywords = $data['post_meta_keywords']; 
       $post->cate_post_id = $data['cate_post_id'];
       $post->post_slug = $data['post_slug'];
       $post->post_status = $data['post_status'];

        $get_image = $request->file('post_image');
        if($get_image){
            $get_name_image =$get_image->getClientOriginalName();// lay ten cua hinh anh do
            $name_imgae= current(explode('.',$get_name_image)); 
            $new_image = $name_imgae.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/post',$new_image);

            $post->post_image = $new_image;

         $post->save();
            Session::put('message','Thêm bai viet thành công');
            return redirect('/list-post');
        }else{
            Session::put('message','Ban hay them hinh anh cho bai viet');
            return redirect('/list-post');
        }
       

    }
    public function list_post(){
        $this->AuthLogin();
        $all_post=Post::with('cate_post')->orderBy('post_id')->get();
        
        return view('admin.post.list_post')->with(compact('all_post',$all_post));
    }
    public function delete_post($post_id){
        $post = Post::find($post_id);
        $post_image = $post->post_image;
        if($post_image){
            $path = 'public/uploads/post/'.$post_image;
            unlink($path);
        }
        $post->delete();
       
        Session::put('message','Xóa  bai viet thành công');
        return redirect('/list-post');
    }
    public function edit_post($post_id){
        $cate_post = CatePost::orderBy('cate_post_id')->get();
        $post = Post::find($post_id);
        return view('admin.post.edit_post')->with(compact('post','cate_post'));
    }
    public function update_post(Request $request,$post_id){
        $this->AuthLogin();
        $data = $request->all();
       $post = Post::find($post_id);
       $post->post_title = $data['post_title'];
       $post->post_desc = $data['post_desc'];
       $post->post_content = $data['post_content'];
       $post->post_meta_desc = $data['post_meta_desc'];
       $post->post_meta_keywords = $data['post_meta_keywords']; 
       $post->cate_post_id = $data['cate_post_id'];
       $post->post_slug = $data['post_slug'];
       $post->post_status = $data['post_status'];

        $get_image = $request->file('post_image');
        if($get_image){
            //Xoa anh cu
            $post_image_old = $post->post_image;
            $path = 'public/uploads/post/'.$post_image_old;
            unlink($path);
            //Cap nhat anh moi
            $get_name_image =$get_image->getClientOriginalName();// lay ten cua hinh anh do
            $name_imgae= current(explode('.',$get_name_image)); 
            $new_image = $name_imgae.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/post',$new_image);

            $post->post_image = $new_image;

        
        }
           
        $post->save();
        Session::put('message','Cap nhat bai viet thành công');
        return redirect('/list-post');
    }
    public function danh_muc_bai_viet($post_slug){
        return view('pages.baiviet.danhmucbaiviet');
    }
}
