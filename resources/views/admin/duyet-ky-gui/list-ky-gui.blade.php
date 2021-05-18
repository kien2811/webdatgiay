<!DOCTYPE html>
<title> @yield('title') Danh Sách Giày Ký Gửi</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/list-ky-gui.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@extends('layout_backend')
@section('content')
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6" >
                        @if($view == 'all')
                            <span class="box-title">Tất cả Sản Phẩm ({{count($total_kg)}})</span>
                        @elseif($view == 'Chưa Xử Lý')
                            <span class="box-title">Sản Phẩm Chưa Xử Lý ({{count($total_kg)}})</span>
                        @elseif($view == 'Nhận Hàng')
                            <span class="box-title">Sản Phẩm Đã Nhận ({{count($total_kg)}})</span>
                        @endif
                    </div>

                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs">
                            <input class="form-control" id="myInput" type="text" placeholder="tìm kiếm..">
                            <div class="input-group-btn" style="width: 50px;padding-left: 10px;">
                                <a href="{{route('route_list_ky_gui_da_nhan')}}" title="lọc">
                                    <button class="btn btn-success" >
                                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        Đã Nhận Hàng</button>
                                </a>
                                <a href="{{route('route_list_ky_gui_chua_xl')}}" title="lọc">
                                    <button class="btn btn-danger" style="margin-left: 5px;">
                                        <i class="fa fa-search-minus" aria-hidden="true"></i>
                                        Chưa Xử Lý</button>
                                </a>
                                <a href="{{route('route_list_ky_gui')}}" title="Tải Lại">
                                    <button class="btn btn-info" style="margin-left: 5px;">
                                        <i class="fa fa-repeat" aria-hidden="true"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="box-body">
                    <table class="table table-hover">
                        <tr class="table-success">
                            <th>Mã Giày</th>
                            <th>Ảnh - Tên</th>
                            <th>Size</th>
                            <th>Số Lượng</th>
                            <th>Giá Gửi</th>
                            <th>Loại Hàng</th>
                            <th>Đã Sử Dụng</th>
                            <th>SĐT</th>
                            <th>Họ Tên Khách Gửi</th>
                            <th>Thời Gian Gửi</th>
                            <th>Trạng Thái</th>
                            <th>Chức Năng</th>
                        </tr>
                        @foreach($list_ky_gui as $item)
                            <tbody id="myTable">
                                <td>{{$item->id}}</td>
                                <td>
                                    <img width="80px" src="{{asset('/storage/'.$item->image)}}">
                                    <div><span>{{$item->name}}</span></div>
                                </td>
                                <td>{{$item->size}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{number_format($item->price)}} đ</td>
                                <td>{{$item->loai_hang}}</td>
                                <td>{{$item->time_da_sd}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->fullname}}</td>
                                <td style="width: 100px;">{{$item->time}}</td>
                                <td>
                                    @if($item->status == "Đang Xử Lý")
                                        <span id="stt-01">{{ $item->status}}</span>
                                    @elseif($item->status == "Nhận Hàng")
                                        <span id="stt-02">{{ $item->status}}</span>
                                    @endif
                                </td>
                                <td>

                                    <a href="{{route('route_delete_ky_gui').'?id='.$item->id.'/'.$item->size}}">
                                        <button id="dis-like" onclick="return stop()">
                                            Từ Chối <i class="fa fa-ban" aria-hidden="true"></i>
                                        </button>
                                    </a>

                                    <a style=" text-decoration: none;" href="{{route('route_update_ky_gui').'?id='.$item->id.'/'.$item->size}}">
                                        <button id="like">
                                            Nhận <i class="fa fa-share-square-o" aria-hidden="true"></i>
                                        </button>
                                    </a>

                                </td>
                            </tbody>
                        @endforeach
                    </table>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $list_ky_gui->appends(['minid' => 6, 'maxid' => 10])->links() }}</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if(Session::has('succes'))
        alert("{{Session::get('succes')}}")
        @endif

        @if(Session::has('loi_tt'))
        alert("{{Session::get('loi_tt')}}")
        @endif

        function stop() {
            return confirm("Bạn có muốn xóa sản phẩm này ?")
        }
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
@endsection
