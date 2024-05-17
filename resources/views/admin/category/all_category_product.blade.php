@extends('admin_layout')
@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <div class="table-agile-info">
        <div class="panel panel-default">
            <header class="panel-heading">
                Liệt kê danh mục sản phẩm
            </header>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <style>
                        .custom-button {
                            background-color: brown;
                            color: white;
                            padding: 10px 20px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 5px 2px;
                            cursor: pointer;
                            border: none;
                            border-radius: 4px;
                        }
                    </style>
                    <a href="{{ URL::to('/add-category-product') }}" class="custom-button" >Thêm danh mục</a>
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                    ?>
                    <thead>
                        <tr>
                            <th style="color:brown">Tên danh mục</th>
                            <th style="color:brown">Slug</th>
                            <th style="color:brown">Thuộc danh muc</th>
                            <th style="color:brown">Hiển thị</th>
                            <th style="color:brown">Quản lý</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_category_product as $key => $cate_pro)
                            <tr>
                                <td>{{ $cate_pro->category_name }}</td>
                                <td>{{ $cate_pro->category_slug }}</td>
                                <td>
                                    @if ($cate_pro->category_parent == 0)
                                        <span style="color:red">Danh muc cha</span>
                                    @else
                                        @foreach ($category_product as $key => $cate_sub_pro)
                                            @if ($cate_sub_pro->category_id == $cate_pro->category_parent)
                                                <span style="color:black">{{ $cate_sub_pro->category_name }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td><span class="text-ellipsis">
                                        <?php
                  if($cate_pro->category_status==0){
                  ?>

                                        <a href="{{ URL::to('/unactive-category-product/' . $cate_pro->category_id) }}">
                                            <i class="fa-thumb-styling fa-solid fa-thumbs-up"></i></a>
                                        <?php
                  }else{
                   ?>
                                        <a href="{{ URL::to('/active-category-product/' . $cate_pro->category_id) }}">
                                            <i class="fa-thumb-styling fa-solid fa-thumbs-down"></i></a>
                                        <?php
                  }

                ?>
                                    </span></td>

                                <td>
                                    <a href="{{ URL::to('/edit-category-product/' . $cate_pro->category_id) }}"
                                        class="active btn btn-success" ui-toggle-class="">
                                        Sửa</a>
                                    <a onclick="return confirm('Bạn có muốn xóa danh mục này?')"
                                        href="{{ URL::to('/delete-category-product/' . $cate_pro->category_id) }}"
                                        class="active btn btn-danger" ui-toggle-class="">
                                        Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Xuat nhap excel --}}
                </br>
                <form action="{{ url('import-csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xlsx"><br>
                    <input type="submit" value="Import Excel" name="import_csv" class="btn btn-danger">
                </form>
                </br>
                <form action="{{ url('export-csv') }}" method="POST">
                    @csrf
                    <input type="submit" value="Export Excel" name="export_csv" class="btn btn-success">
                </form>

            </div>

        </div>
    </div>
@endsection
