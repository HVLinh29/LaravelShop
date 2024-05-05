@extends('layout')
@section('content')
    @foreach ($product_details as $key => $value)
        <div class="product-details"><!--product-details-->
            <style>
                .lSSlideOuter .lSPager.lSGallery img {
                    display: block;
                    height: 140px;
                    max-width: 100%;
                }

                li.active {
                    border: 2px solid brown;
                }
            </style>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: none">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chu</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ url('/danh-muc-san-pham/' . $cate_slug) }}">{{ $product_cate }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $meta_title }}</li>
                </ol>
            </nav>
            <div class="col-sm-5">
                <ul id="imageGallery">
                    @foreach ($gallery as $key => $gal)
                        <li data-thumb="{{ asset('public/uploads/gallery/' . $gal->gallery_image) }}"
                            data-src="{{ asset('public/uploads/gallery/' . $gal->gallery_image) }}">
                            <img width="100%" alt="{{ $gal->gallery_name }}"
                                src="{{ asset('public/uploads/gallery/' . $gal->gallery_image) }}" />
                        </li>
                    @endforeach



                </ul>

            </div>
            <div class="col-sm-7">
                <div class="product-information"><!--/product-information-->
                    <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                    <h2 style="color: red">{{ $value->product_name }}</h2>


                    <form action="{{ URL::to('/save-cart') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $value->product_id }}"
                            class="cart_product_id_{{ $value->product_id }}">

                        <input type="hidden" value="{{ $value->product_name }}"
                            class="cart_product_name_{{ $value->product_id }}">

                        <input type="hidden" value="{{ $value->product_image }}"
                            class="cart_product_image_{{ $value->product_id }}">

                        <input type="hidden" value="{{ $value->product_quantity }}"
                            class="cart_product_quantity_{{ $value->product_id }}">

                        <input type="hidden" value="{{ $value->product_price }}"
                            class="cart_product_price_{{ $value->product_id }}">

                        <span>
                            <span style="color: red">{{ number_format($value->product_price, 0, ',', '.') . 'đ' }}</span>

                            <label>Số lượng:</label>
                            <input name="qty" type="number" min="1"
                                class="cart_product_qty_{{ $value->product_id }}" value="1" />
                            <input name="productid_hidden" type="hidden" value="{{ $value->product_id }}" />
                        </span>
                        {{-- <input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart"
                            data-id_product="{{ $value->product_id }}" name="add-to-cart"> --}}
                        <div>
                            <button type="button" class="btn btn-default add-to-cart"
                                data-id_product="{{ $value->product_id }}" name="add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </form>

                    <p><b>Tình trạng:</b> Còn hàng</p>
                    <p><b>Điều kiện:</b> Mơi 100%</p>
                    <p><b>Số lượng kho còn:</b> {{ $value->product_quantity }}</p>
                    <p><b>Thương hiệu:</b> {{ $value->brand_name }}</p>
                    <p><b>Danh mục:</b> {{ $value->category_name }}</p>
                    <a href=""><img src="images/product-details/share.png" class="share img-responsive"
                            alt="" /></a>
                    <fieldset>
                        <legend>Tags</legend>
                        <p><i class="fa fa-tag"></i>
                            @php
                                $tags = $value->product_tags;
                                $tags = explode(',', $tags);
                            @endphp

                            @foreach ($tags as $tag)
                                <a href="{{ url('/tag/' . str_slug($tag)) }}" class="tags_style">{{ $tag }}</a>
                            @endforeach
                        </p>
                    </fieldset>
                    <style>
                        a.tags_style {
                            margin: 3px 2px;
                            border: 1px solid;

                            height: auto;
                            background: #428bca;
                            color: #ffff;
                            padding: 0px;
                        }

                        a.tags_style:hover {
                            background: #337ab7;
                            color: #ffff;
                        }
                    </style>
                </div><!--/product-information-->
            </div>
        </div><!--/product-details-->

        <div class="category-tab shop-details-tab"><!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li><a href="#details" data-toggle="tab">Mô tả</a></li>
                    <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
                    <li class="active"><a href="#reviews" data-toggle="tab">Đánh giá</a></li>


                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane" id="details">
                    <p>{!! $value->product_desc !!}</p>
                </div>

                <div class="tab-pane fade" id="companyprofile">
                    <p>{!! $value->product_content !!}</p>
                </div>
                <div class="tab-pane fade active in" id="reviews">
                    <div class="col-sm-12">
                        <ul>
                            <li><a href=""><i class="fa fa-user"></i>LINHWATCH</a></li>

                        </ul>
                        <style>
                            .style_comment {
                                border: 1px solid #ddd;
                                border-radius: 10px;
                                background: #F0F0E9
                            }
                        </style>
                        <form>
                            @csrf
                            <input type="hidden" name="comment_product_id" class="comment_product_id"
                                value="{{ $value->product_id }}">
                            <div id="comment_show"></div>

                        </form>
                        <p><b>Đánh giá sản phẩm </b></p>
                        {{-- Danh gia sao --}}
                        <div style="display: flex; align-items: center;">
                            <ul style="width: 80%;" class="list-inline rating" title="Average Rating"
                                style="margin-right: 10px;">
                                @for ($count = 1; $count <= 5; $count++)
                                    @php
                                        if ($count <= $rating) {
                                            $color = 'color:#ffcc00;';
                                        } else {
                                            $color = 'color:#ccc;';
                                        }
                                    @endphp

                                    <li title="star_rating" id="{{ $value->product_id }}-{{ $count }}"
                                        data-index="{{ $count }}" data-product_id="{{ $value->product_id }}"
                                        data-rating="{{ $rating }}" class="rating"
                                        style="cursor:pointer;{{ $color }} font-size:30px;">&#9733;</li>
                                @endfor
                            </ul>

                            <span>Số lượt đánh giá: {{ $ratingCount }}</span>
                        </div>

                        <p><b>Bình luận về sản phẩm</b></p>

                        <form action="#">
                            <span>
                                <input style="width: 100%;margin-left:0 " type="text" class="comment_name"
                                    placeholder="User" />
                            </span>
                            <textarea name="comment" class="comment_content" placeholder="Bình luận"></textarea>
                            <div id="notify_comment"></div>

                            <button type="button" class="btn btn-danger pull-right send-comment">
                                Gửi bình luận
                            </button>
                        </form>
                    </div>
                </div>



            </div>
        </div><!--/category-tab-->
    @endforeach
    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach ($splienquan as $key => $lienquan)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center product-related">
                                        <img src="{{ URL::to('public/uploads/product/' . $lienquan->product_image) }}"
                                            alt="" />
                                        <p>{{ $lienquan->product_name }}</p>
                                        <h2>{{ number_format($lienquan->product_price, 0, ',', '.') }}đ</h2>

                                        {{-- <input type="button" value="Thêm giỏ hàng"
                                            class="btn btn-danger btn-sm add-to-cart"
                                            data-id_product="{{ $value->product_id }}" name="add-to-cart"> --}}
                                        <button type="button" class="btn btn-default add-to-cart"
                                            data-id_product="{{ $value->product_id }}" name="add-to-cart">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>


                                    </div>

                                </div>
                            </div>
                        </div>
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
                    @endforeach


                </div>

            </div>

        </div>
    </div>
@endsection
<style>
    .product-image-wrapper {
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
        /* Phóng to khi di chuột vào */
    }
</style>
