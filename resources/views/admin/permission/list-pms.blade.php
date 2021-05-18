<title> @yield('title') Danh Sách Quyền</title>
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
                        <span class="box-title">List Permission</span>
                    </div>
                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs">
                            <div class="input-group-btn" style="width: 50px;padding-left: 10px;">
                                <a href="{{route('route_import_permission')}}">
                                    <button class="btn btn-success">
                                        <i class="fa fa-repeat" aria-hidden="true"></i>
                                         Cập Nhật Thêm Quyền</button>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-hover">
                        <tr class="table-success">
                            <th>ID Permission</th>
                            <th>Name Permission</th>
                        </tr>
                        @foreach($list_permission as $ps)
                        <tr>
                            <td>{{$ps->id}}</td>
                            <td>{{$ps->name}}</td>
                        </tr>
                        @endforeach

                    </table>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $list_permission->appends(['minid' => 6, 'maxid' => 10])->links() }}</ul>
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
@endsection
