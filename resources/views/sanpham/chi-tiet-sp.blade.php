<!DOCTYPE html>
<title> @yield('title') Chi tiết sản phẩm</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-chi-tiet.css')}}">
@extends('layout_master')

<!-- phần body -->
    @section('content')
        <div id="body">


            <div class="container">
                <div class="row">

                    @foreach($chi_tiet as $item)
                    @endforeach
                    <div class="col-12 col-md-6">
                        <div class="col-12 col-md-12" >
                            <div class='zoom' id='ex1' style="position: relative;">
                                <img class="mySlides" src='{{asset('/storage/'.$item->image)}}'>
                            </div>
                            <div class='zoom' id='ex2'>
                                <img class="mySlides" src='{{asset('/storage/'.$item->image_1)}}'style="display: none">
                            </div>
                            <div class='zoom' id='ex3'>
                                <img class="mySlides" src='{{asset('/storage/'.$item->image_2)}}' style="display: none">
                            </div>
                            <div class='zoom' id='ex4'>
                                <img class="mySlides" src='{{asset('/storage/'.$item->image_3)}}' style="display: none">
                            </div>
                            <div class='zoom' id='ex5'>
                                <img class="mySlides" src='{{asset('/storage/'.$item->image_4)}}' style="display: none">
                            </div>
                        </div>
                        <div class="w-75" style="margin: auto;" >
                            <div class="col-2 col-md-2" id="img-show" >
                                <img src="{{asset('/storage/'.$item->image)}}" onclick="currentDiv(1)">
                            </div>
                            <div class="col-2 col-md-2" id="img-show" >
                                <img src="{{asset('/storage/'.$item->image_1)}}" onclick="currentDiv(2)">
                            </div>
                            <div class="col-2 col-md-2" id="img-show" >
                                <img src="{{asset('/storage/'.$item->image_2)}}" onclick="currentDiv(3)">
                            </div>
                            <div class="col-2 col-md-2" id="img-show" >
                                <img src="{{asset('/storage/'.$item->image_3)}}" onclick="currentDiv(4)">
                            </div>
                            <div class="col-2 col-md-2" id="img-show">
                                <img src="{{asset('/storage/'.$item->image_4)}}" onclick="currentDiv(5)">
                            </div>
                        </div>
                        @if($item->phan_loai_giay == 'giày mới')
                            @if($item->id_sale != 1)
                                <div id="layer_sale">
                                    <div id="sale">
                                        <span id="nb_sale">{{$item->sale_phan_tram}}%</span>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                    <div class="col-12 col-md-5">
                        <div id="thông-tin-sp">
                            <form method="post" action="{{route('route_save_cart')}}">
                                <h2>{{$item->name}}</h2>
                                <hr>
                                <li>
                                    @if($item->phan_loai_giay == 'giày mới')
                                        @if($item->id_sale != 1)
                                            <span style="text-decoration:line-through;" href="">{{number_format($item->price)}} <u>đ</u></span>
                                            <?php
                                            $price_sale = $item->price*($item->sale_phan_tram/100);
                                            $price_sale = $item->price - $price_sale;
                                            ?>
                                            <span style="color:  #ed1b24;font-weight: bold;" href="">{{number_format($price_sale)}} <u>đ</u></span>
                                        @elseif($item->id_sale == 1)
                                            <span href="">{{number_format($item->price)}} <u>đ</u></span>
                                        @endif
                                    @else
                                        <span href="">{{number_format($item->price)}} <u>đ</u></span>
                                    @endif


                                </li>
                                <hr>
                                <div id="thong-tin-them">
                                    <li>Thương Hiệu: {{$item->thuonghieu}}</span></li>
                                    <li>

                                        @if($item->phan_loai_giay == 'giày mới')
                                            <span>Nơi Sản Xuất: {{$item->noi_SX}}</span>
                                        @endif

                                    </li>
                                    <li><span>Loại Hàng: {{$item->loai_hang}}</span></li>
                                    @if($item->phan_loai_giay == 'giày mới')
                                        <li>Giày: {{$item->gender}}</li>
                                    @endif
                                    <li><span>Còn Size:
                                            @foreach($list_size as $sz)
                                                {{$sz->size}}
                                            @endforeach
                                        </span>
                                    </li>
                                    <li>
                                        @if($item->phan_loai_giay == 'giày mới')
                                            <span >Màu sắc: {{$item->mausac}}</span>
                                        @endif

                                    </li>
                                    <li><span>Đổi trả trong 7 ngày nếu hàng lỗi</span></li>
                                </div>
                                <hr>
                                <li><b>Chọn Size:
                                        <select name="size">
                                            <option value="0">- Lựa Chọn -</option>
                                            @if($item->phan_loai_giay == 'giày mới')
                                                @foreach($list_size as $size)
                                                    <option value="{{$size->size}}">{{$size->size}}</option>
                                                @endforeach
                                            @else
                                                <option value="{{$item->size}}" >{{$item->size}}</option>
                                            @endif
                                        </select></b>
                                </li>
                                <hr>
                                <input name="quantity" type="hidden" value="1">
                                @if($item->phan_loai_giay == 'giày mới')
                                    <input name="producid_hidden" type="hidden" value="{{$_GET['id']}}">
                                @else
                                    <input name="producid_hidden_kg" type="hidden" value="{{$_GET['id']}}">
                                @endif
                                @csrf()
                                <div style="text-align: center;">
                                    <button type="submit" id="mua">MUA HÀNG</button>
                                </div>
{{--                                <div class="thong-bao">--}}
{{--                                    <b>Thông báo : Thêm vào giỏ hàng thành công !</b>--}}
{{--                                </div>--}}
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container">
                <br>
                <br>
                <hr>

                <!-- Nav tabs -->
{{--                <div id="mo-ta-sp">--}}
{{--                    <b>Giày Của CHú</b>--}}
{{--                </div>--}}
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home"><b>Mô Tả</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">Đánh Giá ({{count($total_fb)}})</a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" data-toggle="tab" href="#menu2">Menu 2</a>--}}
{{--                    </li>--}}
                </ul>

                <!-- Tab panes -->

                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                       <div class="row">
                           <div class="col-12 col-md-6" >
                               <div id="mo-ta-chu">
                                   @if($item->phan_loai_giay == 'giày mới')
                                       <h7><b>{{$item->cap_mo_ta}}:</b></h7><br>
                                   @endif
                                   <h7>{{$item->noi_dung_mota}}.</h7>
                               </div>
                           </div>


                           <div class="col-12 col-md-6" >
                               <div class="row" id="img-mt">
                                   <img class="col-12 col-md-6" src="{{asset('/storage/'.$item->image_1)}}">
                                   <img class="col-12 col-md-6" src="{{asset('/storage/'.$item->image_2)}}">
                               </div>
                               <hr>
                               <div class="row" id="img-mt">
                                   <img class="col-12 col-md-6" src="{{asset('/storage/'.$item->image_3)}}">
                                   <img class="col-12 col-md-6" src="{{asset('/storage/'.$item->image_4)}}">
                               </div>
                           </div>
                       </div>
                    </div>

                    <div id="menu1" class="container tab-pane fade"><br>
                        <div class="container">
                            <div class="row">
                                <div id="cap-feedback" class="w-100">
                                    <h5>Đánh giá sản phẩm</h5>
                                </div>
                            </div>

                            <form method="post" action="{{route('route_save_feedback')}}"
                                  enctype="multipart/form-data" >
                                <div class="row">
                                    <div class="col-md-3" id="file-img-feb">
                                        <input type="file" id="file" name="file_anh" onchange="readURL(this);" />
                                        <label for="file">+ thêm ảnh</label>
                                        <div id="thumbbox">
                                            <img id="thumbimage" style="display: none; width: 80%;" />
                                            <a class="removeimg" href="javascript:" ></a>
                                        </div>
                                    </div>
                                    <div class="col-md-8 offset-md-1" id="conten-feb">
                                        <textarea name="noi_dung" class="form-control" rows="5" id="comment" placeholder="Lời bạn muốn nói...." maxlength="200"></textarea>
                                        <div class="row" >
                                            <span class="col-md-3">Độ yêu thích:</span>
                                            <div id="stars" class="col-md-3">
                                                <input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
                                                <label class="star star-5" for="star-5"></label>
                                                <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
                                                <label class="star star-4" for="star-4"></label>
                                                <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
                                                <label class="star star-3" for="star-3"></label>
                                                <input class="star star-2" id="star-2" type="radio" name="star" value="2"/>
                                                <label class="star star-2" for="star-2"></label>
                                                <input class="star star-1" id="star-1" type="radio" name="star" value="1"/>
                                                <label class="star star-1" for="star-1"></label>
                                            </div>
                                        </div>

                                        <input type="hidden" name="id_giay" value="{{$item->id}}">
                                        <input type="hidden" name="phan_loai_giay" value="{{$item->phan_loai_giay}}">
                                        @csrf()

                                        <div id="but-feb">
                                            <input class="btn btn-dark" id="btn" type="submit" name="" value="ĐÁNH GIÁ">
                                        </div>

                                    </div>

                                </div>

                            </form>
                        </div>
                        <hr>
                        <div class="row" id="content-feb">
                            <h5 class="col-md-12" >
                               <span>Khách Hàng đã đánh giá</span>
                            </h5>
                        </div>
                        @if(count($total_fb)==0)
                            <div style="background-color: #fcf8e3;border: 1px solid #faebcc;padding: 5px;color: #8a6d3b;">
                                Sản phẩm này chưa có đánh giá !</div>
                        @endif
                        @foreach($feedback as $fb)
                            <div class="row" id="content-feb">
                                <p class="col-md-3">{{$fb->name}}</p>
                                <div class="col-md-2">
                                    @for($i =0 ;$i< $fb->so_sao ; $i++)
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    @endfor

                                </div>
                                <div class="col-md-2">
                                    <span>{{$fb->time}}</span>
                                </div>

                            </div>
                            <div class="row" id="feb-ct">
                                <div class="col-md-2">
                                    @if(isset($fb->image))
                                    <img id="img-feb" src="{{asset('/storage/'.$fb->image)}}">
                                    @else
                                    <img id="img-feb" src="{{asset('img-giao-dien/giay-trong.jpg')}}">
                                    @endif
                                </div>
                                <div id="comenter-custormer" class="col-12 col-md-9 offset-md-1">
                                    <span>{{$fb->noi_dung}}</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="pagination pagination-sm justify-content-end">
                            {{ $feedback->appends(['id'=>$item->id,'minid' => 6, 'maxid' => 10])->links() }}
                        </div>

                    </div>


{{--                    <div id="menu2" class="container tab-pane fade"><br>--}}
{{--                        <h3>Menu 2</h3>--}}
{{--                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>--}}
{{--                    </div>--}}
                </div>
                <hr>
            </div>



            <div class="container">
                <div class="row">
                    <div class="w-100">
                        <div id="sp-lien-quan">
                            <b>Sản phẩm liên quan </b>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    @if($item->phan_loai_giay == 'giày mới')
                        @foreach($list_sp_lq as $item)
                        <div class="col-6 col-md-3">
                            <div id="sp">
                                <img class="col-12 col-md-12" src="{{asset('/storage/'.$item->image)}}">
                                <li>{{$item->name}}</li>
                                <li>
                                    @if($item->id_sale != 1)
                                        <span style="text-decoration:line-through;" href="">{{number_format($item->price)}} <u>đ</u></span>
                                        <?php
                                        $price_sale = $item->price*($item->sale_phan_tram/100);
                                        $price_sale = $item->price - $price_sale;
                                        ?>
                                        <span style="color:  #ed1b24;font-weight: bold;" href="">{{number_format($price_sale)}} <u>đ</u></span>
                                    @elseif($item->id_sale == 1)
                                        <span href="">{{number_format($item->price)}} <u>đ</u></span>
                                    @endif

                                    <span href="">{{number_format($item->price)}} <u>đ</u></span>

                                </li>

                                <a href="{{route('route_chi_tiet')}}?id={{$item->id}}" ><button id="">Mua</button></a>

                                    @if($item->id_sale != 1)
                                        <div id="layer_sale">
                                            <div id="sale">
                                                <span id="nb_sale">{{$item->sale_phan_tram}}%</span>
                                            </div>
                                        </div>
                                    @endif

                            </div>
                        </div>
                        @endforeach
                    @else
                        @foreach($list_sp_lq as $item)
                            <div class="col-12 col-md-3">
                                <div id="sp">
                                    <img class="col-12 col-md-12" src="{{asset('/storage/'.$item->image)}}">
                                    <li>{{$item->name}}</li>
                                    <li>{{number_format($item->price)}} <u>đ</u></li>
                                    <a href="{{route('route_chi_tiet_kg')}}?id={{$item->id}}"><button id="">Mua</button></a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        <div class="container">
            <div class="row">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-none d-lg-block">
                                <div class="slide-box">
                                    <img src="http://intotnhat.vn/upload/images/anhtintuc/adidas-02.jpg" alt="First slide">
                                    <img src="https://logoart.vn/blog/wp-content/uploads/2013/01/thiet-ke-logo-dep-mat-sao-kim1.png" alt="First slide">
                                    <img src="https://www.brandsvietnam.com/upload/forum2/2017/08/113197Converse1_1502818474.jpg" alt="First slide">
                                </div>
                            </div>
                            <div class="d-none d-md-block d-lg-none">
                                <div class="slide-box">
                                    <img src="http://intotnhat.vn/upload/images/anhtintuc/adidas-02.jpg" alt="First slide">
                                    <img src="https://logoart.vn/blog/wp-content/uploads/2013/01/thiet-ke-logo-dep-mat-sao-kim1.png" alt="First slide">
                                    <img src="https://www.brandsvietnam.com/upload/forum2/2017/08/113197Converse1_1502818474.jpg" alt="First slide">
                                </div>
                            </div>
                            <div class="d-none d-sm-block d-md-none">
                                <div class="slide-box">
                                    <img src="https://logoart.vn/blog/wp-content/uploads/2013/01/thiet-ke-logo-dep-mat-sao-kim1.png" alt="First slide">
                                    <img src="https://www.brandsvietnam.com/upload/forum2/2017/08/113197Converse1_1502818474.jpg" alt="First slide">
                                </div>
                            </div>
                            <div class="d-block d-sm-none">
                                <img class="d-block w-100" src="http://intotnhat.vn/upload/images/anhtintuc/adidas-02.jpg" alt="First slide">
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-none d-lg-block">
                                <div class="slide-box">
                                    <img src="http://soha.flipboard.vcmedia.vn/k:flipboard/100/4f3804dangsaulogonhungdoigiayt/dang-sau-logo-nhung-doi-giay-the-thao-noi-tieng.jpg" alt="Second slide">
                                    <img src="https://www.pngkey.com/png/detail/76-763853_the-g-ery-for-reebok-shoes-logo-reebok.png" alt="Second slide">
                                    <img src="https://luxuryheterotopia.files.wordpress.com/2017/03/gucci-logo-3.jpg?w=1140" alt="Second slide">
                                </div>
                            </div>
                            <div class="d-none d-md-block d-lg-none">
                                <div class="slide-box">
                                    <img src="http://soha.flipboard.vcmedia.vn/k:flipboard/100/4f3804dangsaulogonhungdoigiayt/dang-sau-logo-nhung-doi-giay-the-thao-noi-tieng.jpg" alt="Second slide">
                                    <img src="https://www.pngkey.com/png/detail/76-763853_the-g-ery-for-reebok-shoes-logo-reebok.png" alt="Second slide">
                                    <img src="https://luxuryheterotopia.files.wordpress.com/2017/03/gucci-logo-3.jpg?w=1140" alt="Second slide">
                                </div>
                            </div>
                            <div class="d-none d-sm-block d-md-none">
                                <div class="slide-box">
                                    <img src="http://soha.flipboard.vcmedia.vn/k:flipboard/100/4f3804dangsaulogonhungdoigiayt/dang-sau-logo-nhung-doi-giay-the-thao-noi-tieng.jpg" alt="Second slide">
                                    <img src="https://www.pngkey.com/png/detail/76-763853_the-g-ery-for-reebok-shoes-logo-reebok.png" alt="Second slide">
                                </div>
                            </div>
                            <div class="d-block d-sm-none">
                                <img class="d-block w-100" src="https://luxuryheterotopia.files.wordpress.com/2017/03/gucci-logo-3.jpg?w=1140" alt="Second slide">
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        </div>


        <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
        <script src='{{asset('css/jquery.zoom.js')}}'></script>
        <script>

            document.getElementById('mua').onclick = function()
            {

                if($("option[value='0']").is(":checked")) {
                    alert('Hãy Chọn size phù hợp');
                    return false;
                }
                return true;

            };

            document.getElementById('btn').onclick = function()
            {

                    if($("input:radio[name='star'][value='1']").is(":checked")) {
                        return true;
                    }
                    else if($("input:radio[name='star'][value='2']").is(":checked")) {
                        return true;
                    }
                    else if($("input:radio[name='star'][value='3']").is(":checked")) {
                        return true;
                    }
                    else if($("input:radio[name='star'][value='4']").is(":checked")) {
                        return true;
                    }
                    else if($("input:radio[name='star'][value='5']").is(":checked")) {
                        return true;
                    }
                    else{
                        alert('Bạn hãy đánh giá bằng Sao !');
                        return false;
                    }

            };


            function currentDiv(n) {
                showDivs(slideIndex = n);
            }

            function showDivs(n) {
                var i;
                var x = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("demo");
                if (n > x.length) {slideIndex = 1}
                if (n < 1) {slideIndex = x.length}
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
                }
                x[slideIndex-1].style.display = "block";
                dots[slideIndex-1].className += " w3-opacity-off";
            }
            $(document).ready(function(){
                $('#ex1').zoom();
            });
            $(document).ready(function(){
                $('#ex2').zoom();
            });
            $(document).ready(function(){
                $('#ex3').zoom();
            });
            $(document).ready(function(){
                $('#ex4').zoom();
            });
            $(document).ready(function(){
                $('#ex5').zoom();
            });

            @if(Session::has('loi_size'))
            confirm("{{Session::get('loi_size')}}")
            @endif

            @if($errors->any())
            confirm("Bạn phải chọn sao yêu thích !")
            @endif
            @if(Session::has('succes'))
            confirm("Đánh Giá Sản Phẩm Thành Công !")
            @endif
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

        </script>


    @endsection



