@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
    Liệt kê sản phẩm
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
              
              <th style="color: brown">Tên sản phẩm</th>
              <th style="color: brown">Số lượng</th>
              <th style="color: brown">Gía</th>
              <th style="color: brown">Hình ảnh sản phẩm</th>
              <th style="color: brown">Danh mục</th>
              <th style="color: brown">Thương hiệu</th>
              <th style="color: brown">Hiển thị</th>
              <th style="color: brown">Quản lý</th>

            </tr>
          </thead>
          <tbody>
            @foreach($all_product as $key =>$pr)
            <tr>
              <td>{{$pr->product_name}}</td>
              <td>{{$pr->product_quantity}}</td>
              <td>{{$pr->product_price}}</td>
              <td><img src ="public/uploads/product/{{$pr->product_image}}" height="100" width="100"></td>
              <td>{{$pr->category_name}}</td>
              <td>{{$pr->brand_name}}</td>
              <td><span class="text-ellipsis">
                <?php
                  if($pr->product_status==0){
                  ?>
                    
                    <a href="{{URL::to('/unactive-product/'.$pr->product_id)}}">
                      <i class="fa-thumb-styling fa-solid fa-thumbs-up"></i></a>
                    <?php
                  }else{
                   ?>
                    <a href="{{URL::to('/active-product/'.$pr->product_id)}}">
                      <i class="fa-thumb-styling fa-solid fa-thumbs-down"></i></a>
                    <?php
                  }

                ?>
              </span></td>
              
              <td>
                <a href="{{URL::to('/edit-product/'.$pr->product_id)}}" class="active" ui-toggle-class="">
                  <i class="fa-regular fa-pen-to-square"></i></a>
                <a onclick="return confirm('Bạn có muốn xóa sản phẩm này  ?')" href="{{URL::to('/delete-product/'.$pr->product_id)}}" class="active" ui-toggle-class="">
                  <i class="fa-solid fa-delete-left"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{-- Xuat nhap excel --}}
        <form action="{{url('import-csv-product')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <input type="file" name="file" accept=".xlsx"><br>
       <input type="submit" value="Import Excel" name="import_csv" class="btn btn-warning">
        </form>
       <form action="{{url('export-csv-product')}}" method="POST">
          @csrf
       <input type="submit" value="Export Excel" name="export_csv" class="btn btn-success">
      </form>
      </div>
      
    </div>
  </div>
@endsection