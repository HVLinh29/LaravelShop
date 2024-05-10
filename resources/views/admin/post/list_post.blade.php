@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
    Liệt kê bài viết
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="myTable">
          <?php
          $message = Session::get('message');
          if($message){
              echo '<span class="text-alert">'.$message.'</span>';
              Session::put('message',null);
          }
          ?>
          <thead>
            <tr>
              
              <th style="color: brown">Tên bài viết</th>
              <th style="color: brown">Slug</th>
              <th style="color: brown">Mô tả bài viết</th>
              <th style="color: brown">Hình ảnh bài viết</th>
              <th style="color: brown">Từ khóa bài viết</th>
              <th style="color: brown">Danh mục bài viết</th>
              <th style="color: brown">Hiển thị</th>
              <th style="color: brown">Quản lý</th>

            </tr>
          </thead>
          <tbody>
            @foreach($all_post as $key =>$post)
            <tr>
              <td>{{$post->post_title}}</td>
              <td>{{$post->post_slug}}</td>
              <td>{!!$post->post_desc!!}</td>
              <td><img src ="public/uploads/post/{{$post->post_image}}" height="100" width="100"></td>
              <td>{{$post->post_meta_keywords}}</td>
              <td>{{$post->cate_post->cate_post_name}}</td>
              <td>
                @if($post->post_status==0)
                Ẩn
                @else
                Hiển thị
                @endif
              </td>
              
              <td>
                <a href="{{URL::to('/edit-post/'.$post->post_id)}}" class="active btn btn-success" ui-toggle-class="">
               Sửa</a>
                <a onclick="return confirm('Bạn có muốn xóa bai viet này  ?')" href="{{URL::to('/delete-post/'.$post->post_id)}}" 
                  class="active btn btn-danger" ui-toggle-class="">Xóa
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{-- Xuat nhap excel --}}
        <form action="{{url('import-csv-postoduct')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <input type="file" name="file" accept=".xlsx"><br>
       <input type="submit" value="Import Excel" name="import_csv" class="btn btn-warning">
        </form>
      </br>
       <form action="{{url('export-csv-postoduct')}}" method="POST">
          @csrf
       <input type="submit" value="Export Excel" name="export_csv" class="btn btn-success">
      </form>
      </div>
      
    </div>
  </div>
@endsection