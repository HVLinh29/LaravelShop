@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
       Liệt kê thương hiệu sản phẩm
      </div>
      
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
              
              <th style="color: brown">Tên thương hiệu</th>
              <th style="color: brown">Mô tả</th>
              <th style="color: brown">Hiển thị</th>
              <th style="color: brown">Quản lý</th>
            
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($all_brand_product as $key =>$br)
            <tr>
              <td>{{$br->brand_name}}</td>
              <td>{{$br->brand_desc}}</td>
              <td><span class="text-ellipsis">
                <?php
                  if($br->brand_status==0){
                  ?>
                    
                    <a href="{{URL::to('/unactive-brand-product/'.$br->brand_id)}}">
                      <i class="fa-thumb-styling fa-solid fa-thumbs-up"></i></a>
                    <?php
                  }else{
                   ?>
                    <a href="{{URL::to('/active-brand-product/'.$br->brand_id)}}">
                      <i class="fa-thumb-styling fa-solid fa-thumbs-down"></i></a>
                    <?php
                  }

                ?>
              </span></td>
              
              <td>
                <a href="{{URL::to('/edit-brand-product/'.$br->brand_id)}}" class="active" ui-toggle-class="">
                  <i class="fa-regular fa-pen-to-square"></i></a>
                <a onclick="return confirm('Bạn có muốn xóa thương hiệu này?')" href="{{URL::to('/delete-brand-product/'.$br->brand_id)}}" class="active" ui-toggle-class="">
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