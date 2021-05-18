<?php
$cont = Cart::content();
$total = 0;
//echo '<pre>';
//print_r($cont);
//echo '</pre>';
?>
<!DOCTYPE html>
<title> @yield('title') Khách Hàng nhập thông tin</title>

    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-thanh-toan.css')}}">
@extends('layout_master')

<!-- phần body -->
    @section('content')
        <div id="body-pay">
            <div class="container">
                <div class="row">
                    <div class="col-md-2" id="cap-pay">
                        <h5>
                           <span>Thanh Toán</span>
                        </h5>
                    </div>
                </div>
                <form action="{{route('route_check_oder')}}" method="post">
                <div class="row">
                    <div class="col-12 col-md-8" id="information-pay">
                        <h5>Thông tin giao hàng :</h5>
                        <div id="input-pay" style="position: relative;">
                            <label class="col-md-3">Họ và Tên:</label>
                            <input class="col-md-7" type="type" name="full_name" value="{{Auth::user()->name}}" >
                            @if($errors->has('full_name'))
                                <div style="position: absolute;top:0px;left:60%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                    <span style="color:white;font-size: 13px;">{{$errors->first('full_name')}}</span>
                                </div>
                            @endif
                        </div>
                        <div id="input-pay" style="position: relative;">
                            <label class="col-md-3">Số Điện Thoại:</label>
                            <input class="col-md-7" type="type" name="phone" placeholder="VD: 03033333333">
                            @if($errors->has('phone'))
                                <div style="position: absolute;top:0px;left:60%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                    <span style="color:white;font-size: 13px;">{{$errors->first('phone')}}</span>
                                </div>
                            @endif

                        </div>
                        <div id="input-pay" style="position: relative;">
                            <label class="col-md-3">Email:</label>
                            <input class="col-md-7" type="type" name="email" value="{{Auth::user()->email}}" >
                            @if($errors->has('email'))
                                <div style="position: absolute;top:0px;left:60%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                    <span style="color:white;font-size: 13px;">{{$errors->first('email')}}</span>
                                </div>
                            @endif
                        </div>

                        <div id="input-pay" style="position: relative;">
                            <label class="col-md-3">Tỉnh / Thành Phố:</label>
                            <input class="col-md-7" type="type" name="Tinh_TP" placeholder="nhập tên Tỉnh / Thành">
                            @if($errors->has('Tinh_TP'))
                                <div style="position: absolute;top:0px;left:60%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                    <span style="color:white;font-size: 13px;">{{$errors->first('Tinh_TP')}}</span>
                                </div>
                            @endif
                        </div>
                        <div id="input-pay" style="position: relative;">
                            <label class="col-md-3">Quận / Huyện:</label>
                            <input class="col-md-7" type="type" name="Quan_huyen" placeholder="nhập Quận / Huyện">
                            @if($errors->has('Quan_huyen'))
                                <div style="position: absolute;top:0px;left:60%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                    <span style="color:white;font-size: 13px;">{{$errors->first('Quan_huyen')}}</span>
                                </div>
                            @endif
                        </div>

                        <div id="input-pay" style="position: relative;">
                            <label class="col-md-3">Địa chỉ nhận hàng:</label>
                            <input class="col-md-7" type="type" name="Dia_chi" placeholder="địa chỉ chi tiết">
                            @if($errors->has('Dia_chi'))
                                <div style="position: absolute;top:0px;left:60%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                    <span style="color:white;font-size: 13px;">{{$errors->first('Dia_chi')}}</span>
                                </div>
                            @endif
                        </div>

                        <div id="input-pay">
                            <label id="mess-pay" class="col-md-3">Lời nhắn:</label>
                            <textarea class="col-md-7" name="mess" placeholder="lời nhắn" maxlength="200"></textarea>
                        </div>

                        <div id="input-pay" >
                            <label class="col-md-3">Than toán bằng:</label>
                            <span id="pay-bank"><input  type="checkbox"  name="">Thanh toán bằng thẻ ngân hàng </span>
                            <span id="pay-after"><input  type="checkbox" name="">Thanh toán sau khi nhận hàng</span>
                        </div>
                    </div>

                    <div class="col-md-4" >
                        <div id="list-cart">
                            <h5>Đơn Hàng<span>({{Cart::count()}} sản phẩm)</span></h5>
                            @foreach($cont as $item)
                                <a style="text-decoration: none;" href="{{route('route_show_cart')}}">
                                <div id="san-pham-cart">
                                    <img src="{{asset('/storage/'.$item->options->image)}}">
                                    <div class="col-md-4" ><span>{{$item->name}}</span></div>
                                    <div class="col-md-1"><span>x{{$item->qty}}</span></div>
                                    <div class="col-md-4"><span>{{number_format($item->price)}}đ</span></div>
                                </div>
                                </a>
                                <?php
                                $total += $item->price;
                                ?>
                            @endforeach



                            <div>
                                <h6>
                                    <span>Tạm Tính:</span>
                                    <span style="float: right;">{{number_format($total)}} đ</span>
                                </h6>
                                <h6>
                                    <span>Phí Vận Chuyển:</span>
                                    <span style="float: right;">0 đ</span>
                                </h6>
                                <h6>
                                    <span>Giản giá:</span>
                                    <span style="float: right;">0 đ</span>
                                </h6>
                                <h6>
                                    <span>Tổng tiền thanh toán:</span>
                                    <span style="float: right;">{{number_format($total)}} đ</span>
                                </h6>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="row" id="row">
                    <div class="col-md-6" id="code-sale" >
                        <input class="col-9 col-md-7" type="text" name="" placeholder="Nhập mã giản giá">
                        <input type="submit" name="" value="Áp dụng">
                    </div>
                    <div class="col-12 col-md-6" id="but-pay">
                        <input type="submit" name="Oder" value="Gửi đơn hàng">
                    </div>
                </div>
                @csrf()
                </form>
            </div>
        </div>


        <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
        <script>
            @if(Session::has('gui_don_tc'))
            confirm("{{Session::get('gui_don_tc')}}")
            @endif

            $(document).ready(function(){
                $("#error").click(function(){
                    $("#error").hide();
                })
            })
            $(document).ready(function(){
                $("#error1").click(function(){
                    $("#error1").hide();
                })
            })
            $(document).ready(function(){
                $("#error2").click(function(){
                    $("#error2").hide();
                })
            })
            $(document).ready(function(){
                $("#error3").click(function(){
                    $("#error3").hide();
                })
            })
            $(document).ready(function(){
                $("#error4").click(function(){
                    $("#error4").hide();
                })
            })
            $(document).ready(function(){
                $("#error5").click(function(){
                    $("#error5").hide();
                })
            })

        </script>
    @endsection




