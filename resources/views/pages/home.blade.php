@extends('layout')
@section('content')
    <div class="features_items">
        <h2 class="title text-center">SẢN PHẨM MỚI NHẤT</h2>
        <div class="row"> <!-- Thêm lớp row ở đây -->
            @foreach ($all_product as $key => $product)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <form>
                                    @csrf
                                    <input type="hidden" value="{{ $product->product_id }}"
                                        class="cart_product_id_{{ $product->product_id }}">
                                    <input type="hidden" id="wishlist_productname{{ $product->product_id }}"
                                        value="{{ $product->product_name }}"
                                        class="cart_product_name_{{ $product->product_id }}">
                                    <input type="hidden" value="{{ $product->product_quantity }}"
                                        class="cart_product_quantity_{{ $product->product_id }}">
                                    <input type="hidden" value="{{ $product->product_image }}"
                                        class="cart_product_image_{{ $product->product_id }}">
                                    <input type="hidden" id="wishlist_productprice{{ $product->product_id }}"
                                        value="{{ $product->product_price }}"
                                        class="cart_product_price_{{ $product->product_id }}">
                                    <input type="hidden" value="1"
                                        class="cart_product_qty_{{ $product->product_id }}">
                                    <a id="wishlist_producturl{{ $product->product_id }}"
                                        href="{{ URL::to('chi-tiet-san-pham/' . $product->product_slug) }}">
                                        <img id="wishlist_productimage{{ $product->product_id }}"
                                            src="{{ URL::to('public/uploads/product/' . $product->product_image) }}"
                                            alt="" />

                                        <p style="margin-top: 30px">{{ $product->product_name }}</p>
                                        <h2 style="color: red">{{ number_format($product->product_price, 0, ',', '.') }}đ
                                        </h2>


                                    </a>
                                    {{-- <style>
                                        .xemnhanh{
                                            background: #f5f5ED;
                                            border: 0 none;
                                            border-radius: 0;
                                            color: #696763;
                                            font-family: 'ROBOTO',sans-serif;
                                            font-size: 15px;
                                            margin-bottom: 25px;
                                        }
                                    </style>
                                    <input type="button" class="btn btn-default add-to-cart"
                                        data-id_product="{{ $product->product_id }}" name="add-to-cart"
                                        value="Them gio hang">
                                    <input type="button" data-toggle="modal" data-target="#xemnhanh"
                                        class="btn btn-default xemnhanh" data-id_product="{{ $product->product_id }}"
                                        name="add-to-cart" value="Xem nhanh"> --}}
                                    <style>
                                        .add-to-cart {
                                            border-radius: 50%;
                                            background-color: #000;
                                            color: #fff;
                                            padding: 10px;
                                            transition: background-color 0.3s ease;
                                            border: none;
                                            overflow: hidden;
                                            /* Giữ cho phần bên ngoài khu vực hình tròn bị ẩn đi */
                                        }

                                        .add-to-cart:hover {
                                            background-color: #333;
                                            transform: scale(1.1);
                                        }
                                    </style>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- <input type="button" class="btn btn-default add-to-cart"
                                                data-id_product="{{ $product->product_id }}" name="add-to-cart"
                                                value="Them gio hang"> --}}
                                            <button type="button" class="btn btn-default add-to-cart"
                                                data-id_product="{{ $product->product_id }}" name="add-to-cart">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>


                                        </div>
                                        <div class="col-md-6">
                                            <input type="button" data-toggle="modal" data-target="#xemnhanh"
                                                class="btn btn-default xemnhanh"
                                                data-id_product="{{ $product->product_id }}" name="add-to-cart"
                                                value="Xem nhanh">
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li>
                                    <i class="fa fa-heart"></i>
                                    <button class="button_wishlist" id="{{ $product->product_id }}"
                                        onclick="add_wishlist(this.id);">
                                        <span>Yêu thích</span>
                                    </button>
                                </li>
                                <li><a href="#"><i class="fa fa-plus-square"></i>So sanh</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Modal Xem nhanh san pham-->
        <div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title product_quickview_title" id="">
                            <span id="product_quickview_title"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <style>
                            span#product_quickview_content img {
                                width: 100%;
                            }

                            @media screen and (min-width: 768px) {
                                .modal-dialog {
                                    width: 700px;
                                }

                                .modal-sm {
                                    width: 350px;
                                    /* Set width for small-sized devices */
                                }
                            }

                            @media screen and (min-width: 992px) {
                                .modal-lg {
                                    width: 1200px;
                                }
                            }
                        </style>

                        <div class="row">
                            <div class="col-md-5">
                                <span id="product_quickview_image"></span>
                                <span id="product_quickview_gallery"></span>
                            </div>
                            <form>
                                @csrf
                                <div id="product_quickview_value"></div>
                                <div class="col-md-7">

                                    <h2 class="quickview"><span id="product_quickview_title"></span></h2>
                                    <p style="color: brown">Ma ID: <span id="product_quickview_id"></span></p>

                                    <span>
                                        <h3 style="color: brown">Giá san pham: <span id="product_quickview_price"></span>
                                        </h3>
                                        <h3 style="color: brown">Số lượng:</h3>
                                        <input name="qty" type="number" min="1" class="cart_product_qty"
                                            value="1" />
                                        <input name="productid_hidden" type="hidden" value="" />
                                    </span><br />
                                    <h3 style="color: brown" class="quickview">Mo ta san pham: </h3>
                                    <fieldset>
                                        <span style="width: 100%" id="product_quickview_desc"></span>
                                        <span style="width: 100%" id="product_quickview_content"></span>
                                    </fieldset>
                                    <div id="product_quickview_button"></div>
                                    <div id="beforesend_quickview"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Dong</button>
                        <button type="button" class="btn btn-primary redirect-cart">Toi gio hang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .product-image-wrapper {
        margin-bottom: 20px;
        border-radius: 10px;
        /* Bo tròn góc */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Đổ bóng */
        transition: transform 0.3s ease;
        /* Thêm hiệu ứng chuyển đổi */
    }

    .product-image-wrapper:hover {
        transform: scale(1.05);
        /* Phóng to 5% khi di chuột vào */
    }

    .productinfo {
        position: relative;
    }

    .productinfo h2 {
        font-size: 18px;
        margin-top: 10px;
    }

    .productinfo p {
        font-size: 16px;
        margin-bottom: 15px;
    }

    .add-to-cart:hover {
        background-color: #E58E0B;
        /* Màu nền khi hover */
    }

    /* CSS cho nút yêu thích */
    .button_wishlist {
        border: none;
        background: transparent;
        color: #83AFA8;
        font-size: 14px;
        cursor: pointer;
        padding: 0;
    }

    .button_wishlist span:hover {
        color: #FE980F;
        /* Màu khi hover */
    }

    /* CSS cho nút xem nhanh */
    .choose .nav-pills li:nth-child(2) a {
        color: #ff0000;
        font-size: 14px;
        padding: 0;
    }

    .choose .nav-pills li:nth-child(2) a:hover {
        color: #FE980F;
        /* Màu khi hover */
    }

    ul.nav.nav-pills.nav-justified li {
        text-align: center;
        font-size: 13px;
    }

    .button_wishlist {
        border: none;
        background: #ffffff;
        color: #ff0000;

    }

    ul.nav.nav-pills.nav-justified i {
        color: #ff0000;
    }

    .button_wishlist span:hover {
        color: #FE980F;
    }

    .button_wishlist:focus {
        border: none;
        outline: none
    }
</style>
