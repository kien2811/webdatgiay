<title> @yield('title')Thêm vai trò mới</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/show-add-user.css')}}">
@extends('layout_backend')

@extends('layout_backend')
@section('content')
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6">
                        <a href="{{route('route_list_role_pms')}}" title="trở lại">
                            <button class="btn btn-sm btn-primary" s><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
                        </a>
                        <span class="box-title">Thêm vai trò mới</span>
                    </div>
                </div>
                <form method="post" action="{{route('route_SaveRoleId')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6 col-md-offset-3">
                        <div class="">
                            <div class="box-header with-border">
                                <h3 class="box-title">Nhập vai trò mới</h3>
                            </div>
                            <div class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Vai trò</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" placeholder="Vai trò">
                                            @if($errors->has('name'))
                                                <div style="position: absolute;top:0px;left:50%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('name')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer" style="text-align: center">
                                    <input class="btn btn-success"  type="submit" name="" value="Thêm vai trò"><br>
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


