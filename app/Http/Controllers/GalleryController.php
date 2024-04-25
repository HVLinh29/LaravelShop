<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use Auth;
use App\Gallery;

class GalleryController extends Controller
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
    public function add_gallery($product_id){
        $pro_id = $product_id;
        return view('admin.gallery.add_gallery')->with(compact('pro_id'));
    }
    public function select_gallery(Request $request){
        $product_id = $request->pro_id;
        $gallery = Gallery::where('product_id', $product_id)->get();
        $gallery_count = $gallery->count();
        $output = '<table class="table table-hover">
            <thead>
              <tr>
              <th>Thu tu</th>
                <th>Ten hinh anh</th>
                <th>hinh anh</th>
                <th>Quan ly</th>
              </tr>
            </thead>
            <tbody>';
        if ($gallery_count > 0) {
            $i = 0;
            foreach ($gallery as $key => $gal) {
                $i++;
                $output .= '<tr>
                    <td>' . $i . '</td>
                    <td>' . $gal->gallery_name . '</td>
                    <td><img src="' . url('public/uploads/gallery/' . $gal->gallery_image) . '" class="img-thumbnail" width="100px" height="100px"></td>
                    <td>
                        <button data-gal_id="' . $gal->gallery_id . '" class="btn btn-danger delete-gallery">Xoa</button>
                    </td>
                    </tr>';
            }
        } else {
            $output .= '<tr>
                <td colspan="4">San pham chua co thu vien anh</td>
            </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    }
    
    public function insert_gallery(Request $request, $pro_id){
        $get_image = $request->file('file');
        if($get_image){
            foreach($get_image as $image){
            $get_name_image =$image->getClientOriginalName();
            $name_image= current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$image->getClientOriginalExtension();
            $get_image->move('public/uploads/gallery',$new_image);
           
            $gallery = new Gallery();
            $gallery->gallery_name = $new_image;
            $gallery->gallery_image = $new_image;
            $gallery->gallery_product_id = $pro_id;
            $gallery->save();
           
            }
        }
        Session::put('message','Them thu vien anh thành công');
        return redirect()->back();
    }
}
