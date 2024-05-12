<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Linh Watch</title>

    <link href="{{ asset('public/fontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/lightslider.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/prettify.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/lightgallery.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="shortcut icon" href="{{ 'public/fontend/images/ico/favicon.ico' }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">


</head>

<body>
    <header id="header">
        <div class="header_top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> 012345678</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> hoangvulinh2002@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div><!--/header_top-->

        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="index.html"><img src="{{ 'public/fontend/images/home/logo.png' }}"
                                    alt="" /></a>
                        </div>

                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">


                                <?php
								$customer_id = Session::get('customer_id');
								$shipping_id = Session::get('shipping_id');
								if($customer_id!=NULL && $shipping_id==NULL ){
								?>
                                <li><a href="{{ URL::to('/thanhtoan') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a></li>

                                <?php
								}elseif($customer_id!=NULL && $shipping_id!=NULL ){
								?>
                                <li><a href="{{ URL::to('/payment') }}"><i class="fa fa-crosshairs"></i> Thanh toán</a>
                                </li>

                                <?php
								}
								else{
									?>
                                <li><a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a></li>

                                <?php
								}
								?>
                               
                                <li><a href="{{ URL::to('/gio-hang') }}"><i class="fa fa-shopping-cart"></i> Giỏ hàng 
                                   
                                            <span class="show-cart"></span>
                                    </a>
                                </li>

                                @php
                                        $customer_id = Session::get('customer_id');
                                        if($customer_id!=NULL){
                                            @endphp
                                <li><a href="{{ URL::to('lichsudh') }}"><i class="fa fa-shopping-cart"></i> Lịch sử đơn hàng</a>
                                </li>

                                @php
                                        }
                                @endphp

                                <?php
								$customer_id = Session::get('customer_id');
								if($customer_id!=NULL){
								?>
                                <li><a href="{{ URL::to('logout-checkout') }}"><i class="fa fa-lock"></i> Đăng xuất</a>
                                </li>
                                <?php
								}else{
									?>
                                <li><a href="{{ URL::to('login-checkout') }}"><i class="fa fa-lock"></i> Đăng nhập</a>
                                </li>
                                <?php
								}
								?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->

        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{ url('/trang-chu') }}" class="active">Trang chủ</a></li>

                                <li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category as $key => $danhmuc)
                                            <li><a
                                                    href="{{ URL::to('/danh-muc-san-pham/' . $danhmuc->category_slug) }}">{{ $danhmuc->category_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="{{ URL::to('/gio-hang') }}">Giỏ hàng 
                                    <span class="show-cart">
                            </span></a>
                                   
                                </li>
                                <li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category_post as $key => $danhmucbaiviet)
                                            <li><a
                                                    href="{{ URL::to('/danh-muc-bai-viet/' . $danhmucbaiviet->cate_post_slug) }}">{{ $danhmucbaiviet->cate_post_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="{{ URL::to('/video-linhwatch') }}">Video</a></li>
                                <li><a href="{{ URL::to('/lien-he') }}">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <form method="POST" action="{{ URL::to('/tim-kiem') }}" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="search_box pull-right">
                                {{-- <input type="text" name="keywords_submit" id="keywords" placeholder="Từ khóa" />
                                <div id="search_ajax"></div>
        <input type="submit" style="color: #000" name="search_item" class="btn-success btn-sm" value="Tìm kiếm"> --}}
                                <input type="text" name="keywords_submit" id="keywords" placeholder="Từ khóa" />
                                <div id="search_ajax"></div>
                                <input type="submit" style="color: #000" name="search_item"
                                    class=" btn-success btn-sm" value="Tìm kiếm">
                                <style>
                                    .search_box {
                                        position: relative;
                                    }

                                    #search_ajax {
                                        position: absolute;
                                        top: 100%;
                                        left: 0;
                                        width: 100%;

                                        /* Điều chỉnh màu nền của kết quả tìm kiếm */

                                        z-index: 999;
                                        /* Đảm bảo kết quả tìm kiếm được hiển thị trên menu */
                                    }

                                    .search_box {
                                        display: flex;
                                        align-items: center;
                                    }

                                    .search_box input[type="text"] {
                                        flex: 1;
                                        /* Ô tìm kiếm sẽ mở rộng để lấp đầy không gian còn lại */
                                        margin-right: 10px;
                                        /* Khoảng cách giữa ô tìm kiếm và nút submit */
                                    }

                                    .search_box input[type="submit"] {
                                        font-size: 14px;
                                        padding: 5px 10px;
                                    }
                                </style>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->

{{-- /slider --}}
@yield('slider')

    <section>
        <div class="container">
            <div class="row">
                
                <div class="col-sm-12 padding-right">

                    @yield('content_thu2')

                </div>
                @yield('sliderbar')
                <div class="col-sm-9 padding-right">

                    @yield('content')

                </div>
            </div>
        </div>
    </section>

    <footer id="footer"><!--Footer-->


        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Hỗ trợ - dịch vụ</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Chính sách và hướng dẫn mua hàng trả góp</a></li>
                                <li><a href="#">Hướng dẫn mua hàng và chính sách vận chuyển</a></li>
                                <li><a href="#">Tra cứu đơn hàng</a></li>
                                <li><a href="#">Chính sách đổi mới và bảo hành</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Thông tin liên hệ</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Thông tin các trang TMĐT </a></li>
                                <li><a href="#">Tra cứu bảo hành</a></li>
                                <li><a href="#">Dịch vụ sửa chữa Vũ Linh</a></li>
                                <li><a href="#">Khách hàng doanh nghiệp (B2B)</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Tổng đài</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">1234.5678</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Thanh toán miễn phí</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><img src="{{ 'public/fontend/images/logo-visa.png' }}" alt="">
                                    <img src="{{ 'public/fontend/images/logo-vnpay.png' }}" alt="">
                                </li>
                                <li><img src="{{ 'public/fontend/images/logo-samsungpay.png' }}" alt="">
                                    <img src="{{ 'public/fontend/images/logo-atm.png' }}" alt="">
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Hình thúc vận chuyển</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><img src="{{ 'public/fontend/images/nhattin.jpg' }}" alt="">
                                    <img src="{{ 'public/fontend/images/vnpost.jpg' }}" alt="">
                                </li>
                                <li>
                                    <img src="{{ 'public/fontend/images/logo-bct.png' }}" alt="">
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>



    </footer><!--/Footer-->



    <script src="{{ asset('public/fontend/js/jquery.js') }}"></script>
    <script src="{{ asset('public/fontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/fontend/js/price-range.js') }}"></script>
    <script src="{{ asset('public/fontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('public/fontend/js/main.js') }}"></script>

    <script src="{{ asset('public/fontend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/fontend/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('public/fontend/js/lightslider.js') }}"></script>
    <script src="{{ asset('public/fontend/js/prettify.js') }}"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/jquery-ui.min.js" async defer></script>

    
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v19.0" nonce="HvSWG6qx"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    {{-- <script>
        var usd = document.getElementById("vnd_to_usd").value;
        paypal.Button.render({
          // Configure environment
          env: 'sandbox',
          client: {
            sandbox: 'AYOFOKQNJlDCipof_AG5LW--DzMGDstaU4FfIfUFBEE_g_nTnVSWJ0cZUsiG5MBJ5upZVdr0bayCSxfw',
            production: 'demo_production_client_id'
          },
          // Customize button (optional)
          locale: 'en_US',
          style: {
            size: 'small',
            color: 'gold',
            shape: 'pill',
          },
      
          // Enable Pay Now checkout flow (optional)
          commit: true,
      
          // Set up a payment
          payment: function(data, actions) {
            return actions.payment.create({
              transactions: [{
                amount: {
                  total: `${usd}`,
                  currency: 'USD'
                }
              }]
            });
          },
          // Execute the payment
          onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
              // Show a confirmation message to the buyer
              window.alert('Cảm ơn bạn đã mua hàng của chúng tôi');
            });
          }
        }, '#paypal-button');
      
      </script> --}}
        <script type="text/javascript">
            $(document).ready(function() {
                load_more(); // Gọi hàm khi tài liệu được tải
            });
        
            function load_more(id ='') {
                $.ajax({
                    url: '{{ url('/load-more') }}',
                    method: 'POST',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },
                data:{id:id},
                    success: function(data) {
                        $('#load_more_button').remove();
                        $('#all_product').append(data);
                        
                    }
                });
            }
            $(document).on('click', '#load_more_button',function(){
                var id = $(this).data('id');
                load_more(id);
            });
        </script>
    <script type="text/javascript">
       show_cart();
            //dem so luong gio hang
            function show_cart(){
                $.ajax({
                    url: '{{ url('/show-cart') }}',
                    method: 'GET',
                    success: function(data) {
                        $('.show-cart').html(data);
                    }
                });
            }
    function Addtocart($product_id){
        var id = $product_id;
                // alert(id);
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();

                var _token = $('input[name="_token"]').val();
                if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                    alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
                } else {

                    $.ajax({
                        url: '{{ url('/add-cart-ajax') }}',
                        method: 'POST',
                        data: {
                            cart_product_id: cart_product_id,
                            cart_product_name: cart_product_name,
                            cart_product_image: cart_product_image,
                            cart_product_price: cart_product_price,
                            cart_product_qty: cart_product_qty,
                            _token: _token,
                            cart_product_quantity: cart_product_quantity
                        },
                        success: function() {

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{ url('/gio-hang') }}";
                                });
                                show_cart();

                        }

                    });
                }
    }
      </script>


    <script type="text/javascript">
        $(document).ready(function() {
            show_cart();
            //dem so luong gio hang
            function show_cart(){
                $.ajax({
                    url: '{{ url('/show-cart') }}',
                    method: 'GET',
                    success: function(data) {
                        $('.show-cart').html(data);
                    }
                });
            }
            $('.add-to-cart').click(function() {

                var id = $(this).data('id_product');
                // alert(id);
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();

                var _token = $('input[name="_token"]').val();
                if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                    alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
                } else {

                    $.ajax({
                        url: '{{ url('/add-cart-ajax') }}',
                        method: 'POST',
                        data: {
                            cart_product_id: cart_product_id,
                            cart_product_name: cart_product_name,
                            cart_product_image: cart_product_image,
                            cart_product_price: cart_product_price,
                            cart_product_qty: cart_product_qty,
                            _token: _token,
                            cart_product_quantity: cart_product_quantity
                        },
                        success: function() {

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{ url('/gio-hang') }}";
                                });
                                show_cart();

                        }

                    });
                }


            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{ url('/select-delivery-home') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.calculate_delivery').click(function() {
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                if (matp == '' && maqh == '' && xaid == '') {
                    alert('Làm ơn chọn để tính phí vận chuyển');
                } else {
                    $.ajax({
                        url: '{{ url('/calculate-fee') }}',
                        method: 'POST',
                        data: {
                            matp: matp,
                            maqh: maqh,
                            xaid: xaid,
                            _token: _token
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.send_order').click(function() {
                swal({
                        title: "Xác nhận đơn hàng",
                        text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Mua hàng",

                        cancelButtonText: "Đóng,chưa mua",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            var shipping_email = $('.shipping_email').val();
                            var shipping_name = $('.shipping_name').val();
                            var shipping_address = $('.shipping_address').val();
                            var shipping_phone = $('.shipping_phone').val();
                            var shipping_notes = $('.shipping_notes').val();
                            var shipping_method = $('.payment_select').val();
                            var order_fee = $('.order_fee').val();
                            var order_coupon = $('.order_coupon').val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: '{{ url('/confirm-order') }}',
                                method: 'POST',
                                data: {
                                    shipping_email: shipping_email,
                                    shipping_name: shipping_name,
                                    shipping_address: shipping_address,
                                    shipping_phone: shipping_phone,
                                    shipping_notes: shipping_notes,
                                    _token: _token,
                                    order_fee: order_fee,
                                    order_coupon: order_coupon,
                                    shipping_method: shipping_method
                                },
                                success: function() {
                                    swal("Đơn hàng",
                                        "Đơn hàng của bạn đã được gửi thành công",
                                        "success");
                                }
                            });

                            window.setTimeout(function() {
                                window.location.href = "{{ url('/lichsudh') }}";
                            }, 3000);

                        } else {
                            swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");

                        }

                    });
            });
        });
    </script>
    <script type="text/javascript">
        function view() {
            if (localStorage.getItem('data') != null) {
                var data = JSON.parse(localStorage.getItem('data'));
                data.reverse();
                document.getElementById('row_wishlist').style.overflow = 'scroll';
                document.getElementById('row_wishlist').style.height = '600px';

                for (i = 0; i < data.length; i++) {
                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;
                    $("#row_wishlist").append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img src="' +
                        newItem.image + '" width="100%"></div><div class="col=md-8 info_wishlist"><p>' + newItem.name +
                        '</p><p style="color : #FE980F">' + newItem.price + '</p><a href="' + newItem.url +
                        '">Đặt hàng</a></div></div>');

                }
            }
        }
        view();

        function add_wishlist(clicked_id) {
            var id = clicked_id;

            var name = document.getElementById('wishlist_productname' + id).value;
            var price = document.getElementById('wishlist_productprice' + id).value;
            var image = document.getElementById('wishlist_productimage' + id).src;
            var url = document.getElementById('wishlist_producturl' + id).href;

            var newItem = {
                'url': url,
                'id': id,
                'name': name,
                'price': price,
                'image': image
            }

            if (localStorage.getItem('data') == null) {
                localStorage.setItem('data', '[]');
            }
            var old_data = JSON.parse(localStorage.getItem('data'));

            var matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            });

            if (matches.length) {
                alert('Đã yêu thích sản phẩm, không thể thêm yêu thích');
            } else {
                old_data.push(newItem);
                $("#row_wishlist").append('<div class="row" style="margin:10px 0"><div class="col-md-4"><img src="' +
                    newItem.image + '" width="100%"></div><div class="col=md-8 info_wishlist"><p>' + newItem.name +
                    '</p><p style="color : #FE980F">' + newItem.price + '</p><a href="' + newItem.url +
                    '">Đặt hàng</a></div></div>');
            }
            localStorage.setItem('data', JSON.stringify(old_data));
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#imageGallery').lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 3,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '.watch-video', function() {
            var video_id = $(this).attr('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/watch-video') }}',
                method: "POST",
                dataType: "JSON",
                data: {
                    video_id: video_id,
                    _token: _token
                },
                success: function(data) {
                    $('#video_title').html(data.video_title);
                    $('#video_link').html(data.video_link);
                    $('#video_desc').html(data.video_desc);
                }
            });
        })
    </script>
    <script type="text/javascript">
        $('#keywords').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/autocomplete-ajax') }}',
                    method: "POST",

                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });
            } else {
                $('#search_ajax').fadeOut();
            }
        });
        $(document).on('click', 'li', function() {
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        })
    </script>
     <script type="text/javascript">
     function Xemnhanh(id){
        var product_id = id;
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/quickview') }}',
                method: "POST",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    $('#product_quickview_title').html(data.product_name);
                    $('#product_quickview_price').html(data.product_price);
                    $('#product_quickview_image').html(data.product_image);
                    $('#product_quickview_id').html(data.product_id);
                    $('#product_quickview_gallery').html(data.product_gallery);
                    $('#product_quickview_desc').html(data.product_desc);
                    $('#product_quickview_content').html(data.product_content);
                    $('#product_quickview_value').html(data.product_quickview_value);
                    $('#product_quickview_button').html(data.product_button);


                }
            });
     }
     </script>
    <script type="text/javascript">
        $('.xemnhanh').click(function() {
            var product_id = $(this).data('id_product');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/quickview') }}',
                method: "POST",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    $('#product_quickview_title').html(data.product_name);
                    $('#product_quickview_price').html(data.product_price);
                    $('#product_quickview_image').html(data.product_image);
                    $('#product_quickview_id').html(data.product_id);
                    $('#product_quickview_gallery').html(data.product_gallery);
                    $('#product_quickview_desc').html(data.product_desc);
                    $('#product_quickview_content').html(data.product_content);
                    $('#product_quickview_value').html(data.product_quickview_value);
                    $('#product_quickview_button').html(data.product_button);


                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '.add-to-cart-quickview', function() {

            var id = $(this).data('id_product');
            // alert(id);
            var cart_product_id = $('.cart_product_id_' + id).val();
            var cart_product_name = $('.cart_product_name_' + id).val();
            var cart_product_image = $('.cart_product_image_' + id).val();
            var cart_product_quantity = $('.cart_product_quantity_' + id).val();
            var cart_product_price = $('.cart_product_price_' + id).val();
            var cart_product_qty = $('.cart_product_qty_' + id).val();

            var _token = $('input[name="_token"]').val();
            if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
            } else {

                $.ajax({
                    url: '{{ url('/add-cart-ajax') }}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                        cart_product_qty: cart_product_qty,
                        _token: _token,
                        cart_product_quantity: cart_product_quantity
                    },
                    beforeSend: function() {
                        $("#beforesend_quickview").html(
                            "<p class='text text-primary'>Đang thêm sản phẩm vào giỏ hàng</p>");
                    },
                    success: function() {
                        $("#beforesend_quickview").html(
                            "<p class='text text-success'>Đã thêm sản phẩm vào giỏ hàng</p>");
                    }

                });
            }
        });
        $(document).on('click', '.redirect-cart', function() {
            window.location.href = "{{ url('/gio-hang') }}";
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            load_comment();

            function load_comment() {
                var product_id = $('.comment_product_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/load-comment') }}',
                    method: 'POST',
                    data: {
                        product_id: product_id,
                        _token: _token,
                    },
                    success: function(data) {
                        $('#comment_show').html(data);
                    }

                });
            }
            $('.send-comment').click(function() {
                var product_id = $('.comment_product_id').val();
                var comment_name = $('.comment_name').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/send-comment') }}',
                    method: 'POST',
                    data: {
                        product_id: product_id,
                        comment_name: comment_name,
                        comment_content: comment_content,
                        _token: _token,
                    },
                    success: function(data) {

                        $('#notify_comment').html(
                            '<span class="text text-success">Them binh luan thanh cong, cho xem xet</span>'
                        )
                        load_comment();
                        $('#notify_comment').fadeOut(5000);

                        $('.comment_name').val('');
                        $('.comment_content').val('');
                    }

                });
            });
        });
    </script>
    <script type="text/javascript">
        function remove_background(product_id) {
            for (var count = 1; count <= 5; count++) {
                $('#' + product_id + '-' + count).css('color', '#ccc');
            }
        }
        //hover chuột đánh giá sao
        $(document).on('mouseenter', '.rating', function() {
            var index = $(this).data("index"); //3
            var product_id = $(this).data('product_id'); //13

            // alert(index);
            // alert(product_id);
            remove_background(product_id);
            for (var count = 1; count <= index; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });
        //nhả chuột ko đánh giá
        $(document).on('mouseleave', '.rating', function() {
            var index = $(this).data("index");
            var product_id = $(this).data('product_id');
            var rating = $(this).data("rating");
            remove_background(product_id);
            //alert(rating);
            for (var count = 1; count <= rating; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });
        //clivk danh gia sao
        $(document).on('click', '.rating', function() {
            var index = $(this).data("index"); // Lấy giá trị index của đánh giá
            var product_id = $(this).data('product_id'); // Lấy giá trị product_id từ phần tử HTML
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ url('insert-rating') }}",
                method: 'POST',
                data: {
                    index: index,
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    if (data == 'done') {
                        alert("Bạn đã đánh giá " + index + " trên 5");
                        location.reload();
                    } else {
                        alert("Bạn chưa đánh giá");
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sort').on('change', function() { // fix syntax error here
                var url = $(this).val();
                if (url) {
                    window.location = url;
                } else {
                    return false;
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#slider-range").slider({
                orientation: "horizontal",
                range: true,
                min: {{ $min_price }},
                max: {{ $max_price }},
                step: 10000, // Adjust the step size according to your needs
                values: [{{ $min_price }}, {{ $max_price }}],
                slide: function(event, ui) {
                    // Format the price range with commas for better readability
                    $("#amount").val(formatCurrency(ui.values[0]) + " - " + formatCurrency(ui.values[
                        1]));
                    $("#start_price").val(ui.values[0]);
                    $("#end_price").val(ui.values[1]);
                }
            });

            // Function to format currency with commas
            function formatCurrency(value) {
                return "đ" + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Set initial price range value
            $("#amount").val(formatCurrency($("#slider-range").slider("values", 0)) + " - " + formatCurrency($(
                "#slider-range").slider("values", 1)));
        });
    </script>
     <script type="text/javascript">
        function huydh(id){
            var order_code = id;
            var lydohuy = $('.lydohuy').val();
          
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ url('huy-don-hang') }}",
                method: 'POST',
                data: {
                    order_code:order_code,
                    lydohuy:lydohuy,
                   
                    _token: _token
                },
                success: function(data) {
                   alert('Hủy đơn hàng thành công');
                   location.reload();

                }
            });
        }
    </script>
</body>

</html>
