@extends('layout')
@section('sliderbar')
@include('pages.include.sliderbar')
@endsection
@section('content')
    <div class="features_items">
        <h2 class="title text-center">VIDEO SAN PHAM</h2>
        <div class="row"> <!-- Thêm lớp row ở đây -->
            @foreach ($all_video as $key => $video)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <form>
                            @csrf
                            <div class="single-products sig-video">
                                <div class="productinfo text-center">
                                    <form>
                                        @csrf

                                        <a href="">
                                            <img src="{{ asset('public/uploads/videos/' . $video->video_image) }}"
                                                alt="{{ $video->video_title }}" />
                                            <h2>{{ $video->video_title }}</h2>
                                            <p>{{ $video->video_desc }}</p>

                                        </a>
                                        <button type="button" class="btn btn-primary watch-video" data-toggle="modal"
                                            data-target="#model_video" id="{{ $video->video_id }}">
                                            Xem video
                                        </button>
                                    </form>
                                </div>

                            </div>
                            <div class="choose">
                                <ul class="nav nav-pills nav-justified">
                                    <style type="text/css">
                                        ul.nav.nav-pills.nav-justified li {
                                            text-align: center;
                                            font-size: 13px;
                                        }

                                        .button_wishlist {
                                            border: none;
                                            background: #ffffff;
                                            color: #83AFA8;

                                        }

                                        ul.nav.nav-pills.nav-justified i {
                                            color: #83AFA8;
                                        }

                                        .button_wishlist span:hover {
                                            color: #FE980F;
                                        }

                                        .button_wishlist:focus {
                                            border: none;
                                            outline: none
                                        }
                                    </style>



                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Modal -->
        <div class="modal fade" id="model_video" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="video_title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="video_desc"></div>
                        <div id="video_link"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .single-products.sig-video {
        height: 400px;
    }
</style>
