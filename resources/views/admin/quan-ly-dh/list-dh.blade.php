<!DOCTYPE html>
<title> @yield('title')Quản Lý Đơn Hàng</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/list-don-hang.css')}}">
@extends('layout_backend')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@section('content')

    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6" >
                        @if($view == "danh-sach")
                            <span class="box-title">Danh Sách Đơn Hàng ({{count($total_dh)}})</span>
                        @elseif($view == "danh-sach-chua-xl")
                            <span class="box-title">Danh Sách Đơn Hàng Chưa Xử Lý ({{count($total_dh)}})</span>
                        @elseif($view == "danh-sach-da-xl")
                            <span class="box-title">Danh Sách Đơn Hàng Đã Xử Lý ({{count($total_dh)}})</span>
                        @endif
                    </div>



                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs">
                            <input class="form-control" id="myInput" type="text" placeholder="tìm kiếm đơn hàng..">
                            <div class="input-group-btn" style="width: 50px;padding-left: 10px;">

                                <a href="{{route('route_quan_ly_dh_admin_da_xl')}}" title="Lọc">
                                    <button class="btn btn-success" >
                                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        Đơn hàng đã xử lý</button>
                                </a>
                                <a href="{{route('route_quan_ly_dh_admin_chua_xl')}}" title="Lọc">
                                    <button class="btn btn-danger" style="margin-left: 5px;">
                                        <i class="fa fa-search-minus" aria-hidden="true"></i>
                                        Đơn hàng chưa xử lý</button>
                                </a>
                                <a href="{{route('route_quan_ly_dh_admin')}}" title="Tải Lại">
                                    <button class="btn btn-info" style="margin-left: 5px;">
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-bordered">
                        <tr class="table-success">
                            <th>Mã Đơn Hàng</th>
                            <th>Họ Tên Khách Hàng</th>
                            <th>Số Điện Thoại</th>
                            <th>Địa Chỉ</th>
                            <th>Thời Gian đặt Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái Đơn Hàng</th>
                        </tr>
                        @foreach($list_dh as $dh)
                            <form action="{{route('route_quan_ly_dh_update_admin')}}" method="post">
                                @csrf()
                                <tbody id="myTable">
                                    <td title="xem chi tiết đơn hàng">
                                        <input type="hidden" name="id_oder" value="{{$dh->id}}">
                                        <a style="color: red;font-weight: bold;" href="{{route('route_quan_ly_dh_chi_tiet_admin')}}?id={{$dh->id}}">
                                            {{$dh->id}}</a>
                                    </td>
                                    <td>{{$dh->fullname}}</td>
                                    <td>{{$dh->phone}}</td>
                                    <td>{{$dh->address}}</td>
                                    <td>{{$dh->time}}</td>
                                    <td>{{$dh->time}}</td>
                                    <td style="padding: 20px;">
                                        <select name="id_status">
                                            <option value="{{$dh->id_status}}">{{$dh->status}}</option>
                                            @foreach($list_status as $stt)
                                                <option value="{{$stt->id}}" >{{$stt->status}}</option>
                                            @endforeach
                                        </select>
                                        <button id="but-save" type="submit" title="Lưu"><i class="fa fa-cogs" aria-hidden="true"></i></button>
                                    </td>
                                </tbody>
                            </form>
                        @endforeach

                    </table>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $list_dh->appends(['minid' => 6, 'maxid' => 10])->links()}}</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script type="text/javascript">
    @if(Session::has('succes_update'))
    alert("{{Session::get('succes_update')}}")
    @endif
</script>
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
</body>
</html>
{{--@php--}}
        {{--echo '<pre>';--}}
        {{--print_r($list_dh);--}}
        {{--echo '</pre>';--}}
        {{--@endphp--}}
