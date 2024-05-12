@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Khách hàng
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $customerr->customer_name }}</td>
                                    <td>{{ $customerr->customer_phone }}</td>
                                    <td>{{ $customerr->customer_email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Thông tin vận chuyển hàng
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên người nhận</th>
                                    <th>Địa chỉ</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Ghi chú</th>
                                    <th>Hình thức thanh toán</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $shipping->shipping_name }}</td>
                                    <td>{{ $shipping->shipping_address }}</td>
                                    <td>{{ $shipping->shipping_phone }}</td>
                                    <td>{{ $shipping->shipping_email }}</td>
                                    <td>{{ $shipping->shipping_notes }}</td>
                                    <td>
                                        @if ($shipping->shipping_method == 1)
                                            Chuyển khoản
                                        @else
                                            Tiền mặt
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng kho còn</th>
                            <th>Mã giảm giá</th>
                            <th>Phí ship hàng</th>
                            <th>Số lượng</th>
                            <th>Giá bán</th>
                            <th>Giá gốc</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach ($order_details as $key => $details)
                            @php
                                $i++;
                                $subtotal = $details->product_price * $details->product_sales_quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $details->product_name }}</td>
                                <td>{{ $details->product->product_quantity }}</td>
                                <td>@extends('layout')

                                    @section('content')
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"
                                                            style="background-color: #337ab7; color: #fff;">
                                                            Khách hàng
                                                        </div>
                                                        <div class="panel-body">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Tên khách hàng</th>
                                                                        <th>Số điện thoại</th>
                                                                        <th>Email</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>{{ $customerr->customer_name }}</td>
                                                                        <td>{{ $customerr->customer_phone }}</td>
                                                                        <td>{{ $customerr->customer_email }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"
                                                            style="background-color: #5cb85c; color: #fff;">
                                                            Thông tin vận chuyển hàng
                                                        </div>
                                                        <div class="panel-body">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Tên người vận chuyển</th>
                                                                        <th>Địa chỉ</th>
                                                                        <th>Số điện thoại</th>
                                                                        <th>Email</th>
                                                                        <th>Ghi chú</th>
                                                                        <th>Hình thức thanh toán</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>{{ $shipping->shipping_name }}</td>
                                                                        <td>{{ $shipping->shipping_address }}</td>
                                                                        <td>{{ $shipping->shipping_phone }}</td>
                                                                        <td>{{ $shipping->shipping_email }}</td>
                                                                        <td>{{ $shipping->shipping_notes }}</td>
                                                                        <td>
                                                                            @if ($shipping->shipping_method == 0)
                                                                                Chuyển khoản
                                                                            @elseif($shipping->shipping_method == 1)
                                                                                Tiền mặt
                                                                            @else
                                                                                Thanh toán PayPal
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #d9534f; color: #fff;">
                                                    Liệt kê chi tiết đơn hàng
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Tên sản phẩm</th>
                                                                <th>Số lượng kho còn</th>
                                                                <th>Mã giảm giá</th>
                                                                <th>Phí ship hàng</th>
                                                                <th>Số lượng</th>
                                                                <th>Giá bán</th>
                                                              
                                                                <th>Tổng tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $i = 0;
                                                                $total = 0;
                                                            @endphp
                                                            @foreach ($order_details as $key => $details)
                                                                @php
                                                                    $i++;
                                                                    $subtotal =
                                                                        $details->product_price *
                                                                        $details->product_sales_quantity;
                                                                    $total += $subtotal;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $details->product_name }}</td>
                                                                    <td>{{ $details->product->product_quantity }}</td>
                                                                    <td>
                                                                        @if ($details->product_coupon != 'no')
                                                                            {{ $details->product_coupon }}
                                                                        @else
                                                                            Không mã
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ number_format($details->product_feeship, 0, ',', '.') }}đ
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" readonly
                                                                            {{ $order_status == 2 ? 'disabled' : '' }}
                                                                            class="order_qty_{{ $details->product_id }}"
                                                                            value="{{ $details->product_sales_quantity }}"
                                                                            name="product_sales_quantity">
                                                                        <input type="hidden" name="order_qty_storage"
                                                                            class="order_qty_storage_{{ $details->product_id }}"
                                                                            value="{{ $details->product->product_quantity }}">
                                                                        <input type="hidden" name="order_code"
                                                                            class="order_code"
                                                                            value="{{ $details->order_code }}">
                                                                        <input type="hidden" name="order_product_id"
                                                                            class="order_product_id"
                                                                            value="{{ $details->product_id }}">
                                                                    </td>
                                                                    <td>{{ number_format($details->product_price, 0, ',', '.') }}đ
                                                                    </td>
                                                                 
                                                                    <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="2">
                                                                    @php
                                                                        $total_coupon = 0;
                                                                    @endphp
                                                                    @if ($coupon_condition == 1)
                                                                        @php
                                                                            $total_after_coupon =
                                                                                ($total * $coupon_number) / 100;
                                                                            echo 'Tổng giảm :' .
                                                                                number_format(
                                                                                    $total_after_coupon,
                                                                                    0,
                                                                                    ',',
                                                                                    '.',
                                                                                ) .
                                                                                '</br>';
                                                                            $total_coupon =
                                                                                $total +
                                                                                $details->product_feeship -
                                                                                $total_after_coupon;
                                                                        @endphp
                                                                    @else
                                                                        @php
                                                                            echo 'Tổng giảm :' .
                                                                                number_format(
                                                                                    $coupon_number,
                                                                                    0,
                                                                                    ',',
                                                                                    '.',
                                                                                ) .
                                                                                'k' .
                                                                                '</br>';
                                                                            $total_coupon =
                                                                                $total +
                                                                                $details->product_feeship -
                                                                                $coupon_number;
                                                                        @endphp
                                                                    @endif
                                                                    Phí ship :
                                                                    {{ number_format($details->product_feeship, 0, ',', '.') }}đ</br>
                                                                    Thanh toán:
                                                                    {{ number_format($total_coupon, 0, ',', '.') }}đ
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    @endsection

                                    @if ($details->product_coupon != 'no')
                                        {{ $details->product_coupon }}
                                    @else
                                        Không mã
                                    @endif
                                </td>
                                <td>{{ number_format($details->product_feeship, 0, ',', '.') }}đ</td>
                                <td>
                                    <input type="number" min="1" {{ $order_status == 2 ? 'disabled' : '' }}
                                        class="order_qty_{{ $details->product_id }}"
                                        value="{{ $details->product_sales_quantity }}" name="product_sales_quantity">
                                    <input type="hidden" name="order_qty_storage"
                                        class="order_qty_storage_{{ $details->product_id }}"
                                        value="{{ $details->product->product_quantity }}">
                                    <input type="hidden" name="order_code" class="order_code"
                                        value="{{ $details->order_code }}">
                                    <input type="hidden" name="order_product_id" class="order_product_id"
                                        value="{{ $details->product_id }}">
                                </td>
                                <td>{{ number_format($details->product_price, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($details->product->product_cost, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                @php
                                    $total_coupon = 0;
                                @endphp
                                @if ($coupon_condition == 1)
                                    @php
                                        $total_after_coupon = ($total * $coupon_number) / 100;
                                        echo 'Tổng giảm :' . number_format($total_after_coupon, 0, ',', '.') . '</br>';
                                        $total_coupon = $total + $details->product_feeship - $total_after_coupon;
                                    @endphp
                                @else
                                    @php
                                        echo 'Tổng giảm :' . number_format($coupon_number, 0, ',', '.') . 'k' . '</br>';
                                        $total_coupon = $total + $details->product_feeship - $coupon_number;
                                    @endphp
                                @endif
                                Phí ship : {{ number_format($details->product_feeship, 0, ',', '.') }}đ</br>
                                Thanh toán: {{ number_format($total_coupon, 0, ',', '.') }}đ
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
    @endsection
