<title> @yield('title') Danh Sách Sản Phẩm</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/list-san-pham.css')}}">

@extends('layout_backend')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@section('content')
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6" >
                        <span class="box-title">Danh Sách Tài Khoản Đã Đăng Ký ({{count($list_member)}})</span>
                    </div>

                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs">
                            <input type="text" class="form-control pull-left"
                                   id="search" name="search"  placeholder="tìm kiếm sản phẩm">
                            <div class="input-group-btn" style="width: 50px;padding-left: 10px;">
                                <a href="{{route('route_show_add_user')}}">
                                    <button class="btn btn-success">
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        Thêm tài khoản</button>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-hover">
                        <tr class="table-success">
                            <th>Chức Năng</th>
                            <th>Vai trò quy cập</th>
                            <th>Mã ID</th>
                            <th>Username</th>
                            <th>Email</th>
                        </tr>
                        @if(!empty($products))
                            <tbody>
                            </tbody>
                        @endif
                        @foreach($list_member as $sp)
                            <tr>
                                <td>
                                    <a href="{{route('route_delete_user')}}?id={{$sp->id}}" onclick="return stop()">
                                        <button class="btn btn-danger" >Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                @foreach($role_id as $role)
                                    @if($role->id == $sp->role_id)
                                        <a href="{{route('route_UpdateRoleUser')}}?id={{$sp->id}}">{{$role->name}}</a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    {{$sp->id}}
                                </td>
                                <td>
                                    {{$sp->name}}
                                </td>
                                <td>
                                    {{$sp->email}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $list_member->appends(['minid' => 6, 'maxid' => 10])->links() }}</ul>
                    </div>
                </div>
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
    <script type="text/javascript">
        $('#search').on('keyup',function(){
            $value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('search-user') }}',
                data: {
                    'search': $value
                },
                success:function(data){
                    $('tbody').html(data);
                }
            });
        })
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>
@endsection

