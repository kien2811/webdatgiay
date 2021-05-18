<title> @yield('title')Thêm Tài Khoản</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/show-add-user.css')}}">
@extends('layout_backend')

@extends('layout_backend')
@section('content')
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6">
                        <a href="{{route('route_list_user')}}" title="trở lại">
                            <button class="btn btn-sm btn-primary" s><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
                        </a>
                        <span class="box-title">Thêm Tài Khoản Mới</span>
                    </div>
                </div>
                <form method="post" action="{{route('route_add_user_admin')}}" enctype="multipart/form-data">                    @csrf
                    <div class="col-md-6 col-md-offset-3">
                        <div class="">
                            <div class="box-header with-border">
                                <h3 class="box-title">Nhập Thông Tin Giày</h3>
                            </div>
                            <div class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Họ và Tên</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" placeholder="Họ Và Tên">
                                            @if($errors->has('name'))
                                                <div style="position: absolute;top:0px;left:50%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('name')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="email" name="email" placeholder="Email">
                                            @if($errors->has('email'))
                                                <div style="position: absolute; top:0px;left: 50%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('email')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Mật Khẩu</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="password" name="password" placeholder="password">
                                            @if($errors->has('password'))
                                                <div style="position: absolute; top:0px;left: 50%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('password')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nhập Mật Khẩu</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="password" name="password_confirmation" placeholder="password_confirmation">
                                            @if($errors->has('password_confirmation'))
                                                <div style="position: absolute; top:0px;left: 50%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('password_confirmation')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Chức Vụ</label>
                                        <div class="col-sm-9">
                                            <select name="id_role" class="form-control">
                                                <option>-Chọn Vai trò-</option>
                                                @foreach($role_id as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('id_role'))
                                                <div style="position: absolute; top:0px;left: 50%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('id_role')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <input class="btn btn-success"  type="submit" name="" value="Thêm tài Khoản"><br>
{{--                                    class="btn-submit"--}}
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


