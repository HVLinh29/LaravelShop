<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use Socialite;
use App\Social;
use App\Login;
use App\Rules\Captcha;
use Validator;
use Auth;
class AdminController extends Controller
{
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
            $users = Socialite::driver('google')->stateless()->user(); 
            // // return $users->id;
            // return $users->name;
            // return $users->email;
            $authUser = $this->findOrCreateUser($users,'google');
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');  
    }
    public function findOrCreateUser($users, $provider){
            $authUser = Social::where('provider_user_id', $users->id)->first();
            if($authUser){

                return $authUser;
            }
          
            $hieu = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);

            $orang = Login::where('admin_email',$users->email)->first();

                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $users->name,
                        'admin_email' => $users->email,
                        'admin_password' => '',
                        'admin_phone' => '',
                        'admin_status' => 1
                        
                    ]);
                }

            $hieu->login()->associate($orang);
                
            $hieu->save();

            $account_name = Login::where('admin_id',$hieu->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id); 
          
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');


    }
    public function AuthLogin()
    {
        $admin_id = Auth::id();
    
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    
    public function index()
    {
        return view('admin_login');
    }

    
    public function dashboard(Request $request){
      //$data = $request->all();
      $data = $request->validate([
        //validation laravel 
        'admin_email' => 'required',
        'admin_password' => 'required',
       'g-recaptcha-response' => new Captcha(),    //dòng kiểm tra Captcha
    ]);


    $admin_email = $data['admin_email'];
    $admin_password = md5($data['admin_password']);
    $login = Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
    if($login){
        $login_count = $login->count();
        if($login_count>0){
            Session::put('admin_name',$login->admin_name);
            Session::put('admin_id',$login->admin_id);
            return Redirect::to('/dashboard');
        }
    }else{
            Session::put('message','Mật khẩu hoặc tài khoản bị sai.Làm ơn nhập lại');
            return Redirect::to('/admin');
    }

    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
  
    } 
    public function show()
    {
        $this->AuthLogin();
        return view('admin.dashboard');
    }
}
