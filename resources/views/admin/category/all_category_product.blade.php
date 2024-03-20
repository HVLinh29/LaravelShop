@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <header class="panel-heading">
      Liệt kê danh mục sản phẩm
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
              <th style="color:brown">Tên danh mục</th>
              <th style="color:brown">Hiển thị</th>
              <th style="color:brown">Quản lý</th>
            
            </tr>
          </thead>
          <tbody>
            @foreach($all_category_product as $key =>$cate_pro)
            <tr>
              <td>{{$cate_pro->category_name}}</td>
              <td><span class="text-ellipsis">
                <?php
                  if($cate_pro->category_status==0){
                  ?>
                    
                    <a href="{{URL::to('/unactive-category-product/'.$cate_pro->category_id)}}">
                      <i class="fa-thumb-styling fa-solid fa-thumbs-up"></i></a>
                    <?php
                  }else{
                   ?>
                    <a href="{{URL::to('/active-category-product/'.$cate_pro->category_id)}}">
                      <i class="fa-thumb-styling fa-solid fa-thumbs-down"></i></a>
                    <?php
                  }

                ?>
              </span></td>
              
              <td>
                <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active" ui-toggle-class="">
                  <i class="fa-regular fa-pen-to-square"></i></a>
                <a onclick="return confirm('Bạn có muốn xóa danh mục này?')" href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" class="active" ui-toggle-class="">
                  <i class="fa-solid fa-delete-left"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection