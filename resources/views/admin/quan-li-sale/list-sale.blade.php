<!DOCTYPE html>
<title> @yield('title') Quản lý Giảm Giá </title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/sale-san-pham.css')}}">
@extends('layout_backend')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@section('content')
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6" >
                        @if( $view == 'chua_sale')
                            <span class="box-title">Sản phẩm chưa giảm giá ({{count($total_sp)}})</span>
                        @elseif($view == 'sale')
                            <span class="box-title">Sản phẩm đã giảm giá ({{count($total_sp)}})</span>
                        @elseif($view == 'all')
                            <span class="box-title">Tất cả Sản Phẩm ({{count($total_sp)}})</span>
                        @endif
                    </div>

                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs">
                                <input class="form-control pull-left" id="myInput" type="text" placeholder="Search..">
                            <div class="input-group-btn" style="width: 50px;padding-left: 10px;">
                                <a href="{{route('route_list_giay_sale')}}" title="Lọc">
                                    <button class="btn btn-success" >
                                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        Giày đã sale</button>
                                </a>
                                <a href="{{route('route_list_giay_chua_sale')}}" title="Lọc">
                                    <button class="btn btn-danger" style="margin-left: 5px;">
                                        <i class="fa fa-search-minus" aria-hidden="true"></i>
                                        Giày chưa sale</button>
                                </a>
                                <a href="{{route('route_list_sale')}}" title="Tải Lại">
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
                            <th>size</th>
                            <th>Loại Hàng</th>
                            <th>Thương Hiệu</th>
                            <th>Giá Gốc</th>
                            <th>Giá Sale</th>
                            <th>Sale"%"</th>
                        </tr>
                        @foreach($list_sale as $sale)
                            <tbody id="myTable">
                                <td>{{$sale->id}}</td>
                                <td style="padding: 10px;">
                                    <img width="80px;" src="{{asset('/storage/'.$sale->image)}}">
                                    <div><span>{{$sale->name}}</span></div>
                                </td>
                                <td>
                                    @foreach($list_size[$sale->id] as $sz)
                                        {{$sz->size}}/
                                    @endforeach
                                </td>
                                <td>{{$sale->loai_hang}}</td>
                                <td>{{$sale->thuonghieu}}</td>
                                @if($sale->sale_phan_tram == 0)
                                    <td style="text-align: center">{{number_format($sale->price)}} đ</td>
                                @elseif($sale->sale_phan_tram > 0)
                                    <td style="position: relative;text-align: center">
                                        <div style="background-color: red; position: absolute;top: 30px;box-shadow: 0px 0px 2px black;">
                                            <span style="color:white;padding:5px ">Đang Sale {{$sale->sale_phan_tram}}%</span>
                                        </div>
                                        <span style="text-decoration:line-through">{{number_format($sale->price)}} đ</span>
                                    </td>
                                @endif

                                @if($sale->sale_phan_tram == 0)
                                    <td>{{number_format($sale->price)}} đ</td>
                                @elseif($sale->sale_phan_tram > 0)
                                    <?php
                                    $price_sale = $sale->price*($sale->sale_phan_tram/100);
                                    $price_sale = $sale->price - $price_sale;
                                    ?>
                                    <td style="text-align: center;color: #EB4924;padding: 10px;text-shadow: 0px 0px 2px red;">
                                        <span style="">{{number_format($price_sale)}} đ</span>
                                    </td>
                                @endif
                                <form action="{{route('route_update_sale')}}" method="post">
                                    <td style="padding: 10px;text-align: center">
                                        <select name="id_sale" style="box-shadow: 0px 0px 2px black">
                                            <option value="{{$sale->id_sale}}">-{{$sale->sale_phan_tram}}%</option>
                                            @foreach($op_sale as $pt_sale)
                                                <option style="background-color: red;color: white;" value="{{$pt_sale->id}}"> -{{$pt_sale->sale_phan_tram}}%</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="id_sp" value="{{$sale->id}}">
                                        <button type="submit" title="Lưu"><i class="fa fa-sliders" aria-hidden="true"></i></button>
                                    </td>
                                    @csrf()
                                </form>
                            </tbody>
                        @endforeach

                    </table>
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $list_sale->appends(['minid' => 6, 'maxid' => 10])->links() }}</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    {{--<script type="text/javascript">--}}
        {{--$('#search').on('keyup',function(){--}}
            {{--$value = $(this).val();--}}
            {{--$.ajax({--}}
                {{--type: 'get',--}}
                {{--url: '{{ URL::to('search-sale') }}',--}}
                {{--data: {--}}
                    {{--'search': $value--}}
                {{--},--}}
                {{--success:function(data){--}}
                    {{--$('tbody').html(data);--}}
                {{--}--}}
            {{--});--}}
        {{--})--}}
        {{--$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });--}}
    {{--</script>--}}

@endsection

