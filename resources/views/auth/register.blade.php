<!DOCTYPE html>
    <meta charset="utf-8">
    <title>Đăng Ký</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-dang-ky-acc.css')}}">
@extends('layout_master')

<!-- phần body -->
    @section('content')

        <div id="body">
            <div class="container">
                <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf<h3><b>ĐĂNG KÝ TÀI KHOẢN MIỄN PHÍ</b></h3><br>

                        <input placeholder="Họ Và Tên" id="name" type="text" class=" form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus><br>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

                        <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email"><br>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <input placeholder="Password" id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="new-password"><br>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                                <input placeholder="Nhập Lại Mật khẩu" id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                                <input type="submit" class="btn-submit" value="{{ __('Đăng Ký') }}"><br><br>
                        <a class="fb" href=""><i class="fa fa-facebook" aria-hidden="true"></i> With Facebook</a>
                        <a class="gg" href=""><i class="fa fa-google-plus" aria-hidden="true"></i> With
                            Google+</a><br><br>
                        Bằng các đăng ký, bạc xác nhận bằng cách chấp nhận<br>
                        <a href="">Các điều khoản và điều kiện</a> và <a href="">Chính sách bảo mật</a><br><br>
                    </form>
                </div>
                </div>
            </div>
        </div>
@endsection

