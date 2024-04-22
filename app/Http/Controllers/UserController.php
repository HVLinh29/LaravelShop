<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Roles;
use App\Admin;
use Session;
use Auth;
class UserController extends Controller
{
    public function index(){
        $admin = Admin::with('roles')->orderBy('admin_id', 'desc')->paginate(25);
        return view('admin.user.list_user')->with(compact('admin'));
    }
    public function add_users(){
        return view('admin.user.add_users');
    }
    public function assign_roles(Request $request){
        if(Auth::id() == $request->admin_id){
            return redirect()->back()->with('message','Ban khong co quyen phan quyen tai khoan cua ban');
        }
    
        $user = Admin::where('admin_email',$request->admin_email)->first();
        $user->roles()->detach();
        if($request->author_role){
           $user->roles()->attach(Roles::where('name','author')->first());     
        }
        if($request->user_role){
           $user->roles()->attach(Roles::where('name','user')->first());     
        }
        if($request->admin_role){
           $user->roles()->attach(Roles::where('name','admin')->first());     
        }
        return redirect()->back()->with('message','Cap quyen thanh cong');
    }
    public function store_users(Request $request){
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = md5($data['admin_password']);
        
        $admin->roles()->attach(Roles::where('name','user')->first());
        $admin->save();

        Session::put('message','Thêm users thành công');
        return Redirect::to('users');
    }
    public function delete_user_roles($admin_id){
        if(Auth::id() == $admin_id){
            return redirect()->back()->with('message','Ban khong co quyen xoa tai khoan cua ban');
        }

        $admin =Admin::find($admin_id);
        if($admin){
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message','Xoa User thanh cong');
    }
    public function transferrights($admin_id){
        $user = Admin::where('admin_id',$admin_id)->first();
        if($user){
            session()->put('transferrights',$user->admin_id);
        }
        return redirect('/users');
    }
    public function transferrights_destroy() {
       session()->forget('transferrights');
       return redirect('/users');
    }
}
