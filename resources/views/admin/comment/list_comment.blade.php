@extends('admin_layout')
@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê Comment
            </div>
            <div id="notify_comment"></div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                    ?>
                    <thead>
                        <tr>

                            <th style="color: brown">Duyệt</th>
                            <th style="color: brown">Tên người gửi</th>
                            <th style="color: brown">Bình luận</th>
                            <th style="color: brown">Ngày gửi</th>
                            <th style="color: brown">Sản phẩm</th>
                            <th style="color: brown">Quản lý</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comment as $key => $comm)
                            <tr>
                                <td>
                                    @if ($comm->comment_status == 1)
                                        <input type="button" data-comment_status="0"
                                            data-comment_id="{{ $comm->comment_id }}" id="{{ $comm->comment_product_id }}"
                                            class="btn btn-success btn xs comment_duyet" value="Duyet">
                                    @else
                                        <input type="button" data-comment_status="1"
                                            data-comment_id="{{ $comm->comment_id }}" id="{{ $comm->comment_product_id }}"
                                            class="btn btn-danger btn xs comment_duyet" value=" Bo Duyet">
                                    @endif
                                </td>

                                <td>{{ $comm->comment_name }}</td>
                                <td>{{ $comm->comment }}
                                    <style type="text/css">
                                        ul.list_rep li {
                                            list-style-type: decimal;
                                            color: brown;
                                            margin: 5px 40px;
                                        }
                                    </style>
                                    <ul class="list_rep">
                                        Tra loi:
                                        @foreach ($comment_rep as $key => $comm_reply)
                                            @if ($comm_reply->comment_parent_comment == $comm->comment_id)
                                                <li>{{ $comm_reply->comment }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @if ($comm->comment_status == 0)
                                        <br />
                                        <textarea class="form-control reply_comment_{{ $comm->comment_id }}" row="5"></textarea>
                                        <br /><button class="btn btn-default btn-xs btn-reply-comment"
                                            data-product_id="{{ $comm->comment_product_id }}"
                                            data-comment_id="{{ $comm->comment_id }}">Trả lời</textarea>
                                    @endif

                                </td>
                                <td>{{ $comm->comment_date }}</td>
                                <td><a href="{{ url('/chi-tiet-san-pham/' . $comm->product->product_slug) }}"
                                        target="_blank">{{ $comm->product->product_name }}</td>

                                <td>
                                    
                                    <a onclick="return confirm('Bạn có muốn xóa binh luan này  ?')" href="{{URL::to('/delete-comment/'.$comm->comment_id)}}"
                                        class="active btn btn-danger" ui-toggle-class="">Xóa
                                       </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Xuat nhap excel --}}
                <form action="{{ url('import-csv-product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xlsx"><br>
                    <input type="submit" value="Import Excel" name="import_csv" class="btn btn-warning">
                </form>
            </br>
                <form action="{{ url('export-csv-product') }}" method="POST">
                    @csrf
                    <input type="submit" value="Export Excel" name="export_csv" class="btn btn-success">
                </form>
            </div>

        </div>
    </div>
@endsection
