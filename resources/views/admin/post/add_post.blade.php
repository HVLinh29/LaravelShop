@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm bai viet
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
                        <form role="form" action="{{ URL::to('/save-post') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="">Tên bai viet</label>
                                <input type="text" class="form-control" name="post_title"  id="slug" onkeyup="ChangeToSlug();" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" name="post_slug" class="form-control" id="convert_slug" placeholder="Slug">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tom tat bai viet</label>
                                <textarea style="resize: none"rows="5"  name="post_desc" class="form-control" id="cheditor" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Noi dung bai viet</label>
                                <textarea style="resize: none"rows="5"  name="post_content" class="form-control" id="cheditor1" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta tu khoa</label>
                                <textarea style="resize: none"rows="5"  name="post_meta_keywords" class="form-control" id="" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta noi dung</label>
                                <textarea style="resize: none"rows="5"  name="post_meta_desc" class="form-control" id="" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh bai viet</label>
                                <input type="file" class="form-control"  name="post_image"  id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh muc bai viet</label>
                                <select name="cate_post_id" class="form-control input-sm m-bot15">
                                 @foreach($cate_post as $key =>$cate)
                                    <option value="{{$cate->cate_post_id}}">{{$cate->cate_post_name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="post_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>

                                </select>
                            </div>
                            <button type="submit" name="add_brand_product" class="btn btn-success">Thêm bai viet</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
