<!DOCTYPE html>
    <title>Đăng Nhập</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-login.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@extends('layout_master')

<!-- phần body -->
    @section('content')

        <div id="body">
            <div class="container">
                <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h3><b>ĐĂNG NHẬP</b></h3><br>
                        <a class="fb" href=""><i class="fa fa-facebook" aria-hidden="true"></i> With Facebook</a>
                        <a class="gg" href=""><i class="fa fa-google-plus" aria-hidden="true"></i> With Google+</a><br><br>
                        <input placeholder="Email Đăng Nhập" id="email" type="email" class=" form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus><br>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <input placeholder="Mật Khẩu" id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <input type="submit" class="btn-submit" value="{{ __('Đăng Nhập') }}">
                        <br>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Quên Mật khẩu?') }}
                            </a><br>
                        @endif
                        Bạn chưa có tài khoản?<a href="{{ route('register') }}">{{ __('Đăng ký ngay') }}</a>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            @if(Session::has('yeu_cau_dn'))
            alert("{{Session::get('yeu_cau_dn')}}")
            @endif
        </script>
@endsection

