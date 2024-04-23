{{-- @extends('layout')
@section('content')
    <div class="features_items">
        <h2 class="title text-center">DANH MUC BAI VIET</h2>
        <div class="row"> <!-- Thêm lớp row ở đây -->
        @foreach ($all_product as $key => $product)
           

        @endforeach
        </div>
    </div>
@endsection
<style>
 /* CSS cho sản phẩm */
.product-image-wrapper {
    margin-bottom: 20px;
}

.productinfo {
    position: relative;
}

.productinfo form {
    padding: 20px;
    background-color: #fff; /* Màu nền */
    border-radius: 10px; /* Bo tròn viền */
    box-shadow: 0px 2px 10px white; /* Hiệu ứng đổ bóng */
}

.productinfo h2 {
    font-size: 18px;
    margin-top: 10px;
}

.productinfo p {
    font-size: 16px;
    margin-bottom: 15px;
}

.add-to-cart {
    background-color: #FE980F; /* Màu nút thêm vào giỏ hàng */
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 3px;
    cursor: pointer;
}

.add-to-cart:hover {
    background-color: #E58E0B; /* Màu nền khi hover */
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
    color: #FE980F; /* Màu khi hover */
}

/* CSS cho nút xem nhanh */
.choose .nav-pills li:nth-child(2) a {
    color: #83AFA8;
    font-size: 14px;
    padding: 0;
}

.choose .nav-pills li:nth-child(2) a:hover {
    color: #FE980F; /* Màu khi hover */
}



</style> --}}