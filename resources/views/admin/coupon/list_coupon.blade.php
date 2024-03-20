@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
       Liệt kê mã giảm giá
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
            
              <th style="color: brown">Tên mã giảm giá</th>
              <th style="color: brown">Mã giảm giá</th>
              <th style="color: brown">Số lượng mã</th>
              <th style="color: brown">Diều kiện giảm giá</th>
              <th style="color: brown">Số lượng</th>
              <th style="color: brown">Quản lý</th>
            
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($coupon as $key =>$cou)
            <tr>
              
              <td>{{$cou->coupon_name}}</td>
              <td>{{$cou->coupon_code}}</td>
              <td>{{$cou->coupon_time}}</td>
              <td><span class="text-ellipsis">
                <?php
                  if($cou->coupon_condition==1){
                  ?>
                   Giảm theo %
                <?php
                  }else{
                   ?>
                    Giảm theo tiền
                    <?php
                  }

                ?>
              </span>
            </td>
            <td><span class="text-ellipsis">
                <?php
                  if($cou->coupon_condition==1){
                  ?>
                    Giảm {{$cou->coupon_number}} %
                <?php
                  }else{
                   ?>
                    Giảm {{$cou->coupon_number}} k
                    <?php
                  }

                ?>
              </span></td>
              
              <td>
                
                <a onclick="return confirm('Bạn có muốn xóa mã giảm giá này?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active" ui-toggle-class="">
                  <i class="fa-solid fa-delete-left"></i></a></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection