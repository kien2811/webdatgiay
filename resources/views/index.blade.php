<!DOCTYPE html>
<title> @yield('title') Trang chủ</title>
    @extends('layout_master')

    <!-- phần body -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-index.css')}}">
    @section('content')
    <div id="boody">
        <div class="container">
            <div class="row" style="padding-top:1%;">
                <div class="col-12 col-md-9">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{asset('img-giao-dien/banner_01.jpg')}}" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset('img-giao-dien/banner_02.jpg')}}" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset('img-giao-dien/banner_03.1.jpg')}}" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <a class="col-12 col-md-3" href="{{route('route_list_giay_ky_sale')}}">
                    <img id="img-show" class="col-12" src="{{asset('img-giao-dien/anh-su-kien.png')}}">
                    <div id="cap-sale">
                        <span> Sale từ 10 - 50 % cho một số sản phẩm ngày khai trương</span>
                    </div>
                </a>

            </div>
        </div>

        <div class="container">
            <div class="row" style="padding-bottom: 15px;">
                <div class="w-100" style="border-bottom: 1px solid black;padding-top: 15px;">
                    <div id="cap-sp">
                        <a href=""><b>GIÀY HOT</b></a>
                    </div>
                </div>
            </div>

            <div class="row" id="row">
                @foreach($list_sp_hot as $item)
                    <div class="col-6 col-md-3" >
                        <div id="san-pham">
                            <a href="{{route('route_chi_tiet')}}?id={{$item->id}}">
                                <img class="col-12 col-md-12" src="{{asset('/storage/'.$item->image)}}">
                                <li><a href="">{{$item->name}}</a></li>

                                @if($item->id_sale == 1)
                                    <li><a href="">{{number_format($item->price)}} <u>đ</u></a></li>
                                    <li><span style="text-decoration:line-through;">0 <u>đ</u></span></li>
                                @endif
                                @if($item->id_sale != 1)
                                    <li style="text-decoration:line-through;">
                                        <a href="">{{number_format($item->price)}} <u>đ</u></a>
                                    </li>
                                    <?php
                                    $price_sale = $item->price*($item->sale_phan_tram/100);
                                    $price_sale = $item->price - $price_sale;
                                    ?>
                                    <li style="font-weight: bold;">
                                        <a style="color:  #ed1b24;" href="">{{number_format($price_sale)}} <u>đ</u></a>
                                    </li>
                                @endif

                                <a href="{{route('route_chi_tiet')}}?id={{$item->id}}"><input type="button" name="" value="MUA"></a>
                                @if($item->id_sale != 1)
                                    <div id="layer_sale">
                                        <div id="sale">
                                            <span id="nb_sale">{{$item->sale_phan_tram}}%</span>
                                        </div>
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row" style="padding-bottom: 15px;padding-top: 15px;">
                <div class="w-100" style="border-bottom: 1px solid black;">
                    <div id="cap-sp">
                        <a href=""><b>GIÀY MỚI</b></a>
                    </div>
                </div>
            </div>

            <div class="row" id="row">
                @foreach($list_sp_new as $item)
                <div class="col-6 col-md-3" >
                    <div id="san-pham">
                        <a href="{{route('route_chi_tiet')}}?id={{$item->id}}">
                        <img class="col-12 col-md-12" src="{{asset('/storage/'.$item->image)}}">
                        <li><a href="">{{$item->name}}</a></li>
                        @if($item->id_sale == 1)
                            <li><a href="">{{number_format($item->price)}} <u>đ</u></a></li>
                            <li><span style="text-decoration:line-through;">0 <u>đ</u></span></li>
                        @endif
                        @if($item->id_sale != 1)
                            <li style="text-decoration:line-through;">
                                <a href="">{{number_format($item->price)}} <u>đ</u></a>
                            </li>
                            <?php
                            $price_sale = $item->price*($item->sale_phan_tram/100);
                            $price_sale = $item->price - $price_sale;
                            ?>
                            <li style="font-weight: bold;">
                                <a style="color:  #ed1b24;" href="">{{number_format($price_sale)}} <u>đ</u></a>
                            </li>
                        @endif
                        <a href="{{route('route_chi_tiet')}}?id={{$item->id}}"><input type="button" name="" value="MUA"></a>
                        @if($item->id_sale != 1)
                            <div id="layer_sale">
                                <div id="sale">
                                    <span id="nb_sale">{{$item->sale_phan_tram}}%</span>
                                </div>
                            </div>
                        @endif
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row" style="padding-bottom: 15px;padding-top: 15px;">
                <div class="w-100" style="border-bottom: 1px solid black;">
                    <div id="cap-sp">
                        <a href=""><b>GIÀY KÝ GỬI</b></a>
                    </div>
                </div>
            </div>

            <div class="row" id="row">
                @foreach($list_sp_ky_gui as $item)
                    <div class="col-6 col-md-3" >
                        <div id="san-pham">
                            <a href="{{route('route_chi_tiet_kg')}}?id={{$item->id}}">
                            <img class="col-12 col-md-12" src="{{asset('/storage/'.$item->image)}}">
                            <li><a href="">{{$item->name}}</a></li>
                            <li><a href="">{{number_format($item->price)}} <u>đ</u></a></li>
                            <a href="{{route('route_chi_tiet_kg')}}?id={{$item->id}}"><input type="button" name="" value="MUA"></a>
                            </a>
                        </div>
                    </div>
                @endforeach
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











    @endsection

