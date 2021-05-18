<!DOCTYPE html>
    <title> @yield('title') Theo dõi đơn hàng</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-theo-doi-dh.css')}}">
@extends('layout_master')

    @section('content')
        <div id="body-flow-dh">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="w-100" id="cap-flow-dh">
                            <span>Theo Dõi Đơn Hàng</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div  class="col-md-12">
                            <table class="table table-hover">
                                <tr style="text-align: center">
                                    <th>Hủy</th>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Số Lượng Sản Phẩm</th>
                                    <th>Tổng giá</th>
                                    <th>Thời Gian</th>
                                    <th>Trạng thái</th>
                                </tr>
                                <?php
                                foreach ($sub_dh_sl as $value =>$u_sl){
                                }
                                foreach ($sub_dh_tg as $value_2 =>$u_tg){

                                }


                                ?>

                                @foreach($don_hang as $item)
                                    @if($item->status == 'Giao Hành Thành Công' ||$item->status =='Đang Xử Lý' || $item->status =='Đang Giao Hàng')
                                    <form action="{{route('route_huy_dh')}}" method="post">
                                    @csrf()
                                    <tr>
                                        <td><button type="submit" onclick="return stop()">
                                                <i class="fa fa-times" aria-hidden="true">
                                                </i></button>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            {{$item->id}}
                                        </td>

                                        <td>{{number_format($u_sl[$item->id])}}</td>

                                        <td>{{number_format($u_tg[$item->id])}} đ</td>
                                        <td>{{$item->time}}</td>
                                        <td>
                                            @if($item->status =='Giao Hành Thành Công')
                                                <input type="hidden" name="status" value="{{$item->status}}">
                                                <span style="color: green">{{$item->status}}</span>
                                            @elseif($item->status =='Đang Xử Lý')
                                                <input type="hidden" name="status" value="{{$item->status}}">
                                                <span style="color: black">{{$item->status}}</span>
                                            @elseif($item->status =='Đang Giao Hàng')
                                                <input type="hidden" name="status" value="{{$item->status}}">
                                                <span style="color:#3b5998;">{{$item->status}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    </form>
                                    @endif
                                @endforeach
                            </table>
                    </div>
                    <div class="col-md-12">
                        <h5 id="note">*Lưu ý: <span>Đơn hàng chỉ được hủy trong trạng thái "Đang xử lý" !</span></h5>
                    </div>
                </div>
            </div>

        </div>
        <script>
            function stop() {
                return confirm("Bạn có muốn hủy đơn hàng này ?")
            }
            @if(Session::has('huy_tb'))
            alert("{{Session::get('huy_tb')}}")
            @endif
            @if(Session::has('huy_tc_tb'))
            alert("{{Session::get('huy_tc_tb')}}")
            @endif
        </script>
    @endsection





