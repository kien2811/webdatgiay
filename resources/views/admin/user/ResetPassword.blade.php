<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đăng Ký</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-dang-ky-acc.css')}}">
</head>
<body>
<div>
@extends('layout_master')

<!-- phần body -->
    @section('content')

        <div id="body">
            <div class="container">
                <div class="col-md-12">
                    <form method="post" action="{{route('route_save_new_user')}}">
                        <table>
                            @csrf()
                            <h3><b>Lấy Lại Mật Khẩu</b></h3>

                            @if(Session::has('msg'))
                                <p style="color: green;">{{Session::get('msg')}}</p>
                            @endif
                            <input type="text" name="email" placeholder="Nhập email của tài khoản"><br>
                            @if(!empty($errors->has('email')))
                                <p style="color:red">{{$errors->first('email')}}</p>
                            @endif
                            <input type="button" value="Lấy Mật Khẩu">

                        </table>
                    </form>
                </div>
            </div>
        </div>

</div>
@endsection
</div>
</body>
</html>
<pre>
@php

        @endphp
</pre>

