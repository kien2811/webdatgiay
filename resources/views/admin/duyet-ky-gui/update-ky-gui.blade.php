<!DOCTYPE html>
<title> @yield('title')Sửa Thông Tin Sản Phẩm Ký Gửi</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/update-ky-gui.css')}}">
@extends('layout_backend')
@section('content')
    <div id="body">
        @foreach($chi_tiet_sp as $item)
        @endforeach
        <form onsubmit="return validateForm()" method="post" action="{{route('route_save_update_ky_gui')}}" enctype="multipart/form-data">
            @csrf
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6">
                        <a href="{{route('route_list_ky_gui')}}" title="trở lại">
                            <button type="button" class="btn btn-sm btn-primary" s>
                                <i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
                        </a>
                        <span class="box-title">Sửa Sản Phẩm (Mã Giày: {{$item->id}})</span>
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
                                        <input type="hidden" name="id_giay" value="{{$item->id}}">
                                        <label class="col-sm-3 control-label">Ảnh Giày</label>
                                        <div class="col-sm-9">
                                            <img name="img" width="80px;" src="{{asset('/storage/'.$item->image)}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Tên Giày</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="name" value="{{$item->name}}" >
                                            @if($errors->has('name'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('name')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Size Giày</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="size" name="size" value="{{number_format($item->size)}}" >
                                            @if($errors->has('size'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('size')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Số Lượng</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number" name="quantity" max="{{number_format($item->quantity)}}"
                                                   value="{{number_format($item->quantity)}}" style="width: 80px;">
                                            @if($errors->has('quantity'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('quantity')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Giá</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="price" value="{{number_format($item->price)}}" >
                                            @if($errors->has('price'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('price')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Thương Hiệu</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="thuonghieu" value="{{$item->thuonghieu}}" >
                                            @if($errors->has('thuonghieu'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('thuonghieu')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Loại Hàng</label>
                                        <div class="col-sm-9">
                                            <select name="id_loai_hang" class="form-control">
                                                <option value="{{$item->id_loai_hang}}" >{{$item->loai_hang}}</option>
                                                @foreach($list_loai_hang as $lh)
                                                    <option value="{{$lh->id}}">{{$lh->loai_hang}}</option>
                                                @endforeach
                                            </select>
{{--                                            @if($errors->has('thuonghieu'))--}}
{{--                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">--}}
{{--                                                    <span style="color:white;font-size: 13px;">{{$errors->first('thuonghieu')}}</span>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="">
                            <div class="box-header with-border">
                                <h3 class="box-title">Mô Tả Giày</h3>
                            </div>
                            <div class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Ảnh mô tả</label>
                                        <div class="col-sm-9">
                                            <img width="80px;" src="{{asset('/storage/'.$item->image_1)}}">
                                            <img width="80px;" src="{{asset('/storage/'.$item->image_2)}}">
                                            <img width="80px;" src="{{asset('/storage/'.$item->image_3)}}">
                                            <img width="80px;" src="{{asset('/storage/'.$item->image_4)}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Đã Sử Dụng</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="time_da_sd" value="{{$item->time_da_sd}}">
                                            @if($errors->has('time_da_sd'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('time_da_sd')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nội dung mô tả</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" type="text" name="noi_dung_mota">{{$item->noi_dung_mota}}</textarea>
                                            @if($errors->has('noi_dung_mota'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('noi_dung_mota')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Trạng Thái Xử Lý</label>
                                        <div class="col-sm-9">
                                            <select name="id_trang_thai" class="form-control" >
                                                <option>Chọn</option>
                                                @foreach($trang_thai as $item)
                                                    <option value="{{$item->id}}">{{$item->status}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('id_trang_thai'))
                                                <div style="position: absolute;top:0px;left: 60px; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('id_trang_thai')}}</span>
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
        <div class="box-footer" style="text-align: center" title="Lưu" onclick="return stop()">
            <input class="btn btn-success " type="submit" value="Lưu Sản Phẩm" id="update">
        </div>
        </form>
    </div>

    <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        @if(Session::has('succes_update'))
        alert("{{Session::get('succes_update')}}")
        @endif

        function validateForm()
        {
            // Bước 1: Lấy giá trị của username và password
            var username = document.getElementById('size').value;

            // Bước 2: Kiểm tra dữ liệu hợp lệ hay không
            if (username == ''){
                alert('Trường chứa size không được trống');
                return false;
            }

        }

        function stop() {
            return confirm("Bạn có muốn lưu sản phẩm này")
        }


    </script>
@endsection

