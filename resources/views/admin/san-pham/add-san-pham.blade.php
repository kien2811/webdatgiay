<!DOCTYPE html>
<title> @yield('title')Đăng Bán Sản Phẩm</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-admin/add-san-pham.css')}}">
@extends('layout_backend')
@section('content')
    <div id="body">
        <div class="container" >
            <div class="box">
                <div class="box-header with-border" >
                    <div class="col-md-6">
                        <a href="{{route('route_list_san_pham_admin')}}" title="trở lại">
                            <button class="btn btn-sm btn-primary" s><i class="fa fa-long-arrow-left" aria-hidden="true"></i></button>
                        </a>
                        <span class="box-title">Thêm Sản Phẩm Mới</span>
                    </div>
                </div>
                <form method="post" action="{{route('route_save_new_giay')}}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <div class="">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nhập Thông Tin Giày</h3>
                        </div>
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tên Giày</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name_giay" placeholder="Nhập tên giày">
                                        @if($errors->has('name_giay'))
                                            <div style="position: absolute;top:0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                <span style="color:white;font-size: 13px;">{{$errors->first('name_giay')}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Giá Giày</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="price_giay" placeholder="Nhập giá giày">
                                        @if($errors->has('price_giay'))
                                            <div style="position: absolute; top:0px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                <span style="color:white;font-size: 13px;">{{$errors->first('price_giay')}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Thương Hiệu</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="thuong_hieu" placeholder="Nhập tên thương hiệu">
                                        @if($errors->has('thuong_hieu'))
                                            <div style="position: absolute; top:0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                <span style="color:white;font-size: 13px;">{{$errors->first('thuong_hieu')}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Giới Tính</label>
                                    <div class="col-sm-9">
                                        <select name="id_gender" class="form-control">
                                            <option>-Chọn Giới Tính-</option>
                                            @foreach($list_gender as $gt)
                                                <option value="{{$gt->id}}">{{$gt->gender}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('id_gender'))
                                            <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                <span style="color:white;font-size: 13px;">{{$errors->first('id_gender')}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Loại Hàng</label>
                                    <div class="col-sm-9">
                                        <select name="id_loai_hang" class="form-control">
                                            <option>-Chọn Loại hàng-</option>
                                            @foreach($list_loai_hang as $lh)
                                                <option value="{{$lh->id}}">{{$lh->loai_hang}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('id_loai_hang'))
                                            <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                <span style="color:white;font-size: 13px;">{{$errors->first('id_loai_hang')}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Size (35-44)</label>
                                    <div class="col-sm-9">
                                            <div class=" dropright" id="dropdown" >
                                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                                                    Size Giày & Số Lượng
                                                </button>

                                                <div class="dropdown-menu dropdown-menu-right" style="width: 300px;">

                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_35" type="checkbox" value="35"><b>35</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_35" type="number" value="0">
                                                            </label>
                                                        </div>

                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_36" type="checkbox" value="36"><b>36</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_36" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_37" type="checkbox" value="37"><b>37</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_37" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_38" type="checkbox" value="38"><b>38</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_38" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_39" type="checkbox" value="39"><b>39</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_39" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_40" type="checkbox" value="40"><b>40</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_40" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_41" type="checkbox" value="41"><b>41</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_41" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_42" type="checkbox" value="42"><b>42</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_42" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_43" type="checkbox" value="43"><b>43</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_43" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="w-100">
                                                        <div class="input-group-addon">
                                                            <label class="form-check-label">
                                                                <input name="sz_44" type="checkbox" value="44"><b>44</b>
                                                            </label>
                                                            <label class="form-check-label">
                                                                <b>- số lượng</b>
                                                                <input id="qtt" name="qtt_44" type="number" value="0">
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                            @if(Session::has('f_size'))
                                                <div style="position: absolute; top:0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{Session::get('f_size')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                        @if(Session::has('f_size'))
                                            <div style="position: absolute; top:0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                <span style="color:white;font-size: 13px;">{{Session::get('f_size')}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Ảnh Giày</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="file_anh" >
                                        @if($errors->has('file_anh'))
                                            <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                <span style="color:white;font-size: 13px;">{{$errors->first('file_anh')}}</span>
                                            </div>
                                        @endif
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
                                        <label class="col-sm-3 control-label">Cap Mô Tả</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" type="text" name="cap_mo_ta" placeholder="Cap mô tả sản phẩm"></textarea>
                                            @if($errors->has('cap_mo_ta'))
                                                <div style="position: absolute;top: 0px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('cap_mo_ta')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nội Dung Mô Tả</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control"  type="text" name="noi_dung_mo_ta" placeholder="Nhập nội dung mô tả"></textarea>
                                            @if($errors->has('noi_dung_mo_ta'))
                                                <div style="position: absolute;top: 0px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('noi_dung_mo_ta')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Màu Sắc</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="mau_sac" placeholder="Màu sắc sản phẩm"></textarea>
                                            @if($errors->has('mau_sac'))
                                                <div style="position: absolute;top: 0px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('mau_sac')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nơi Sản Xuất</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" type="text" name="noi_sx" placeholder="Nơi sản xuất"></textarea>
                                            @if($errors->has('noi_sx'))
                                                <div style="position: absolute;top: 0px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('noi_sx')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Ảnh Mô Tả(4 ảnh)</label>
                                        <div class="col-sm-9">
                                            <input style="padding: 2px;" type="file" name="img_mt_01">
                                            @if($errors->has('img_mt_01'))
                                                <div style="position: absolute;top: 0px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('img_mt_01')}}</span>
                                                </div>
                                            @endif

                                            <input style="padding: 2px;" type="file" name="img_mt_02">
                                            @if($errors->has('img_mt_02'))
                                                <div style="position: absolute;top: 30px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('img_mt_02')}}</span>
                                                </div>
                                            @endif

                                            <input style="padding: 2px;" type="file" name="img_mt_03">
                                            @if($errors->has('img_mt_03'))
                                                <div style="position: absolute;top: 60px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('img_mt_03')}}</span>
                                                </div>
                                            @endif

                                            <input style="padding: 2px;" type="file" name="img_mt_04">
                                            @if($errors->has('img_mt_04'))
                                                <div style="position: absolute;top: 90px;left:55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                                    <span style="color:white;font-size: 13px;">{{$errors->first('img_mt_04')}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer" style="text-align: center">
                        <input class="btn btn-success " type="submit" value="Lưu Sản Phẩm">
                    </div>
                </form>

            </div>
        </div>
        <script type="text/javascript">
            @if(Session::has('ss_add'))
                alert("{{Session::get('ss_add')}}")
            @endif
        </script>
    </div>




@endsection

