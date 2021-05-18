<!DOCTYPE html>
<title> @yield('title')Admin Apolo</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/index-admin.css')}}">
@extends('layout_backend')

@section('content')
    <div id="body">
        <div class="container" >
            <div class="col-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Đơn Hàng tuần qua({{count($list_member)}})</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>

                    <div class="box-body">
                        <table class="table">
                            <tr class="table-success">
                                <th>Mã đơn</th>
                                <th>Tên khách</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</th>
                                <th>Thời gian đặt hàng</th>
                            </tr>
                            @foreach($toltal_order as $sp)
                                <tr>
                                    <td>
                                        {{$sp->id}}
                                    </td>
                                    <td>
                                        {{$sp->fullname}}
                                    </td>
                                    <td>
                                        {{$sp->phone}}
                                    </td>
                                    <td>
                                        {{$sp->address}}
                                    </td>
                                    <td>
                                        {{$sp->time}}
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                        <div id="chuyen-trang" class="row">
                            {{ $toltal_order->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" >
            <div class="col-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tài khoản({{count($list_member)}})</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                        <table class="table">
                            <tr class="table-success">
                                <th>Mã Tài khoản</th>
                                <th>Tên</th>
                                <th>email</th>
                            </tr>
                            @foreach($toltal_member as $sp)
                                <tr>
                                    <td>
                                        {{$sp->id}}
                                    </td>
                                    <td>
                                        <div>{{$sp->name}}</div>
                                    </td>
                                    <td>
                                        <div>{{$sp->email}}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        </div>

                        <div class="clearfix"></div>
                        <div class="row text-right" >
                            {{ $toltal_member->links() }}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>

    </div>
@endsection
