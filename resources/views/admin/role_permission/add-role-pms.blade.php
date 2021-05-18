<title> @yield('title')Thêm quyền cho loại tài khoản</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/add-permission.css')}}">
@extends('layout_backend')
@section('content')
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6">
                        <a href="{{route('route_list_role_pms')}}" title="trở lại">
                            <button class="btn btn-sm btn-primary" s>
                                <i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
                        </a>
                        <span class="box-title">Thêm Quyền Nhóm Tài Khoản</span>
                    </div>
                </div>
                <form action="{{route('route_add_save_role_pms')}}" method="post">
                    @csrf
                    <div class="col-md-6 col-md-offset-3">
                        <div class="">
                            <div class="box-header with-border">
                                <h3 class="box-title">Nhập Dữ Liệu Quyền Truy Cập</h3>
                            </div>
                            <div class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Nhóm Tài Khoản</label>
                                        <div class="col-sm-8">
                                            <select name="role_id" class="form-control">
                                                @foreach($list_role as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tên Quyền</label>
                                        <div class="col-sm-8">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Chọn quyền
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    @foreach($permission as $per)
                                                        <div style="width: 250px;padding-left: 20%;">
                                                            <span>
                                                                <input type="checkbox" name="pms_{{$per->id}}" value="{{$per->id}}" >
                                                                {{$per->name}}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-footer" style="text-align: center">
                                        <input class="btn btn-success"  type="submit" name="" value="Thêm Quyền"><br>
                                        {{--                                    class="btn-submit"--}}
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <script type="text/javascript">
        @if(Session::has('succes'))
        alert("{{Session::get('succes')}}")
        @endif
    </script>

@endsection
{{--<pre>--}}
{{--@php(print_r($list_role))--}}
{{--</pre>--}}
