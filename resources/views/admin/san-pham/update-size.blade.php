<!DOCTYPE html>
<title> @yield('title')Sửa Thông Tin Sản Phẩm</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/update-san-pham.css')}}">
@extends('layout_backend')

{{--Tên tiêu đề cho web--}}

@section('content')
    @foreach($list as $sp)
    @endforeach
    <div id="body">
        <div class="container" >
            <div class="row" >
                <div class="col-md-6">
                    <a href="{{route('route_list_san_pham_admin')}}" title="trở lại">
                        <button id="back"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
                    </a>
                    <span id="cap">Sửa Size Giày (Mã giày:{{$sp->id_giay}})</span>
                </div>
            </div>
            <div class="row">
                    <table class="table">
                        <tr class="table-success">
                            <th>Xóa Size Giày (size đã có)</th>
                            <th>Thêm Size Giày (Size chưa có)</th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                    $no_35 ='!35';
                                    $no_36 ='!36';
                                    $no_37 ='!37';
                                    $no_38 ='!38';
                                    $no_39 ='!39';
                                    $no_40 ='!40';
                                    $no_41 ='!41';
                                    $no_42 ='!42';
                                    $no_43 ='!43';
                                    $no_44 ='!44';
                                ?>
                                <form action="{{route('route_delete_size_san_pham_admin')}}" method="post">
                                @csrf
                                <input type="hidden" name="id_giay" value="{{$sp->id_giay}}">
                                @foreach($list as $sp)
                                    @if($sp->size == 35)
                                        <label class="checkbox-inline">
                                            <input name="size_35" type="checkbox" value="35">35
                                        </label>
                                        <?php
                                        $no_35 ='35';
                                        ?>
                                    @elseif($sp->size == 36)
                                        <label class="checkbox-inline">
                                            <input name="size_36" type="checkbox" value="36">36
                                        </label>
                                        <?php
                                        $no_36 ='36';
                                        ?>
                                    @elseif($sp->size == 37)
                                        <label  class="checkbox-inline">
                                            <input name="size_37" type="checkbox" value="37">37
                                        </label>
                                        <?php
                                        $no_37 ='37';
                                        ?>
                                    @elseif($sp->size == 38)
                                        <label class="checkbox-inline">
                                            <input name="size_38" type="checkbox" value="38">38
                                        </label>
                                        <?php
                                        $no_38 ='38';
                                        ?>
                                    @elseif($sp->size == 39)
                                        <label class="checkbox-inline">
                                            <input name="size_39" type="checkbox" value="39">39
                                        </label>
                                        <?php
                                            $no_39 ='39';
                                        ?>
                                    @elseif($sp->size == 40)
                                        <label class="checkbox-inline">
                                            <input name="size_40" type="checkbox" value="40">40
                                        </label>
                                        <?php
                                            $no_40 ='40';
                                        ?>
                                    @elseif($sp->size == 41)
                                        <label class="checkbox-inline">
                                            <input name="size_41" type="checkbox" value="41">41
                                        </label>
                                        <?php
                                            $no_41 ='41';
                                        ?>
                                    @elseif($sp->size == 42)
                                        <label class="checkbox-inline">
                                            <input name="size_42" type="checkbox" value="42">42
                                        </label>
                                        <?php
                                            $no_42 ='42';
                                        ?>
                                    @elseif($sp->size == 43)
                                        <label class="checkbox-inline">
                                            <input name="size_43" type="checkbox" value="43">43
                                        </label>
                                        <?php
                                            $no_43 ='43';
                                        ?>
                                    @elseif($sp->size == 44)
                                        <label class="checkbox-inline">
                                            <input name="size_44" type="checkbox" value="44">44
                                        </label>
                                        <?php
                                            $no_44 ='44';
                                        ?>
                                    @endif
                                @endforeach

                                <div class="timeline-footer" style="position: relative;" onclick="return stop()">
                                    <button type="submit" title="xóa bỏ"
                                            class="btn btn-danger btn-xs">Delete</button>
                                    @if(Session::has('f_size_01'))
                                        <div style="position: absolute; top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{Session::get('f_size_01')}}</span>
                                        </div>
                                    @endif
                                </div>

                                </form>
                            </td>

                            <td>
                                <form action="{{route('route_add_size_san_pham_admin')}}" method="post">
                                <input type="hidden" name="id_giay" value="{{$sp->id_giay}}">
                                @csrf
                                @if($no_35 == '!35')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_35" value="35">35
                                    </label>
                                @endif
                                @if($no_36 == '!36')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_36" value="36">36
                                    </label>
                                @endif
                                @if($no_37 == '!37')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_37" value="37">37
                                    </label>
                                @endif
                                @if($no_38 == '!38')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_38" value="38">38
                                    </label>
                                @endif
                                @if($no_39 == '!39')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_39" value="39">39
                                    </label>
                                @endif
                                @if($no_40 == '!40')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_40" value="40">40
                                    </label>
                                @endif
                                @if($no_41 == '!41')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_41" value="41">41
                                    </label>
                                @endif
                                @if($no_42 == '!42')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_42" value="42">42
                                    </label>
                                @endif
                                @if($no_43 == '!43')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_43" value="43">43
                                    </label>
                                @endif
                                @if($no_44 == '!44')
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="size_44" value="44">44
                                    </label>
                                @endif

                                <div class="timeline-footer" style="position: relative;" >
                                    <button type="submit" title="thêm mới"
                                            class="btn btn-success btn-xs">Add New</button>
                                    @if(Session::has('f_size_02'))
                                        <div style="position: absolute; top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{Session::get('f_size_02')}}</span>
                                        </div>
                                    @endif
                                </div>
                                </form>
                            </td>

                        </tr>



                    </table>
            </div>
        </div>
        <script type="text/javascript">
            @if(Session::has('delete_ss'))
                alert("{{Session::get('delete_ss')}}")
            @elseif(Session::has('add_ss'))
                alert("{{Session::get('add_ss')}}")
            @endif
            function stop() {
                return confirm('Bạn có muốn thực hiện thao tác Xóa ?' )
            }
        </script>
    </div>


@endsection
