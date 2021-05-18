<!DOCTYPE html>
<title> @yield('title')Chi Tiết Đơn Hàng</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/list-don-hang.css')}}">
@extends('layout_backend')

{{--Tên tiêu đề cho web--}}
@section('title', 'Chi tiết đơn hàng')
@section('content')
    <div id="body">
        @foreach($detail_oder as $val)
        @endforeach
        <div class="container" >
            <div class="row" >
                <div class="col-md-5">
                    <a href="{{route('route_quan_ly_dh_admin')}}" title="trở lại">
                        <button id="back"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
                    </a>
                    <span id="cap">Chi Tiết Đơn Hàng (Mã: {{$val->id_order}}) </span>
                </div>
            </div>


            <div class="row">
                <table class="table">
                    <tr class="table-success">
                        <th>Mã Giày</th>
                        <th>Ảnh-Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Size</th>
                        <th>Loại Hàng</th>
                        <th>Loại Giày</th>
                        <th>Đơn Giá</th>
                        <th>Tính Tiền</th>
                    </tr>

                    <?php

//                    echo'<pre>';
//                    print_r($tt_giay);
//                    echo'</pre>';
                    $tien = 0;
                    $tong_tien = 0;
                    ?>

                    @foreach($detail_oder as $val)
                    @foreach ($tt_giay as $sp_giay)
                        @if($sp_giay->id == $val->id_giay)
                        <tr>
                            <td>{{$val->id_giay}}</td>
                            <td>
                               @if($val->phan_loai_giay =='sản phẩm ký gửi')
                                    <img width="80" src="{{asset('/storage/'.$sp_giay->image)}}">
                                   <div>{{$sp_giay->name}}</div>
                               @endif
                               @if($val->phan_loai_giay =='sản phẩm new')
                                   <img width="80" src="{{asset('/storage/'.$sp_giay->image)}}">
                                   <div>{{$sp_giay->name}}</div>
                               @endif
                            </td>

                            <td>{{$val->quantity}}</td>
                            <td>{{$val->size}}</td>
                            <td>{{$val->loai_hang}}</td>
                            <td>{{$val->phan_loai_giay}}</td>
                            <td>{{number_format($val->price)}} đ</td>
                            <td>
                                <?php
                                $tien = $val->quantity * $val->price;
                                $tong_tien += $tien;
                                ?>
                                {{number_format($tien)}} đ
                            </td>
                        </tr>
                        @endif
                    @endforeach

                    @endforeach

                    <tr>
                        <td style="text-align: right;font-weight: bold;" colspan="8">
                            Tổng Tiền: <span style="color: #EB4924;">{{number_format($tong_tien)}} đ</span>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>

@endsection
