@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  Thêm danh mục bai viet
                </header>
                <div class="panel-body">
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-category-post')}}" method="POST">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Tên danh mục</label>
                            <input type="text" class="form-control"  name="cate_post_name"  id="slug" onkeyup="ChangeToSlug();" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="cate_post_slug" class="form-control" id="convert_slug" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize: none"rows="5"  name="cate_post_desc" class="form-control" id="" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="cate_post_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                              
                            </select>
                        </div>
                        <button type="submit" name="add_cate_post" class="btn btn-success">Thêm danh mục bai viet</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection