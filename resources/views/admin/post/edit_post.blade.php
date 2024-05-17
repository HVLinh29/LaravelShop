@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật bài viết
                </header>
                <div class="panel-body">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                    ?>
                    <div class="position-center">
                        <form role="form" action="{{ URL::to('/update-post/'.$postbv->post_id) }}" method="POST" enctype="multipart/form-data">
                           @csrf
                            <div class="form-group">
                                <label for="">Tên bài viết</label>
                                <input type="text" class="form-control" value="{{$postbv->post_title}}" name="post_title"  id="slug" onkeyup="ChangeToSlug();" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" name="post_slug" value="{{$postbv->post_slug}}" class="form-control" id="convert_slug" placeholder="Slug">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tóm tắt bài viết</label>
                                <textarea style="resize: none"rows="5"  name="post_desc" class="form-control" id="cheditor" >{{$postbv->post_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung bài viết</label>
                                <textarea style="resize: none"rows="5"  name="post_content" class="form-control" id="cheditor1" >{{$postbv->post_content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta từ khóa</label>
                                <textarea style="resize: none"rows="5"  name="post_meta_keywords" class="form-control" id="" >{{$postbv->post_meta_keywords}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta nội dung</label>
                                <textarea style="resize: none"rows="5"  name="post_meta_desc" class="form-control" id="">{{$postbv->post_meta_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh bài viết</label>
                                <input type="file" class="form-control"  name="post_image"  id="exampleInputEmail1">
                                <img src="{{URL::to('public/uploads/post/'.$postbv->post_image)}}" width="100" height="100">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục bài viết</label>
                                <select name="cate_post_id" class="form-control input-sm m-bot15">
                                 @foreach($cate_post as $key =>$cate)
                                    <option {{$postbv->cate_post_id==$cate->cate_post_id ? 'selected' : ''}} 
                                        value="{{$cate->cate_post_id}}">{{$cate->cate_post_name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="post_status" class="form-control input-sm m-bot15">
                                    @if($postbv->post_status == 0)
                                    <option selected value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                    @else
                                    <option  value="0">Ẩn</option>
                                    <option selected value="1">Hiển thị</option>
                                    @endif

                                </select>
                            </div>
                            <button type="submit" name="update_post" class="btn btn-success">Cập nhật bài viết</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
