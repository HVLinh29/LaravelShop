<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

use Cart;
use App\City;
use App\Quan;
use App\Xa;
use App\Feeship;
use Carbon\Carbon;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use App\CatePost;
use App\Slider;
use App\Coupon;
use App\Customer;
use Mail;
use App\Vnpay;
use App\Momo;

class CheckoutController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');

        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function login_checkout(Request $request)
    {
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        //seo 
        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
        return view('pages.thanhtoan.login_checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('category_post', $category_post)->with('slider', $slider);
    }
    public function dangki(Request $request)
    {
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        //seo 
        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
        return view('pages.thanhtoan.add_customer')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('category_post', $category_post)->with('slider', $slider);
    }
    public function add_customer(Request $request)
    {
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;

        $customer_id = DB::table('tbl_customers')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect('/login-checkout');
    }

    public function checkout(Request $request)
    {
        // Lấy danh mục bài viết và slider
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        // SEO metadata
        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();

        // Lấy danh mục sản phẩm và thương hiệu
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
        $city = City::orderby('matp', 'ASC')->get();

        // Kiểm tra nếu có dữ liệu thanh toán từ VNPAY
        if ($request->has('vnp_Amount')) {
            // Lấy các thông tin từ query string của URL
            $vnp_Amount = $request->query('vnp_Amount');
            $vnp_BankCode = $request->query('vnp_BankCode');
            $vnp_BankTranNo = $request->query('vnp_BankTranNo');
            $vnp_CardType = $request->query('vnp_CardType');
            $vnp_OrderInfo = $request->query('vnp_OrderInfo');
            $vnp_PayDate = $request->query('vnp_PayDate');
            $payDate = Carbon::createFromFormat('YmdHis', $vnp_PayDate);
            $vnp_ResponseCode = $request->query('vnp_ResponseCode');
            $vnp_TmnCode = $request->query('vnp_TmnCode');
            $vnp_TransactionNo = $request->query('vnp_TransactionNo');
            $vnp_TransactionStatus = $request->query('vnp_TransactionStatus');
            $vnp_TxnRef = $request->query('vnp_TxnRef');
            $vnp_SecureHash = $request->query('vnp_SecureHash');

            // Lưu thông tin vào cơ sở dữ liệu
            $payment = new Vnpay();
            $payment->vnp_Amount = $vnp_Amount;
            $payment->vnp_BankCode = $vnp_BankCode;
            $payment->vnp_BankTranNo = $vnp_BankTranNo;
            $payment->vnp_CardType = $vnp_CardType;
            $payment->vnp_OrderInfo = $vnp_OrderInfo;
            $payment->vnp_PayDate = $payDate;

            $payment->vnp_ResponseCode = $vnp_ResponseCode;
            $payment->vnp_TmnCode = $vnp_TmnCode;
            $payment->vnp_TransactionNo = $vnp_TransactionNo;
            $payment->vnp_TransactionStatus = $vnp_TransactionStatus;
            $payment->vnp_TxnRef = $vnp_TxnRef;
            $payment->vnp_SecureHash = $vnp_SecureHash;
            $payment->save();

            // Kiểm tra mã phản hồi từ VNPAY
            if ($vnp_ResponseCode == "00") {
                // Thanh toán thành công
                \Session::flash('message', 'Thanh toán VNPAY thành công!');
            } else {
                // Thanh toán thất bại
                \Session::flash('message', 'Thanh toán VNNPAY thất bại. Vui lòng thử lại sau.');
            }
        }
        // Kiểm tra nếu có dữ liệu thanh toán từ MoMo
        if ($request->filled(['partnerCode', 'orderId', 'requestId', 'amount', 'orderInfo', 'transId', 'resultCode', 'message'])) {
            // Lấy tất cả thông tin từ query string của URL
            $partnerCode = $request->query('partnerCode');
            $orderId = $request->query('orderId');
            $requestId = $request->query('requestId');
            $amount = $request->query('amount');
            $orderInfo = $request->query('orderInfo');
            $transId = $request->query('transId');
            $resultCode = $request->query('resultCode');
            $message = $request->query('message');


            // Lưu thông tin vào cơ sở dữ liệu
            $payment = new Momo();
            $payment->partnerCode = $partnerCode;
            $payment->orderId = $orderId;
            $payment->requestId = $requestId;
            $payment->amount = $amount;
            $payment->orderInfo = $orderInfo;
            $payment->transId = $transId;
            $payment->message = $message;
            $payment->orderInfo = $orderInfo;
            $payment->resultCode = $resultCode;
            // Tiếp tục lưu các thông tin khác tương tự
            $payment->save();

            // Kiểm tra mã phản hồi từ MoMo
            if ($resultCode == "0") {
                // Thanh toán thành công
                \Session::flash('message', 'Thanh toán MoMo thành công!');
            } else {
                // Thanh toán thất bại
                \Session::flash('message', 'Thanh toán MoMo thất bại. Vui lòng thử lại sau.');
            }
        }


        // Trả về view trang thanh toán mặc định
        return view('pages.thanhtoan.thanhtoan', [
            'category' => $cate_product,
            'brand' => $brand_product,
            'meta_desc' => $meta_desc,
            'meta_keywords' => $meta_keywords,
            'meta_title' => $meta_title,
            'url_canonical' => $url_canonical,
            'city' => $city,
            'category_post' => $category_post,
            'slider' => $slider
        ]);
    }
    public function save_checkout_customer(Request $request)
    {
        $data = array();
        $data['s_name'] = $request->s_name;
        $data['s_email'] = $request->s_email;
        $data['s_notes'] = $request->s_notes;
        $data['s_phone'] = $request->s_phone;
        $data['s_address'] = $request->s_address;


        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('s_id', $shipping_id);

        return Redirect::to('/payment');
    }
    public function payment(Request $request)
    {

        //seo 
        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
        return view('pages.thanhtoan.payment')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical);
    }
    public function logout_checkout()
    {
        Session::forget('customer_id');
        Session::forget('coupon');
        Session::forget('customer_name');
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email', $email)->where('customer_password', $password)->first();
        if (Session::get('coupon') == true) {
            Session::forget('coupon');
        }
        if ($result) {
            Session::put('customer_id', $result->customer_id);
            Session::flash('success', 'Đăng nhập thành công!');
            return Redirect::to('/thanhtoan');
        } else {
            Session::flash('error', 'Đăng nhập thất bại! Vui lòng kiểm tra lại email và mật khẩu.');
            return Redirect::to('/login-checkout');
        }
        Session::save();
    }
    public function order_place(Request $request)
    {
        //seo 
        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 
        //them hinh thuc thanh toan
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Dang cho xu ly';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);
        // them vao order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['s_id'] = Session::get('s_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Dang cho xu ly';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        // them vao order details
        $content = Cart::content();
        foreach ($content as $v_content) {
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if ($data['payment_method'] == 1) {
            echo 'Thanh toan ATM';
        } elseif ($data['payment_method'] == 2) {
            Cart::destroy();
            $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
            return view('pages.thanhtoan.handcash')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
                ->with('url_canonical', $url_canonical);
        } else {
            echo 'The ghi no';
        }
    }
    public function manage_order()
    {

        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
            ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
            ->select('tbl_order.*', 'tbl_customers.customer_name')
            ->orderBy('tbl_order.order_id', 'desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manager_order', $manager_order);
    }
    public function view_order($orderId)
    {
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
            ->join('tbl_shipping', 'tbl_order._id', '=', 'tbl_shipping.s_id')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->select('tbl_order.*', 'tbl_customers.*', 'tbl_shipping.*', 'tbl_order_details.*')->first();

        $manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }
    public function select_delivery_home(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $select_province = Quan::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                $output .= '<option>Chọn quận huyện</option>';
                foreach ($select_province as $key => $province) {
                    $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {

                $select_wards = Xa::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
                $output .= '<option>Chọn xã phường</option>';
                foreach ($select_wards as $key => $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
                }
            }
            echo $output;
        }
    }
    public function calculate_fee(Request $request)
    {
        $data = $request->all();
        if ($data['matp']) {
            $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();
            if ($feeship) {
                $count_feeship = $feeship->count();
                if ($count_feeship > 0) {
                    foreach ($feeship as $key => $fee) {
                        Session::put('fee', $fee->fee_feeship);
                        Session::save();
                    }
                } else {
                    Session::put('fee', 25000);
                    Session::save();
                }
            }
        }
    }
    public function del_fee()
    {
        Session::forget('fee');
        return redirect()->back();
    }
    public function confirm_order(Request $request)
    {
        $data = $request->all();
        if ($data['order_coupon'] != 'no') {
            $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
            $coupon->coupon_used = $coupon->coupon_used . ',' . Session::get('customer_id');
            $coupon->coupon_time = $coupon->coupon_time - 1;
            $coupon_mail = $coupon->coupon_code;
            $coupon->save();
        } else {
            $coupon_mail = 'Không có';
        }

        $shipping = new Shipping();
        $shipping->s_name = $data['s_name'];
        $shipping->s_email = $data['s_email'];
        $shipping->s_phone = $data['s_phone'];
        $shipping->s_address = $data['s_address'];
        $shipping->s_notes = $data['s_notes'];
        $shipping->s_method = $data['s_method'];
        $shipping->save();
        $shipping_id = $shipping->s_id;

        if (Session::has('vnpay_code')) {
            $checkout_code = Session::get('vnpay_code');
        } elseif (Session::has('momo_code')) {
            $checkout_code = Session::get('momo_code');
        } else {
            
            $checkout_code = 'TM' . substr(md5(uniqid(mt_rand(), true)), 0, 10);
        }

        // Lưu session để đảm bảo rằng giá trị của $checkout_code không bị mất trong các lần thực thi sau
        Session::put('checkout_code', $checkout_code);

        $order = new Order;
        $order->customer_id = Session::get('customer_id');
        $order->s_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');

        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->created_at = $today;
        $order->order_date = $order_date;
        $order->save();

        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart) {
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Đơn hàng xác nhận ngày" . '' . $now;
        $customer = Customer::find(Session::get('customer_id'));
        $data['email'][] = $customer->customer_email;

        //lay gio hang
        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart_mail) {
                $cart_array[] = array(
                    'product_name' => $cart_mail['product_name'],
                    'product_price' => $cart_mail['product_price'],
                    'product_qty' => $cart_mail['product_qty']

                );
            }
        }
        //lay phi van chuyen
        if (Session::get('fee') == true) {
            $fee = Session::get('fee');
        }

        $shipping_array = array(
            'fee' => $fee,
            'customer_name' => $customer->customer_name,
            's_name' => $data['s_name'],
            's_email' => $data['s_email'],
            's_phone' => $data['s_phone'],
            's_address' => $data['s_address'],
            's_notes' => $data['s_notes'],
            's_method' => $data['s_method'],

        );
        //lay ma giam gia va ma code cua ma giam gia
        $ordercode_mail = array(
            'coupon_code' => $coupon_mail,
            'order_code' => Session::get('checkout_code')
        );

        Mail::send(
            'pages.mail.mail_order',
            ['cart_array' => $cart_array, 'shipping_array' => $shipping_array, 'code' => $ordercode_mail],
            function ($message) use ($title_mail, $data) {
                $message->to($data['email'])->subject($title_mail);
                $message->from($data['email'], $title_mail);
            }
        );
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
        Session::forget('success_paypal');
        Session::forget('success_vnpay');
        Session::forget('success_momo');
        Session::forget('total_paypal');
        Session::forget('momo_code');
        Session::forget('vnpay_code');
        Session::forget('checkout_code');
    }
    public function vnpay_payment(Request $request)
    {
        // Lấy dữ liệu từ request
        $data = $request->all();

        // Tạo mã thẻ ngẫu nhiên
        $code_card = 'VNPAY' . substr(md5(uniqid(mt_rand(), true)), 0, 10);


        // Các thông tin cần thiết cho việc gửi yêu cầu thanh toán đến VNPAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/laravel_shopTMDT/thanhtoan";
        $vnp_TmnCode = "TFU83QKW"; // Mã website tại VNPAY 
        $vnp_HashSecret = "ZVXWFOGPSKCLCKCWKJEGDGLRSSXHRFMJ"; // Chuỗi bí mật

        // Mã đơn hàng. Trong thực tế, Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_TxnRef = $code_card;

        // Thông tin đơn hàng
        $vnp_OrderInfo = 'Thanh toán đơn hàng VNPAY';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $data['total_vnpay'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        // Dữ liệu gửi đi
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        // Thêm các thông tin nếu có
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        // Sắp xếp dữ liệu và tạo chuỗi hash
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Tạo đường link redirect đến VNPAY
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Tạo session
        $request->session()->put('success_vnpay', true);
        $request->session()->put('vnpay_code', $vnp_TxnRef);

        // Chuyển hướng đến trang cần thiết sau khi xác nhận thanh toán
        if (isset($_POST['redirect'])) {
            return redirect($vnp_Url);
        } else {
            return response()->json([
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url
            ]);
        }
    }



    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momo_payment(Request $request)
    {

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $_POST['total_momo'];
        $orderId = 'MM' . substr(md5(uniqid(mt_rand(), true)), 0, 10);
        $redirectUrl = "http://localhost/laravel_shopTMDT/thanhtoan";
        $ipnUrl = "http://localhost/laravel_shopTMDT/thanhtoan";
        $extraData = "";




        $requestId = 'MM' . substr(md5(uniqid(mt_rand(), true)), 0, 10);
        $requestType = "payWithATM";

        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey); //chu ki so
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));

        $jsonResult = json_decode($result, true);  // decode json

        Session::put('success_momo', true);
        Session::put('momo_code', $orderId);

        //Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl']);
    }
}
