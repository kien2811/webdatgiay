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
                        <span class="box-title">Tất cả Sản Phẩm ({{count($toltal_sp)}})</span>
                    </div>

                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs">
                            <input type="text" class="form-control pull-left"
                                   id="search" name="search"  placeholder="tìm kiếm sản phẩm">
                            <div class="input-group-btn" style="width: 50px;padding-left: 10px;">
                                <select id="search" class="btn btn-default">
                                    <option>---Chọn Size---</option>
                                    <option value="1">Size - Name</option>
                                    <option value="2">Size - Nữ</option>
                                </select>
                                <select class="btn btn-default">
                                    <option>---Loại Hàng---</option>
                                    @foreach($loai_hang as $k)
                                        <option id="search" name="search" value="{{$k->loai_hang}}">{{$k->loai_hang}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group-btn" style="width: 50px;padding-left: 10px;">
                                <a href="{{route('route_add_giay')}}">
                                    <button class="btn btn-success" >
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        Thêm sản phẩm</button>
                                </a>

                                <a href="{{route('route_list_sale')}}">
                                    <button class="btn btn-danger" style="margin-left: 5px;">
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        Sự kiện</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-hover">
                        <tr class="table-success">
                            <th>Mã Giày</th>
                            <th>Ảnh Giày</th>
                            <th>Tên Giày</th>
                            <th>Giá</th>
                            <th>Size</th>
                            <th>Loại Hàng</th>
                            <th>Thương Hiệu</th>
                            <th>Giới Tính</th>
                            <th>Tài Khoản Đăng Bán</th>
                            <th>Xem mô tả</th>
                            <th>Chức Năng</th>
                        </tr>
                        @if(!empty($products))
                            <tbody>
                            </tbody>
                        @endif
                        @foreach($list as $sp)
                            <tr>
                                <td>
                                    {{$sp->id}}
                                </td>
                                <td>
                                    <img width="80" src="{{asset('/storage/'.$sp->image)}}">
                                </td>
                                <td>
                                    <a href="{{route('route_update_san_pham_admin')}}?id={{$sp->id}}">
                                        {{$sp->name}}
                                    </a>
                                </td>
                                <td>
                                    {{number_format($sp->price)}} đ
                                </td>
                                <td>
                                    <a href="{{route('route_update_size_san_pham_admin')}}?id={{$sp->id}}">
                                        @foreach($list_size[$sp->id] as $sz)
                                            {{$sz->size}}/
                                        @endforeach
                                    </a>

                                </td>
                                <td>
                                    {{$sp->loai_hang}}
                                </td>
                                <td>
                                    {{$sp->thuonghieu}}
                                </td>
                                <td>
                                    {{$sp->gender}}
                                </td>
                                <td>
                                    {{$sp->email}}
                                </td>
                                <td>
                                    <a href="{{route('route_chi_tiet')}}?id={{$sp->id}}" target="_blank" title="xem chi tiết">
                                        <button class="btn btn-warning" >Xem chi tiết</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('route_delete_san_pham_admin')}}?id={{$sp->id_mota}}" onclick="return stop()">
                                        <button class="btn btn-danger">Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $list->appends(['minid' => 6, 'maxid' => 10])->links() }}</ul>
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
                    url: '{{ URL::to('search-san-pham') }}',
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
    </div>
@endsection
{{--<pre>--}}
{{--@php(print_r($list))--}}
{{--</pre>--}}
