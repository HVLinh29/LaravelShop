<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use App\Customer;
use Carbon\Carbon;
use App\Coupon;
use PDF;
use App\Product;
use App\Statistic;

class OrderController extends Controller
{
	public function manage_order()
	{
		$orderr = Order::orderby('created_at', 'DESC')->get();
		return view('admin.manage_order')->with(compact('orderr'));
	}
	public function view_order($order_code)
	{
		$order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
		$orderr = Order::where('order_code', $order_code)->get();
		foreach ($orderr as $key => $ord) {
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
			$order_status = $ord->order_status;
		}
		$customerr = Customer::where('customer_id', $customer_id)->first();
		$shipping = Shipping::where('shipping_id', $shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

		foreach ($order_details_product as $key => $order_d) {

			$product_coupon = $order_d->product_coupon;
		}
		if ($product_coupon != 'no') {
			$coupon = Coupon::where('coupon_code', $product_coupon)->first();
			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;
		} else {
			$coupon_condition = 2;
			$coupon_number = 0;
		}

		return view('admin.view_order')->with(compact('order_details', 'customerr', 'shipping', 'order_details', 'coupon_condition', 'coupon_number', 'orderr', 'order_status'));
	}
	public function print_order($checkout_code)
	{
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));

		return $pdf->stream();
	}
	public function print_order_convert($checkout_code)
	{
		$order_details = OrderDetails::where('order_code', $checkout_code)->get();
		$order = Order::where('order_code', $checkout_code)->get();
		foreach ($order as $key => $ord) {
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
		}
		$customer = Customer::where('customer_id', $customer_id)->first();
		$shipping = Shipping::where('shipping_id', $shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

		foreach ($order_details_product as $key => $order_d) {

			$product_coupon = $order_d->product_coupon;
		}
		if ($product_coupon != 'no') {
			$coupon = Coupon::where('coupon_code', $product_coupon)->first();

			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;

			if ($coupon_condition == 1) {
				$coupon_echo = $coupon_number . '%';
			} elseif ($coupon_condition == 2) {
				$coupon_echo = number_format($coupon_number, 0, ',', '.') . 'đ';
			}
		} else {
			$coupon_condition = 2;
			$coupon_number = 0;

			$coupon_echo = '0';
		}

		$output = '';

		$output .= '<style>body{
			font-family: DejaVu Sans;
		}
		.table-styling{
			border:1px solid #000;
		}
		.table-styling tbody tr td{
			border:1px solid #000;
		}
		</style>
		<h1><center>Công ty TNHH đồng hồ LINHWATCH</center></h1>
		<h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>
		<p>Người đặt hàng</p>
		<table class="table-styling">
				<thead>
					<tr>
						<th>Tên khách đặt</th>
						<th>Số điện thoại</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>';

		$output .= '		
					<tr>
						<td>' . $customer->customer_name . '</td>
						<td>' . $customer->customer_phone . '</td>
						<td>' . $customer->customer_email . '</td>
						
					</tr>';


		$output .= '				
				</tbody>
			
		</table>

		<p>Ship hàng tới</p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Tên người nhận</th>
						<th>Địa chỉ</th>
						<th>Sdt</th>
						<th>Email</th>
						<th>Ghi chú</th>
					</tr>
				</thead>
				<tbody>';

		$output .= '		
					<tr>
						<td>' . $shipping->shipping_name . '</td>
						<td>' . $shipping->shipping_address . '</td>
						<td>' . $shipping->shipping_phone . '</td>
						<td>' . $shipping->shipping_email . '</td>
						<td>' . $shipping->shipping_notes . '</td>
						
					</tr>';


		$output .= '				
				</tbody>
			
		</table>

		<p>Đơn hàng đặt</p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Tên sản phẩm</th>
						<th>Mã giảm giá</th>
						<th>Phí ship</th>
						<th>Số lượng</th>
						<th>Giá sản phẩm</th>
						<th>Thành tiền</th>
					</tr>
				</thead>
				<tbody>';

		$total = 0;

		foreach ($order_details_product as $key => $product) {

			$subtotal = $product->product_price * $product->product_sales_quantity;
			$total += $subtotal;

			if ($product->product_coupon != 'no') {
				$product_coupon = $product->product_coupon;
			} else {
				$product_coupon = 'không mã';
			}

			$output .= '		
					<tr>
						<td>' . $product->product_name . '</td>
						<td>' . $product_coupon . '</td>
						<td>' . number_format($product->product_feeship, 0, ',', '.') . 'đ' . '</td>
						<td>' . $product->product_sales_quantity . '</td>
						<td>' . number_format($product->product_price, 0, ',', '.') . 'đ' . '</td>
						<td>' . number_format($subtotal, 0, ',', '.') . 'đ' . '</td>
						
					</tr>';
		}

		if ($coupon_condition == 1) {
			$total_after_coupon = ($total * $coupon_number) / 100;
			$total_coupon = $total - $total_after_coupon;
		} else {
			$total_coupon = $total - $coupon_number;
		}

		$output .= '<tr>
				<td colspan="2">
					<p>Tổng giảm: ' . $coupon_echo . '</p>
					<p>Phí ship: ' . number_format($product->product_feeship, 0, ',', '.') . 'đ' . '</p>
					<p>Thanh toán : ' . number_format($total_coupon + $product->product_feeship, 0, ',', '.') . 'đ' . '</p>
				</td>
		</tr>';
		$output .= '				
				</tbody>
			
		</table>

		<p>Ký tên</p>
			<table>
				<thead>
					<tr>
						<th width="200px">Người lập phiếu</th>
						<th width="800px">Người nhận</th>
						
					</tr>
				</thead>
				<tbody>';

		$output .= '				
				</tbody>
			
		</table>

		';


		return $output;
	}
	public function update_qty(Request $request)
	{
		$data = $request->all();
		$order_details = OrderDetails::where('product_id', $data['order_product_id'])->where('order_code', $data['order_code'])->first();
		$order_details->product_sales_quantity = $data['order_qty'];
		$order_details->save();
	}
	// public function update_order_qty(Request $request)
	// {
	// 	//update order
	// 	$data = $request->all();
	// 	$order = Order::find($data['order_id']);
	// 	$order->order_status = $data['order_status'];
	// 	$order->save();

	// 	//order date
	// 	$order_date = $order->order_date;
	// 	$statistic = Statistic::where('order_date','$order_date')->get();

	// 	if($statistic){
	// 		$statistic_count = $statistic->count();
	// 	}else{
	// 		$statistic_count = 0;
	// 	}


	// 	if ($order->order_status == 2) {

	// 		$total_order = 0;
	// 		$sales = 0;
	// 		$profit= 0;
	// 		$quantity = 0;

	// 		foreach ($data['order_product_id'] as $key => $product_id) {

	// 			$product = Product::find($product_id);
	// 			$product_quantity = $product->product_quantity;
	// 			$product_sold = $product->product_sold;

	// 			$product_price = $product->product_price;
	// 			$now = Carbon::now('Aisa/Ho_Chi_Minh')->toDateString();

	// 			foreach ($data['quantity'] as $key2 => $qty) {
	// 				if ($key == $key2) {
	// 					$pro_remain = $product_quantity - $qty;
	// 					$product->product_quantity = $pro_remain;
	// 					$product->product_sold = $product_sold + $qty;
	// 					$product->save();
	// 					//update doanh thu
	// 					$quantity+=$qty;
	// 					$total_order+=1;
	// 					$sales+=$product_price*$qty;
	// 					$profit=$sales-1000;
	// 				}
	// 			}
	// 		}
	// 		//update doanh thu
	// 		if($statistic_count>0){
	// 			$statistic_update = Statistic::where('order_date',$order_date)->first();
	// 			$statistic_update->sales = $statistic_update->sales + $sales;
	// 			$statistic_update->quantity = $statistic_update->quantity + $quantity;
	// 			$statistic_update->profit = $statistic_update->profit + $profit;
	// 			$statistic_update->total_order = $statistic_update->total_order + $total_order;
	// 			$statistic_update->save();
	// 		}else{
	// 			$statistic_new = new Statistic();
	// 			$statistic_new->order_date = $order_date;
	// 			$statistic_new->sales = $sales;
	// 			$statistic_new->quantity = $quantity;
	// 			$statistic_new->profit = $profit;
	// 			$statistic_new->total_order = $total_order;
	// 			$statistic_new->save();
	// 		}
	// 	} 
		
	// }
	public function update_order_qty(Request $request)
	{
		// Cập nhật đơn hàng
		$data = $request->all();
		$order = Order::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();
	
		// Lấy ngày đơn hàng
		$order_date = $order->order_date;
	
		// Tìm thống kê cho ngày hiện tại
		$statistic = Statistic::where('order_date', $order_date)->first();
	
		// Nếu không có thống kê, tạo mới
		if (!$statistic) {
			$statistic = new Statistic();
			$statistic->order_date = $order_date;
			$statistic->sales = 0;
			$statistic->quantity = 0;
			$statistic->profit = 0;
			$statistic->total_order = 0;
		}
	
		if ($order->order_status == 2) {
			// Khởi tạo các biến
			$total_order = 0;
			$sales = 0;
			$profit = 0;
			$quantity = 0;
	
			// Lặp qua các sản phẩm trong đơn hàng
			foreach ($data['order_product_id'] as $key => $product_id) {
				$product = Product::find($product_id);
				$product_quantity = $product->product_quantity;
				$product_sold = $product->product_sold;
				$product_price = $product->product_price;
				$qty = $data['quantity'][$key];
	
				// Cập nhật thông tin sản phẩm
				$product->product_quantity -= $qty;
				$product->product_sold += $qty;
				$product->save();
	
				// Cập nhật thông tin doanh thu và số lượng
				$quantity += $qty;
				$total_order++;
				$sales += $product_price * $qty;
				$profit += $sales - 1000; // Giả sử 1000 là chi phí cố định
			}
	
			// Cập nhật thông tin thống kê
			$statistic->sales += $sales;
			$statistic->quantity += $quantity;
			$statistic->profit += $profit;
			$statistic->total_order += $total_order;
			$statistic->save();
		}
	}
	

	public function delete_order($orderCode)
	{

		$order = Order::where('order_code', $orderCode)->first();
		if ($order) {
			$order->delete();
			return redirect('manage-order')->with('success', 'Đơn hàng đã được xóa thành công.');
		} else {
			return redirect('manage-order')->with('error', 'Không tìm thấy đơn hàng.');
		}
	}
}
