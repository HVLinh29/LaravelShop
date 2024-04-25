@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  Cập nhật danh mục sản phẩm
                </header>
                <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                <div class="panel-body">
                    @foreach($edit_category_product as $key =>$edit_value)
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input type="text" value="{{$edit_value->category_name}}" onkeyup="ChangeToSlug();" name="category_product_name" class="form-control" id="slug" >
                            </div>
                              <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" value="{{$edit_value->category_slug}}" name="category_slug" class="form-control" id="convert_slug" >
                            </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize: none"rows="5"  name="category_product_desc" class="form-control" 
                             id="exampleInputPassword1" >{{$edit_value->category_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa danh mục</label>
                            <textarea style="resize: none"rows="5"  name="category_product_keywords" 
                            class="form-control" id="exampleInputPassword1" >{{$edit_value->meta_keywords}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Thuoc danh muc</label>
                            <select name="category_parent" class="form-control input-sm m-bot15">
                                <option value="0">Danh muc cha</option>
                                @foreach($category as $key => $val)
                                    @if($val->category_parent==0)
                                    <option {{$val->category_id==$edit_value->category_id ? 'selected' : ''}} value="{{$val->category_id}}">{{$val->category_name}}</option>
                                    @endif
                                    @foreach($category as $key => $val2)
                                        @if($val2->category_parent==$val->category_id)
                                            <option {{$val2->category_id==$edit_value->category_id ? 'selected' : ''}} value="{{$val2->category_id}}"> ---{{$val2->category_name}}</option>
                                        @endif
                                    @endforeach
                              @endforeach
                              
                            </select>
                        </div>
                        <button type="submit" name="update_category_product" class="btn btn-success">Cập nhật danh mục</button>
                    </form>
                    </div>
                    @endforeach

                </div>
            </section>

    </div>
    
</div>
@endsection