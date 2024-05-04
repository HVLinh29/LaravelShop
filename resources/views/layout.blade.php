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


                                {{-- <li><a href="{{ URL::to('show-cart') }}"><i class="fa fa-shopping-cart"></i> Gio
                                        hang</a></li> --}}
                                <li><a href="{{ URL::to('/gio-hang') }}"><i class="fa fa-shopping-cart"></i> Giỏ
                                        hàng</a></li>

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
                                <li><a href="{{ URL::to('/gio-hang') }}">Giỏ hàng</a></li>
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
                                <li><a href="#">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <form method="POST" action="{{ URL::to('/tim-kiem') }}" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="search_box pull-right">
                                <input type="text" name="keywords_submit" id="keywords" placeholder="Từ khóa" />
                                <div id="search_ajax"></div>
                                <input type="submit" style="color: #000" name="search_item"
                                    class=" btn-success btn-sm" value="Tìm kiếm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->

    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($slider as $key => $slide)
                                @php
                                    $i++;
                                @endphp
                                <div class="item {{ $i == 1 ? 'active' : '' }}">

                                    <div class="col-sm-12">
                                        <img alt="{{ $slide->slider_desc }}"
                                            src="{{ asset('public/uploads/slider/' . $slide->slider_image) }}"
                                            height="200" width="100%" class="img img-reponsive">
                                    </div>
                                </div>
                            @endforeach

                        </div>


                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section><!--/slider-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>DANH MỤC SẢN PHẨM</h2>
                        <div class="panel-group category-products" id="accordian">
                            @foreach ($category as $key => $cate)
                                <div class="panel panel-default">
                                    @if ($cate->category_parent == 0)
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordian"
                                                    href="#{{ $cate->category_id }}"><span
                                                        class="badge pull-right"><i class="fa fa-plus"></i></span>
                                                    {{ $cate->category_name }}</a>
                                            </h4>
                                        </div>
                                        <div id="{{ $cate->category_id }}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul>
                                                    @foreach ($category as $key => $cate_sub)
                                                        @if ($cate_sub->category_parent == $cate->category_id)
                                                            <li><a
                                                                    href="{{ URL::to('/danh-muc-san-pham/' . $cate_sub->category_slug) }}">
                                                                    {{ $cate_sub->category_name }} </a></li>
                                                        @endif
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                        </div>

                        <div class="brands_products">
                            <h2>THƯƠNG HIỆU SẢN PHẨM</h2>
                            @foreach ($brand as $key => $brand)
                                <div class="brands-name">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="{{ URL::to('/thuong-hieu-san-pham/' . $brand->brand_slug) }}">
                                                <span class="pull-right"></span>{{ $brand->brand_name }}</a></li>

                                    </ul>
                                </div>
                            @endforeach
                        </div>
                        <div class="brands_products">
                            <h2>SẢN PHẨM YÊU THÍCH</h2>

                            <div class="brands-name">
                                <div id="row_wishlist" class="row">

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('public/fontend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/fontend/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('public/fontend/js/lightslider.js') }}"></script>
    <script src="{{ asset('public/fontend/js/prettify.js') }}"></script>



    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v19.0"
        nonce="HvSWG6qx"></script>
    <script type="text/javascript">
        $(document).ready(function() {
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
                                location.reload();
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
                        $("#beforesend_quickview").html("<p class='text text-primary'>Dang them san pham vao gio hang</p>");
                    },
                    success: function() {
                        $("#beforesend_quickview").html("<p class='text text-success'>Da them san pham vao gio hang</p>");
                    }

                });
            }
        });
        $(document).on('click', '.redirect-cart', function() {
            window.location.href = "{{url('/gio-hang')}}";
        });

    </script>


</body>

</html>
