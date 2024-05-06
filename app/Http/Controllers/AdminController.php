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
use App\Product;
use App\Post;
use App\Order;
use App\Video;
use App\Customer;
use App\Statistic;
use App\Visitors;
use App\Rules\Captcha;
use Validator;
use Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function login_google()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback_google()
    {
        $users = Socialite::driver('google')->stateless()->user();
        // // return $users->id;
        // return $users->name;
        // return $users->email;
        $authUser = $this->findOrCreateUser($users, 'google');
        $account_name = Login::where('admin_id', $authUser->user)->first();
        Session::put('admin_name', $account_name->admin_name);
        Session::put('admin_id', $account_name->admin_id);
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    }
    public function findOrCreateUser($users, $provider)
    {
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if ($authUser) {

            return $authUser;
        }

        $hieu = new Social([
            'provider_user_id' => $users->id,
            'provider' => strtoupper($provider)
        ]);

        $orang = Login::where('admin_email', $users->email)->first();

        if (!$orang) {
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

        $account_name = Login::where('admin_id', $hieu->user)->first();
        Session::put('admin_name', $account_name->admin_name);
        Session::put('admin_id', $account_name->admin_id);

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


    public function dashboard(Request $request)
    {
        //$data = $request->all();
        $data = $request->validate([
            //validation laravel 
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => new Captcha(),    //dòng kiểm tra Captcha
        ]);


        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if ($login) {
            $login_count = $login->count();
            if ($login_count > 0) {
                Session::put('admin_name', $login->admin_name);
                Session::put('admin_id', $login->admin_id);
                return Redirect::to('/dashboard');
            }
        } else {
            Session::put('message', 'Mật khẩu hoặc tài khoản bị sai.Làm ơn nhập lại');
            return Redirect::to('/admin');
        }
    }
    public function logout()
    {
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }
    public function show(Request $request)
    {
        $this->AuthLogin();

        $user_ip_address = $request->ip();

        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonths()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonths()->endOfMonth()->toDateString();
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $oneyears = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $visitor_of_lastmonth = Visitors::whereBetween('date_visitor',[$early_last_month,$end_of_last_month])->get();
        $visitor_last_month_count = $visitor_of_lastmonth->count();

        $visitor_of_thismonth = Visitors::whereBetween('date_visitor',[$early_this_month,$now])->get();
        $visitor_this_month_count = $visitor_of_thismonth->count();

        $visitor_of_year = Visitors::whereBetween('date_visitor',[$oneyears,$now])->get();
        $visitor_year_count = $visitor_of_year->count();

        $visitors_current = Visitors::where('ip_address',$user_ip_address)->get();
        $visitor_count = $visitors_current->count();

        if($visitor_count<1){
            $visitor = new Visitors();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_visitor = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();
        }
        $visitors = Visitors::all();
        $visitors_total = $visitors->count();

        // $product = Product::all()->count();
        // $product_view = Product::orderBy('product_view','DESC')->take(20)->get();
        // $post = Post::all()->count();
        // $post_view = Post::orderBy('post_view','DESC')->take(20)->get();
        // $order = Order::all()->count();
        // $video = Video::all()->count();
        // $customer = Customer::all()->count();

        return view('admin.dashboard')->with(compact('visitors_total','visitor_count'
        ,'visitor_last_month_count','visitor_this_month_count','visitor_year_count'));
    }
    public function filter_by_date(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = Statistic::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request)
    {
        $data = $request->all();

        // Lấy ngày đầu tháng hiện tại
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        // Lấy ngày đầu tháng trước
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        // Lấy ngày cuối tháng trước
        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        // Lấy ngày trước 7 ngày
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        // Lấy ngày trước 365 ngày
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        // Lấy ngày hiện tại
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['dashboard_value'] == '7ngay') {
            $get = Statistic::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'ASC')->get();
        } elseif ($data['dashboard_value'] == 'thangtruoc') {
            $get = Statistic::whereBetween('order_date', [$dauthangtruoc, $cuoithangtruoc])->orderBy('order_date', 'ASC')->get();
        } elseif ($data['dashboard_value'] == 'thangnay') { // Sửa ở đây
            $get = Statistic::whereBetween('order_date', [$dauthangnay, $now])->orderBy('order_date', 'ASC')->get();
        } else {
            $get = Statistic::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();
        }

        $chart_data = [];
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo json_encode($chart_data);
    }
    public function days_order(){
        $sub60days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(60)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistic::whereBetween('order_date', [$sub60days, $now])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
               'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo json_encode($chart_data);
    }

    
}
