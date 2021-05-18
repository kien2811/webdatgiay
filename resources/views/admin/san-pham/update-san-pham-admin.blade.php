<!DOCTYPE html>
<title> @yield('title')Sửa Thông Tin Sản Phẩm</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/update-san-pham.css')}}">
@extends('layout_backend')

{{--Tên tiêu đề cho web--}}

@section('content')
    @foreach($list as $sp)
    @endforeach
    <form method="post" action="{{route('route_up_date_san_pham_admin')}}" enctype="multipart/form-data">
    @csrf
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6">
                        <a href="{{route('route_list_san_pham_admin')}}" title="trở lại">
                            <button type="button" class="btn btn-sm btn-primary" s><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
                        </a>
                        <span class="box-title">Sửa Sản Phẩm(Mã Giày {{$sp->id}})</span>
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="">
                            <div class="box-header with-border">
                                <h3 class="box-title">Thông Tin Giày</h3>
                            </div>
                            <div class="form-horizontal">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Ảnh Giày</label>
                                        <div class="col-sm-9">
                                            <img width="80px" src="{{asset('/storage/'.$sp->image)}}">
                                            <div style="margin-top: 5px;">
                                                <input type="file" name="image" value="{{$sp->image}}" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Tên Giày</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="id" value="{{$sp->id}}">
                                            <input type="hidden" name="id_mota" value="{{$sp->id_mota}}">
                                            <input type="hidden" name="uid" value="{{$sp->uid}}">
                                            <input class="form-control" name="name_giay" type="text" value="{{$sp->name}}">
                                            @if($errors->has('name_giay'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('name_giay')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Giá Giày</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="price_giay" type="text" value="{{$sp->price}}">
                                            @if($errors->has('price_giay'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('price_giay')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Thương Hiệu</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="thuong_hieu" type="text" value="{{$sp->thuonghieu}}">
                                            @if($errors->has('thuong_hieu'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('thuong_hieu')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Giới Tính</label>
                                        <div class="col-sm-9">
                                            <select name="id_gender" class="form-control">
                                                <option value="{{$sp->id_gender}}">{{$sp->gender}}</option>
                                                @foreach($list_gender as $gender)
                                                    <option value="{{$gender->id}}">{{$gender->gender}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Loại Hàng</label>
                                        <div class="col-sm-9">
                                            <select name="id_loai_hang" class="form-control">
                                                <option value="{{$sp->id_loai_hang}}">{{$sp->loai_hang}}</option>
                                                @foreach($list_loai_hang as $loai_hang)
                                                    <option value="{{$loai_hang->id}}">{{$loai_hang->loai_hang}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="">
                            <div class="box-header with-border">
                                <h3 class="box-title">Nhập Mô Tả Giày</h3>
                            </div>
                            <div class="form-horizontal">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Ảnh Mô Tả</label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-6">
                                                <img width="80px" src="{{asset('/storage/'.$sp->image_1)}}">
                                                <div style="margin-top: 5px;">
                                                    <input type="file" name="image_1" style="font-size: 10px;" >
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <img width="80px" src="{{asset('/storage/'.$sp->image_2)}}">
                                                <div style="margin-top: 5px;">
                                                    <input type="file" name="image_2" style="font-size: 10px;" >
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="col-sm-9 col-sm-offset-3" style="margin-top: 15px;">
                                            <div class="col-sm-6">
                                                <img width="80px" src="{{asset('/storage/'.$sp->image_3)}}">
                                                <div style="margin-top: 5px;">
                                                    <input type="file" name="image_3" style="font-size: 10px;" >
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <img width="80px" src="{{asset('/storage/'.$sp->image_4)}}">
                                                <div style="margin-top: 5px;">
                                                    <input type="file" name="image_4" style="font-size: 10px;" >
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Cap Mô Tả</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="cap_mo_ta">{{$sp->cap_mo_ta}}</textarea>
                                            @if($errors->has('cap_mo_ta'))
                                                <div style="position: absolute;top:0px;left: 150px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('cap_mo_ta')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nội Dung Mô Tả</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="noi_dung_mo_ta">{{$sp->noi_dung_mota}}</textarea>
                                            @if($errors->has('noi_dung_mo_ta'))
                                                <div style="position: absolute;top:0px;left: 150px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('noi_dung_mo_ta')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Màu Sắc</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="mau_sac">{{$sp->mausac}}</textarea>
                                            @if($errors->has('mau_sac'))
                                                <div style="position: absolute;top:0px;left: 150px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('mau_sac')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nơi Sản Xuất</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="noi_sx">{{$sp->noi_SX}}</textarea>
                                            @if($errors->has('noi_sx'))
                                                <div style="position: absolute;top:0px;left: 150px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('noi_sx')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
        <div class="box-footer" style="text-align: center">
            <input class="btn btn-success " type="submit" value="Lưu Sản Phẩm">
        </div>
    </div>
    </form>


    <script type="text/javascript">
        @if(Session::has('msg'))
            alert("{{Session::get('msg')}}")
        @endif
        function stop() {
            return confirm('Bạn có muốn xóa không ???' )
        }
    </script>


@endsection
