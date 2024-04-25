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
				li.active{
					border: 2px solid brown;
				}
            </style>
            <div class="col-sm-5">
                <ul id="imageGallery">
                    <li data-thumb="{{ asset('public/fontend/images/bia.jpg') }}"
                        data-src="{{ asset('public/fontend/images/bia.jpg') }}">
                        <img width="100%" src="{{ asset('public/fontend/images/bia.jpg') }}" />
                    </li>
                    <li data-thumb="{{ asset('public/fontend/images/bia.jpg') }}"
                        data-src="{{ asset('public/fontend/images/bia.jpg') }}">
                        <img width="100%" src="{{ asset('public/fontend/images/bia.jpg') }}" />
                    </li>
                    <li data-thumb="{{ asset('public/fontend/images/bia.jpg') }}"
                        data-src="{{ asset('public/fontend/images/bia.jpg') }}">
                        <img width="100%" src="{{ asset('public/fontend/images/bia.jpg') }}" />
                    </li>
                    <li data-thumb="{{ asset('public/fontend/images/bia.jpg') }}"
                        data-src="{{ asset('public/fontend/images/bia.jpg') }}">
                        <img width="100%" src="{{ asset('public/fontend/images/bia.jpg') }}" />
                    </li>
                    <li data-thumb="{{ asset('public/fontend/images/bia.jpg') }}"
                        data-src="{{ asset('public/fontend/images/bia.jpg') }}">
                        <img width="100%" src="{{ asset('public/fontend/images/bia.jpg') }}" />
                    </li>
                    <li data-thumb="{{ asset('public/fontend/images/bia.jpg') }}"
                        data-src="{{ asset('public/fontend/images/bia.jpg') }}">
                        <img width="100%" src="{{ asset('public/fontend/images/bia.jpg') }}" />
                    </li>



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
                        <input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart"
                            data-id_product="{{ $value->product_id }}" name="add-to-cart">
                    </form>

                    <p><b>Tình trạng:</b> Còn hàng</p>
                    <p><b>Điều kiện:</b> Mơi 100%</p>
                    <p><b>Số lượng kho còn:</b> {{ $value->product_quantity }}</p>
                    <p><b>Thương hiệu:</b> {{ $value->brand_name }}</p>
                    <p><b>Danh mục:</b> {{ $value->category_name }}</p>
                    <a href=""><img src="images/product-details/share.png" class="share img-responsive"
                            alt="" /></a>
                </div><!--/product-information-->
            </div>
        </div><!--/product-details-->

        <div class="category-tab shop-details-tab"><!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
                    <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>


                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="details">
                    <p>{!! $value->product_desc !!}</p>

                </div>

                <div class="tab-pane fade" id="companyprofile">
                    <p>{!! $value->product_content !!}</p>


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
                                        <h2>{{ number_format($lienquan->product_price, 0, ',', '.') }}đ</h2>
                                        <p>{{ $lienquan->product_name }}</p>
                                        <input type="button" value="Thêm giỏ hàng"
                                            class="btn btn-danger btn-sm add-to-cart"
                                            data-id_product="{{ $value->product_id }}" name="add-to-cart">


                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>

            </div>

        </div>
    </div>
@endsection
