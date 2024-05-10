<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet">
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

   
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 100px; /* Add some space from the top */
        }
        .log-w3 {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px #0000001f;
            max-width: 400px;
            margin: 0 auto; /* Center the form */
            padding: 40px;
        }
        .log-w3 h2 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        .log-w3 form input[type="text"],
        .log-w3 form input[type="password"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 1px solid #ddd;
            background: transparent;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            outline: none;
        }
        .log-w3 form input[type="text"]:focus,
        .log-w3 form input[type="password"]:focus {
            border-bottom: 1px solid #007bff;
        }
        .log-w3 form input[type="submit"] {
            background: #007bff;
            color: #fff;
            padding: 15px 0;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .log-w3 form input[type="submit"]:hover {
            background: #0056b3;
        }
        .log-w3 .form-group {
            margin-bottom: 20px;
        }
        .log-w3 .divider {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .log-w3 .divider hr {
            border: none;
            background: #ddd;
            height: 1px;
            width: 30%;
            display: inline-block;
            margin: 0;
        }
        .log-w3 .divider p {
            color: #888;
            margin: 0 10px;
            display: inline-block;
        }
        .log-w3 .social-login {
            text-align: center;
            margin-bottom: 20px;
        }
        .log-w3 .social-login a {
            color: #fff;
            display: inline-block;
            width: 100%;
            padding: 15px 0;
            border-radius: 25px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        .log-w3 .social-login a:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="log-w3">
            <h2>ĐĂNG NHẬP ADMIN</h2>
            <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
            }
            ?>
            <form action="{{URL::to('/admin-dashboard')}}" method="post">
                {{csrf_field()}}
                @foreach($errors->all() as $val)
                    <ul>
                        <li>{{$val}}</li>
                    </ul>
                @endforeach
                <div class="form-group">
                    <input type="text" class="form-control" name="admin_email" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="admin_password" placeholder="Mật khẩu" required="">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="ĐĂNG NHẬP">
                </div>
                <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                <br/>
                @if($errors->has('g-recaptcha-response'))
                    <span class="invalid-feedback" style="display:block">
                            <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                        </span>
                @endif
            </form>
            <div class="divider">
                <hr>
                <p>Hoặc đăng nhập bằng</p>
                <hr>
            </div>
            <div class="social-login">
                <a href="{{url('/login-google')}}" class="btn btn-info btn-block"><i class="fa fa-google"></i> Google</a>
            </div>
            <div class="other-options">
                <a href="{{url('/register-auth')}}" class="btn btn-success btn-block"><i class="fa fa-user-plus"></i> Đăng kí phân quyền</a>
                <a href="{{url('/login-auth')}}" class="btn btn-secondary btn-block"><i class="fa fa-sign-in"></i> Đăng nhập Auth</a>
            </div>
        </div>
    </div>
    
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
