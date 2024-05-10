@extends('layout')
@section('content')

<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    @if (session()->has('message'))
    <div class="alert alert-success">
        {!! session()->get('message') !!}
    </div>
@elseif(session()->has('error'))
    <div class="alert alert-danger">
        {!! session()->get('error') !!}
    </div>
@endif

                    <h2>Đăng nhập tài khoản</h2>
                    <form action="{{URL::to('/login-customer')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="text" name="email_account" placeholder="Email" />
                        <input type="password" name="password_account" placeholder="Mật khẩu" />
                        <span>
                            <a href="{{URL::to('/quen-mk')}}">Quên mật khẩu</a>
                        </span>
                        <button type="submit" class="btn btn-success">Đăng nhập</button>
                    </form>
                    <style>
                        ul.list-login{
                            margin: 10px;
                            padding: 0;
                        }
                        ul.list-login li{
                            display: inline;
                            margin: 5px;
                        }
                    </style>
                    <ul class="list-login">
                        <li><a href="{{url('login-customer-gg')}}"><img width="10%" alt="Đăng nhập Google" src="{{asset('public/fontend/images/gg.png')}}"></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-1">
                <h2 class="btn btn-warning ">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Đăng ký</h2>
                    <form action="{{URL::to('/add-customer')}}" method="POST">
                        {{ csrf_field() }}
                        <input type="text" name="customer_name" placeholder="Họ và tên"/>
                        <input type="email" name="customer_email" placeholder="Email"/>
                        <input type="password" name="customer_password" placeholder="Mật khẩu"/>
                        <input type="text" name="customer_phone" placeholder="Số điện thoại"/>
                        <button type="submit" class="btn btn-danger ">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection