<!DOCTYPE html>
<title> @yield('title') Ký gửi Sản phẩm</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-ky-gui.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    @extends('layout_master')
    @section('content')

        <div id="body-kgui">
            <div class="container">
                <div class="row">
                    <h4 class="col-md-12">KHÁCH HÀNG GỬI GIÀY</h4>
                </div>

                <form method="post" action="{{route('route_save_ky_gui')}}" enctype="multipart/form-data">
                @csrf()
                    <div class="row">
                        <!-- 					<div class="col-md-4" id="file-img-kgui" >
                                                <input class="" type="file" id="file" accept="image/*" />
                                                    <label for="file">+ thêm ảnh</label>
                                            </div> -->
                        <div class="col-12 col-md-4" id="file-img-kgui">
                            <div class="col-12" id="file-img-kgui-main" >

                                <input class="" type="file" id="file" name="anh_sp" onchange="readURL(this);" />
                                <label for="file">+ thêm ảnh</label>
                                <div id="thumbbox">
                                    <img id="thumbimage" style="display: none; width: 100%;height: 280px;" />
                                    <a class="removeimg" href="javascript:" ></a>
                                </div>

                                @if($errors->has('anh_sp'))
                                    <div id="hide" style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                        <span style="color:white;font-size: 13px;">{{$errors->first('anh_sp')}}</span>
                                    </div>
                                @endif
                            </div>
                            <h5>Ảnh mô tả sản phẩm</h5>
                            <div class="col-6 col-md-6" id="file-img-kgui-mota">

                                <input class="" type="file" id="file_01"  name="anh_mt_01" onchange="readURdLMT(this);"/>
                                <label for="file_01">+ thêm ảnh</label>
                                <div id="thumbbox">
                                    <img id="thumbimageMT" style="display: none; width: 100%;height: auto;" />
                                    <a class="removeimgMT" href="javascript:" ></a>
                                </div>
                                @if($errors->has('anh_mt_01'))
                                    <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                        <span style="color:white;font-size: 13px;">{{$errors->first('anh_mt_01')}}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 col-md-6" id="file-img-kgui-mota" >

                                <input class="" type="file" id="file_02"  name="anh_mt_02" onchange="readURdLMT2(this);"/>
                                <label for="file_02">+ thêm ảnh</label>
                                <div id="thumbbox">
                                    <img id="thumbimageMT2" style="display: none; width: 100%;height: auto;" />
                                    <a class="removeimgg" href="javascript:" ></a>
                                </div>
                                @if($errors->has('anh_mt_02'))
                                    <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                        <span style="color:white;font-size: 13px;">{{$errors->first('anh_mt_02')}}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 col-md-6" id="file-img-kgui-mota" >

                                <input class="" type="file" id="file_03"  name="anh_mt_03" onchange="readURdLMT3(this);"/>
                                <label for="file_03">+ thêm ảnh</label>
                                <div id="thumbbox">
                                    <img id="thumbimageMT3" style="display: none; width: 100%;height: auto;" />
                                    <a class="removeimgg" href="javascript:" ></a>
                                </div>
                                @if($errors->has('anh_mt_03'))
                                    <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                        <span style="color:white;font-size: 13px;">{{$errors->first('anh_mt_03')}}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 col-md-6" id="file-img-kgui-mota" >
                                <input class="" type="file" id="file_04"  name="anh_mt_04"  onchange="readURdLMT4(this);"/>
                                <label for="file_04">+ thêm ảnh</label>
                                <div id="thumbbox">
                                    <img id="thumbimageMT4" style="display: none; width: 100%;height: auto;" />
                                    <a class="removeimgmt" href="javascript:" ></a>
                                </div>
                                @if($errors->has('anh_mt_04'))
                                    <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                        <span style="color:white;font-size: 13px;">{{$errors->first('anh_mt_04')}}</span>
                                    </div>
                                @endif
                            </div>


                        </div>


                        <div class="col-md-8" id="form-information">
                            <div class="col-md-10" id="information">
                                <h5>Thêm thông tin sản phẩm</h5>
                                <div style="position: relative" class="form-group">
                                    <label >Tên Giày</label>
                                    <input class="form-control" type="text" name="name_giay" placeholder="Giày Vans CLassic">
                                    @if($errors->has('name_giay'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('name_giay')}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="position: relative" class="form-group">
                                    <label >Giá </label>
                                    <input class="form-control" type="text" name="price" placeholder="giá sản phẩm này ?">
                                    @if($errors->has('price'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('price')}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="position: relative" class="form-group">
                                    <label >Thương Hiệu </label>
                                    <input class="form-control" type="text" name="thuong_hieu" placeholder="sản phẩm này thương hiệu nào ?">
                                    @if($errors->has('thuong_hieu'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('thuong_hieu')}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="position: relative" class="form-group">
                                    <label >Đã Sử Dụng</label>
                                    <input class="form-control" type="text" name="time_da_sd" placeholder="bạn đã sử dụng bao lâu ?">
                                    @if($errors->has('time_da_sd'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('time_da_sd')}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="position: relative" class="form-group">
                                    <label >Mô Tả Giày</label>
                                    <textarea class="form-control" id="mota" name="mota" placeholder="Hãy mô tả sản phẩm !"></textarea>
                                    @if($errors->has('mota'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('mota')}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="position: relative; margin-top:7%;">
                                    <label >Loại Hàng</label>
                                    <select name="id_loai_hang" class="form-control" >
                                        <option>Loại hàng</option>
                                        @foreach($list_loai_hang as $item)
                                            <option value="{{$item->id}}">{{$item->loai_hang}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('id_loai_hang'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('id_loai_hang')}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="position: relative;margin-top:3%; ">
                                    <div class=" dropright" id="dropdown">
                                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                                            Size Giày & Số Lượng
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right" id="size-qtt">

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_35" type="checkbox" value="35"><b>35</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_35" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_36" type="checkbox" value="36"><b>36</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_36" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_37" type="checkbox" value="37"><b>37</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_37" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_38" type="checkbox" value="38"><b>38</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_38" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_39" type="checkbox" value="39"><b>39</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_39" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_40" type="checkbox" value="40"><b>40</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_40" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_41" type="checkbox" value="41"><b>41</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_41" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_42" type="checkbox" value="42"><b>42</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_42" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_43" type="checkbox" value="43"><b>43</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_43" type="number" value="0">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="sz_44" type="checkbox" value="44"><b>44</b>
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <b>số lượng</b>
                                                        <input id="qtt" name="qtt_44" type="number" value="0">
                                                    </label>
                                                </div>
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

                            <div class="col-md-10" id="information-customer">
                                <h5>Thêm thông khách Hàng</h5>

                                <div style="position: relative" class="form-group">
                                    <label >Họ và Tên</label>
                                    <input class="form-control" type="text" name="full_name" value="{{Auth::user()->name}}">
                                    @if($errors->has('full_name'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('full_name')}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="position: relative" class="form-group">
                                    <label >Số điện thoại</label>
                                    <input class="form-control" type="text" name="phone" placeholder="vd:038 777 54 54">
                                    @if($errors->has('phone'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('phone')}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div style="position: relative" class="form-group">
                                    <label >Địa Chỉ</label>
                                    <textarea class="form-control" name="address" type="text" placeholder="địa chỉ liên hệ"></textarea>
                                    @if($errors->has('address'))
                                        <div style="position: absolute; top: 0px;left: 55%; background-color: red;padding: 5px;text-align: center;border-radius: 10px; box-shadow: 0px 0px 5px black;">
                                            <span style="color:white;font-size: 13px;">{{$errors->first('address')}}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-10" id="note-kgui">
                                <div>
                                    <span><b>*</b> Sản phẩm sau khi gửi, sẽ phải đợi admin duyệt và thông báo sớm nhất.</span><br>
                                    <span><b>*</b>	Ảnh sản phẩm phải chính xác, nếu Sai shop sẽ gửi trả sản phẩm cho khách hàng.</span><br>
                                    <span><b>*</b>	Shop sẽ liên hệ lại Khách hàng sau khi nhận được thông tin bài Gửi.</span><br>
                                    <span><b>*</b>	Sau khi giao dịch gửi sản phẩm thành công, shop sẽ chuyển Tiền tới khách hàng.</span><br>
                                    <span><b>*</b>	Hãy hợp tác Uy tín - Trung thực. Cảm ơn quý khácnh đã ủng hộ Apolo !</span><br>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 offset-md-9" id="but-kgui">
                                <input type="submit" name="" value="Gửi Giày">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
        <script>
            @if(Session::has('succes'))
            confirm("{{Session::get('succes')}}")
            @endif

            //hàm ẩn lỗi
            $(document).ready(function(){
                $("#hide").click(function(){
                    $("#hide").hide();
                })
            })


            function  readURL(input,thumbimage) {
                if  (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
                    var  reader = new FileReader();
                    reader.onload = function (e) {
                        $("#thumbimage").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else  { // Sử dụng cho IE
                    $("#thumbimage").attr('src', input.value);

                }
                $("#thumbimage").show();
                $('.filename').text($("#uploadfile").val());
                $('.Choicefile').css('background', '#C4C4C4');
                $('.Choicefile').css('cursor', 'default');
                $(".removeimg").show();
                $(".Choicefile").unbind('click'); //Xóa sự kiện  click trên nút .Choicefile

            }
            $(document).ready(function () {
                $(".Choicefile").bind('click', function  () { //Chọn file khi .Choicefile Click
                    $("#uploadfile").click();

                });
                $(".removeimg").click(function () {//Xóa hình  ảnh đang xem
                    $("#thumbimage").attr('src', '').hide();
                    $("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURL(this);" />');
                    $(".removeimg").hide();
                    $(".Choicefile").bind('click', function  () {//Tạo lại sự kiện click để chọn file
                        $("#uploadfile").click();
                    });
                    $('.Choicefile').css('background','#0877D8');
                    $('.Choicefile').css('cursor', 'pointer');
                    $(".filename").text("");
                });
            })

            function  readURdLMT(input,thumbimageMT) {
                if  (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
                    var  reader = new FileReader();
                    reader.onload = function (e) {
                        $("#thumbimageMT").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else  { // Sử dụng cho IE
                    $("#thumbimageMT").attr('src', input.value);

                }
                $("#thumbimageMT").show();
                $('.filename').text($("#uploadfile").val());
                $('.Choicefile').css('background', '#C4C4C4');
                $('.Choicefile').css('cursor', 'default');
                $(".removeimgMT").show();
                $(".Choicefile").unbind('click'); //Xóa sự kiện  click trên nút .Choicefile

            }
            $(document).ready(function () {
                $(".Choicefile").bind('click', function  () { //Chọn file khi .Choicefile Click
                    $("#uploadfile").click();

                });
                $(".removeimgMT").click(function () {//Xóa hình  ảnh đang xem
                    $("#thumbimageMT").attr('src', '').hide();
                    $("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURdLMT(this);" />');
                    $(".removeimgMT").hide();
                    $(".Choicefile").bind('click', function  () {//Tạo lại sự kiện click để chọn file
                        $("#uploadfile").click();
                    });
                    $('.Choicefile').css('background','#0877D8');
                    $('.Choicefile').css('cursor', 'pointer');
                    $(".filename").text("");
                });
            })


            function  readURdLMT2(input,thumbimageMT2) {
                if  (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
                    var  reader = new FileReader();
                    reader.onload = function (e) {
                        $("#thumbimageMT2").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else  { // Sử dụng cho IE
                    $("#thumbimageMT2").attr('src', input.value);

                }
                $("#thumbimageMT2").show();
                $('.filename').text($("#uploadfile").val());
                $('.Choicefile').css('background', '#C4C4C4');
                $('.Choicefile').css('cursor', 'default');
                $(".removeimgMT2").show();
                $(".Choicefile").unbind('click'); //Xóa sự kiện  click trên nút .Choicefile

            }
            $(document).ready(function () {
                $(".Choicefile").bind('click', function  () { //Chọn file khi .Choicefile Click
                    $("#uploadfile").click();

                });
                $(".removeimgg").click(function () {//Xóa hình  ảnh đang xem
                    $("#thumbimageMT2").attr('src', '').hide();
                    $("#myfileupload").html('<input type="file" id="file_03"  onchange="readURdLMT2(this);" />');
                    $(".thumbimageMT2").hide();
                    $(".Choicefile").bind('click', function  () {//Tạo lại sự kiện click để chọn file
                        $("#uploadfile").click();
                    });
                    $('.Choicefile').css('background','#0877D8');
                    $('.Choicefile').css('cursor', 'pointer');
                    $(".filename").text("");
                });
            })


            function  readURdLMT3(input,thumbimageMT3) {
                if  (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
                    var  reader = new FileReader();
                    reader.onload = function (e) {
                        $("#thumbimageMT3").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else  { // Sử dụng cho IE
                    $("#thumbimageMT3").attr('src', input.value);

                }
                $("#thumbimageMT3").show();
                $('.filename').text($("#uploadfile").val());
                $('.Choicefile').css('background', '#C4C4C4');
                $('.Choicefile').css('cursor', 'default');
                $(".removeimgg").show();
                $(".Choicefile").unbind('click'); //Xóa sự kiện  click trên nút .Choicefile

            }
            $(document).ready(function () {
                $(".Choicefile").bind('click', function  () { //Chọn file khi .Choicefile Click
                    $("#uploadfile").click();

                });
                $(".removeimgg").click(function () {//Xóa hình  ảnh đang xem
                    $("#thumbimageMT3").attr('src', '').hide();
                    $("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURdLMT2(this);" />');
                    $(".removeimgg").hide();
                    $(".Choicefile").bind('click', function  () {//Tạo lại sự kiện click để chọn file
                        $("#uploadfile").click();
                    });
                    $('.Choicefile').css('background','#0877D8');
                    $('.Choicefile').css('cursor', 'pointer');
                    $(".filename").text("");
                });
            })


            function  readURdLMT4(input,thumbimageMT4) {
                if  (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
                    var  reader = new FileReader();
                    reader.onload = function (e) {
                        $("#thumbimageMT4").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else  { // Sử dụng cho IE
                    $("#thumbimageMT4").attr('src', input.value);

                }
                $("#thumbimageMT4").show();
                $('.filename').text($("#uploadfile").val());
                $('.Choicefile').css('background', '#C4C4C4');
                $('.Choicefile').css('cursor', 'default');
                $(".removeimgmt").show();
                $(".Choicefile").unbind('click'); //Xóa sự kiện  click trên nút .Choicefile

            }
            $(document).ready(function () {
                $(".Choicefile").bind('click', function  () { //Chọn file khi .Choicefile Click
                    $("#uploadfile").click();

                });
                $(".removeimgg").click(function () {//Xóa hình  ảnh đang xem
                    $("#thumbimageMT4").attr('src', '').hide();
                    $("#myfileupload").html('<input type="file" id="uploadfile"  onchange="readURdLMT2(this);" />');
                    $(".removeimgmt").hide();
                    $(".Choicefile").bind('click', function  () {//Tạo lại sự kiện click để chọn file
                        $("#uploadfile").click();
                    });
                    $('.Choicefile').css('background','#0877D8');
                    $('.Choicefile').css('cursor', 'pointer');
                    $(".filename").text("");
                });
            })


        </script>
    @endsection



