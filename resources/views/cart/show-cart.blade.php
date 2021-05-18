<?php
$cont = Cart::content();
$total =0;
//echo '<pre>';
//print_r($cont);
//echo '</pre>';

?>
<!DOCTYPE html>
    <title> @yield('title') Giỏ Hàng</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-gio-hang.css')}}">
@extends('layout_master')
<!-- phần body -->
    @section('content')
        <div id="body-cart">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-2" id="cap-cart">
                        <h3>
                            <span>Giỏ Hàng</span>
                        </h3>
                    </div>

                        <div class="col-12 col-md-12" id="list-cart">
                            @if(Cart::count() ==0)
                                <div style="background-color: #fcf8e3;border: 1px solid #faebcc;padding: 5px;color: #8a6d3b;">
                                    Giỏ hàng của bạn chưa có sản phẩm nào !</div>
                            @else
                            <table class="col-12 col-md-12">
                                <tr style="height:35px;border-bottom: 1px solid #e9dede;">
                                    <th>Sản phẩm</th>
                                    <th>Size</th>
                                    <th>Loại hàng</th>
                                    <th>Giá</th>
                                    <th>Số Lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                                @foreach($cont as $item)
                                <tr id="sanpham-cart">
                                    <td >
                                        <a title="xóa" onclick="return stop()" id="dau-x" href="{{route('route_delete_cart')}}?id={{$item->rowId}}">
                                            <i  class="fa fa-times-circle" aria-hidden="true"></i>
                                        </a>
                                        <img src="{{asset('/storage/'.$item->options->image)}}">
                                        <span>{{$item->name}}</span>
                                    </td>
                                    <td>
                                        {{$item->options->size}}
                                    </td>
                                    <td>
                                        {{$item->options->loai_hang}}
                                    </td>
                                    <td>
                                        <span>{{number_format($item->price)}} <u>đ</u></span>
                                    </td>
                                    <td>
                                        <form action="{{route('route_update_cart')}}" method="post">
                                            <input type="number" name="qty" value="{{$item->qty}}">
                                            <input type="hidden" name="id_update" value="{{$item->rowId}}" >
                                            <button title="cập nhật" type="submit">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                            </button>
                                            @csrf()
                                        </form>
                                    </td>
                                    <td>
                                        <?php
                                            $subtotal = $item->price * $item->qty;
                                            $total += $subtotal;

                                        ?>
                                        <span>{{number_format($subtotal)}}<u>đ</u></span>
                                    </td>
                                </tr>

                                @endforeach
                            </table>
                            @endif
                        </div>

                        <div class=" col-md-12">
                            <div id="tol-tal-pay">
                                <?php
                                    $_SESSION['tong_gia'] = $total;
                                ?>
                                <span>Tổng tiền Thanh Toán:</span> {{number_format($total)}}<u>đ</u>
                            </div>
                        </div>

                        <div class="col-12 col-md-12" id="layer-but">
                            <div id="but-lert">
                                <a href="{{route('route_list_giay')}}">
                                    <input  type="button" name="" value="Tiếp Tục Mua">
                                </a>
                            </div>
                            <div id="but-rig">
                                <a href="{{route('route_oder')}}" >
                                    <input type="button" name="" value="Thanh Toán"></a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <script language="JavaScript">
            function stop() {
                return confirm("Bạn có muốn xóa sản phẩm này ?")
            }
            @if(Session::has('gio_hang_trong'))
            alert("{{Session::get('gio_hang_trong')}}")
            @endif
        </script>

    @endsection
