<div class="col-sm-3">
    <div class="left-sidebar">
        {{-- <h2>DANH MỤC SẢN PHẨM</h2>
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

        </div> --}}

        {{-- <div class="brands_products">
            <h2>THƯƠNG HIỆU SẢN PHẨM</h2>
            @foreach ($brand as $key => $brand)
                <div class="brands-name">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="{{ URL::to('/thuong-hieu-san-pham/' . $brand->brand_slug) }}">
                                <span class="pull-right"></span>{{ $brand->brand_name }}</a></li>

                    </ul>
                </div>
            @endforeach
        </div> --}}
        <div class="brands_products">
            <h2>SẢN PHẨM YÊU THÍCH</h2>

            <div class="brands-name">
                <div id="row_wishlist" class="row">

                </div>
            </div>

        </div>

    </div>
</div>