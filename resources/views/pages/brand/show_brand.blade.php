@extends('layout')
@section('content')
    <div class="features_items">
        @foreach ($brand_name as $key => $name)
            <h2 class="title text-center">Thương hiệu: {{ $name->brand_name }}</h2>
            @foreach ($brand_by_id as $key => $product)
                <a href="{{ URL::to('chi-tiet-san-pham/' . $product->product_slug) }}">
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{ URL::to('public/uploads/product/' . $product->product_image) }}"
                                        alt="" />
                                    <p style="margin-top: 20px">{{ $product->product_name }}</p>
                                    <h2>{{ number_format($product->product_price, 0, ',', '.') }}đ</h2>

                                    <input type="button" value="Xem sản phẩm" class="btn btn-danger btn-sm add-to-cart"
                                        data-id_product="{{ $product->product_id }}" name="add-to-cart">
                                </div>

                            </div>

                        </div>
                    </div>
                </a>
            @endforeach
        @endforeach
    </div>
    <div class="fb-comments" data-href="http://vulinh.com/laravel_shopTMDT/danh-muc-san-pham/4" data-width="" data-numposts="20"></div>
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

    .add-to-cart {
        border-radius: 20px;
        /* Đặt viền tròn */
        background-color: red;
        /* Đặt màu nền là màu đỏ */
        color: white;
        /* Đặt màu chữ là trắng */
        border: none;
        /* Loại bỏ viền */
        padding: 5px 10px;
       
    }

    .add-to-cart:hover {
        background-color: darkred;
        /* Đổi màu nền khi di chuột qua */
    }
    input.btn.btn-danger.btn-sm.add-to-cart {
    margin-bottom: 10px;
}
</style>
