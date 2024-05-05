@extends('layout')
@section('content')

<div class="features_items">
   
     <div class="fb-like" data-href="{{$url_canonical}}" data-width="" 
     data-layout="" data-action="" data-size="" data-share="true"></div>
    @foreach($category_name as $key =>$name)
   
    <h2 class="title text-center">Danh mục: {{$name->category_name}}</h2>
    @endforeach

    <div class="row">
        <div class="col-md-4">
            <label for="amount">Sắp xếp theo</label>    
            <form>
                @csrf
                <select name="sort" id="sort" class="form-control">
                    <option value="{{Request::url()}}?sort_by=none">Lọc</option>
                    <option value="{{Request::url()}}?sort_by=tang_dan">Gía tăng dần</option>
                    <option value="{{Request::url()}}?sort_by=giam_dan">Gía giảm dần</option>
                    <option value="{{Request::url()}}?sort_by=kytu_az">A đến Z</option>
                    <option value="{{Request::url()}}?sort_by=kytu_za">Z đến A</option>
                </select>
            </form>
        </div>
    </div>


    @foreach($category_by_id as $key =>$product)
    <a href="{{URL::to('chi-tiet-san-pham/'.$product->product_slug)}}">
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                        <h2>{{number_format($product->product_price,0,',','.')}}đ</h2>
                        <p>{{$product->product_name}}</p>
                        <input type="button" value="Xem sản phẩm" class="btn btn-danger btn-sm add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
                    </div>
            </div>
           
        </div>
    </div>
    </a>
    @endforeach
   
    
</div>

<div class="fb-comments" data-href="http://vulinh.com/laravel_shopTMDT/danh-muc-san-pham/4" data-width="" data-numposts="20"></div>
@endsection