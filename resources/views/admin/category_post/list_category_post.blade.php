@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <header class="panel-heading">
      Liệt kê danh mục bai viet
    </header>
      
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <?php
          $message = Session::get('message');
          if($message){
              echo '<span class="text-alert">'.$message.'</span>';
              Session::put('message',null);
          }
          ?>
          <thead>
            <tr>
              <th style="color:brown">Tên danh mục baiviet</th>
              <th style="color:brown">Slug</th>
              <th style="color:brown">Mo ta danh muc</th>
              <th style="color:brown">Hiển thị</th>
              <th style="color:brown">Quản lý</th>
            
            </tr>
          </thead>
          <tbody>
            @foreach($category_post as $key =>$cate_post)
            <tr>
              <td>{{$cate_post->cate_post_name}}</td>
              <td>{{$cate_post->cate_post_slug}}</td>
              <td>{{$cate_post->cate_post_desc}}</td>
              <td>
                @if($cate_post->cate_post_status==0)
                <span style="color:red">Ẩn</span>
                @else
                <span style="color:green">Hiển thị</span>
                @endif
              </td>
              
              <td>
                <a href="{{URL::to('/edit-category-post/'.$cate_post->cate_post_id)}}" class="active" ui-toggle-class="">
                  <i class="fa-regular fa-pen-to-square"></i></a>
                <a onclick="return confirm('Bạn có muốn xóa danh mục này?')" href="{{URL::to('/delete-category-post/'.$cate_post->cate_post_id)}}" class="active" ui-toggle-class="">
                  <i class="fa-solid fa-delete-left"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        {{-- Xuat nhap excel --}}
        <form action="{{url('import-csv')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <input type="file" name="file" accept=".xlsx"><br>
       <input type="submit" value="Import Excel" name="import_csv" class="btn btn-warning">
        </form>
       <form action="{{url('export-csv')}}" method="POST">
          @csrf
       <input type="submit" value="Export Excel" name="export_csv" class="btn btn-success">
      </form>

      </div>
      
    </div>
  </div>
@endsection