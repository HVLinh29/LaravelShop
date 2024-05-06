@extends('admin_layout')
@section('admin_content')
    <div class="container-fluid">
        <style type="text/css">
            p.title_thongke {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
            }
        </style>
    </div>
    <div class="row">
        <p class="title_thongke">Thống kê đơn hàng, doanh số</p>
        <form autocomplete="off">
            @csrf
            <div class="col-md-2">
                <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
                <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quá"></p>
            </div>
            <div class="col-md-2">
                <p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
            </div>
            <div class="col-md-2">
                <p>
                    Loc theo:
                    <select class="dashboard-filter form-control">
                        <option>--Chon--</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">Tháng truóc</option>
                        <option value="thangnay">Thāng này</option>
                        <option value="365ngayqua">365 ngày qua</option>
                    </select>
                </p>
                <script type="text/javascript">
                    $(document).ready(function() {

                        chart60daysorder();

                        var chart = new Morris.Bar({
                            element: 'chart',
                            lineColors: ['#819C79', '#fc8710', '#FF6541', '#A4ADD3', '#766856'],
                            parseTime: false,
                            hideHover: 'auto',
                            xkey: 'period',
                            ykeys: ['order', 'sales', 'profit', 'quantity'],
                            labels: ['đơn hàng', 'doanh số',
                                'lợi nhuận', 'số lượng'
                            ]
                        });

                        function chart60daysorder() {
                            var _token = $('input[name="_token"]').val();
                            $.ajax({
                                url: '{{ url('/days-order') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {
                                    _token: _token

                                },
                                success: function(data) {
                                    chart.setData(data);
                                }
                            });
                        }

                        $('.dashboard-filter').change(function() {
                            var dashboard_value = $(this).val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: '{{ url('/dashboard-filter') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {
                                    _token: _token,
                                    dashboard_value: dashboard_value

                                },
                                success: function(data) {
                                    chart.setData(data);
                                }
                            });
                        });

                        $('#btn-dashboard-filter').click(function() {
                            var _token = $('input[name="_token"]').val();
                            var from_date = $('#datepicker').val();
                            var to_date = $('#datepicker2').val();

                            $.ajax({
                                url: '{{ url('/filter-by-date') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {
                                    _token: _token,
                                    from_date: from_date,
                                    to_date: to_date
                                },
                                success: function(data) {
                                    chart.setData(data);
                                }
                            });
                        });
                    });
                </script>
                

            </div>
        </form>
        <div class="col-md-12">
            <div id="chart" style="height:250px;"></div>
        </div>
    </div>
    <div class="row">
        <style>
            table.table.table-bordered.table-dark {
                background: brown;
            }

            table.table.table-bordered.table-dark tr th {
                color: #fff;
            }
        </style>
        <p class="title_thongke">Thống kê truy cập</p>
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th scope="col">Đang Online</th>
                    <th scope="col">Tổng tháng trước</th>
                    <th scope="col">Tổng tháng này</th>
                    <th scope="col">Tổng một năm</th>
                    <th scope="col">Tổng truy cập</th>
                </tr>
            </thead>
            <tbody>
                <td>{{ $visitor_count }}</td>
                <td>{{ $visitor_last_month_count }}</td>
                <td>{{ $visitor_this_month_count }}</td>
                <td>{{ $visitor_year_count }}</td>
                <td>{{ $visitors_total }}</td>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <p class="title_thongke">Thống kê tổng sản phẩm bài viết đơn hàng</p>
            <div id="donut" class="morris-donut-inverse"></div>
        </div>
        <div class="col-md-4 col-xs-12">
            <h3>Bài viết xem nhiều</h3>
            <ol class="list_views">
                @foreach ($post_view as $key => $post)
                <li>
                    <a target="_blank" href="{{url('/bai-viet/'.$post->post_slug)}}">{{$post->post_title}} | <span style="color:black">{{$post->post_view}}</span> </a>
                </li>
                @endforeach
            </ol>
        </div>
        <div class="col-md-4 col-xs-12">
            <style>
                ul.list_views{
                    margin: 10px 0;
                    color: #fff;
                }
                ul.list_views a{
                    color: orange;
                    font-weight: 400;
                }
            </style>
            <h3>Sản phẩm xem nhiều</h3>
            <ol class="list_views">
                @foreach ($product_view as $key => $product)
                <li>
                    <a target="_blank" href="{{url('/chi-tiet-san-pham/'.$product->product_slug)}}">{{$product->product_name}} | <span style="color:black">{{$product->product_view}}</span> </a>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection
