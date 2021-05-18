<title> @yield('title') Danh Sách Quyền cho Loại Tài Khoản</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/list-permission.css')}}">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@extends('layout_backend')

@section('content')
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-3" >
                        <span class="box-title">Phân Quyền Cho Loại Tài Khoản</span>
                    </div>
                    <form method="post" action="{{route('route_seach_role')}}">
                        @csrf

                        <div class="col-md-2">

                            <select name="id_role" class="form-control">
                                @if(isset($seach))
                                    @foreach($seach as $se)
                                        <option value="{{$se->id}}">{{$se->name}}</option>
                                    @endforeach
                                @endif
                                <option value="0">Danh Sách Tất Cả </option>
                                @foreach($list_role as $role)
                                    <option value="{{$role->id}}" >{{$role->name}}</option>
                                @endforeach
                            </select>
                            <div></div>
                        </div>
                        <div class="col-md-1">
                            <button type="submit">Seach</button>
                        </div>
                    </form>

                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs">
                            <div class="input-group-btn" style="width: 50px;padding-left: 10px;">
                                <a href="{{route('route_add_role_pms')}}">
                                    <button class="btn btn-success">
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        Thêm quyền truy cập</button>
                                </a>
                                <a href="{{route('route_AddRoleId')}}" title="Lọc">
                                    <button class="btn btn-danger" style="margin-left: 5px;">
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        Thêm vai trò truy cập trang</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-hover">
                        <tr class="table-success">
                            <th>Chức Năng</th>
                            <th>ID Nhóm Tài Khoản</th>
                            <th>ID Phân quyền</th>
                            <th>Tên phân quyền</th>

                        </tr>
                        @if(!empty($products))
                            @foreach ($products as $key => $product) {
                            <tbody>
                            <td>
                                <a href="{{route('route_delete_role_pms')}}?id={{$product->id}}" onclick="return stop()">
                                    <button id="delete">Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </a>
                            </td>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            @endforeach
                            @endif
                            @foreach($permission as $sp)
                                <tr>
                                    <td>
                                        <a href="{{route('route_delete_role_pms')}}?id={{$sp->id}}/{{$sp->role_id}}" onclick="return stop()">
                                            <button id="delete">Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td>{{$sp->role_id}}</td>
                                    <td>{{$sp->id}}</td>
                                    <td>{{$sp->name}}</td>
                                </tr>
                            @endforeach
                    </table>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $permission->appends(['minid' => 6, 'maxid' => 10])->links() }}</ul>
                    </div>
                </div>

            </div>
            <div>
                <ul style="color: red"><b>*</b>ID nhóm tài khoản:
                @foreach($list_role as $role)
                    <li style="list-style: none;">{{$role->id}}. {{$role->name}}</li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        @if(Session::has('succes'))
        alert("{{Session::get('succes')}}")
        @endif
        function stop() {
            return confirm('Bạn có muốn xóa không ???' )
        }
    </script>
@endsection
