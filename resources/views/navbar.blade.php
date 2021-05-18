
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <div id="top-toolbar">
        <div class="container">
            <div class="row">
                <ul>
                    <li class="col-md-3"><a href="">Hotline: 012 345 67 89</a></li>
                    <li class="col-md-5"><a href="">Email: apolo@gmail.com</a></li>
                    <li><a href="">Địa chỉ: số 1 Hoàng Đạo Thúy - Thanh Xuân - Hà Nội</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="header">
        <div class="container">
            <div class="row">
                <div id="logo" class="col-12 col-md-4">
                    <a href="{{route('home_trang_chu')}}"><img  src="{{asset('img-giao-dien/logo.png')}}" class="mx-auto d-block" /></a>
                </div>

                <div id="function" class="col-12 col-md-5 offset-md-3">
                    <div id="umbrella" class="col-6 col-md-6" style="position: relative">
                        <a href="{{route('route_show_cart')}}">
                            <i class="fa fa-shopping-cart" ></i>
                            <div style="position: absolute; top:-20px;left:21px;color: white;
                                    background-color: red;width: 30px;border-radius: 50%;">
                                {{Cart::count()}}
                            </div>
                        </a>
                    </div>
                    <div id="umbrella" class="col-6 col-md-6">
                        @if(Auth::check())
                            <a style="color: red" href="{{route('logout')}}">Đăng Xuất</a>
                            @else
                        <a href="{{route('login')}}">Đăng Nhập</a>
                            @endif
                    </div>
                    <div id="umbrella-2" class="col-6 col-md-6">
                        <a href="{{route('route_theo_doi_dh')}}"><i class="fa fa-id-card" aria-hidden="true"></i> Theo dõi đơn hàng</a>
                    </div>
                    <div id="umbrella-2" class="col-6 col-md-6">
                        @if(Auth::check())
                        <a><p style="color: blue;"> {{ Auth::user()->name}}</p></a>
                            @else
                        <a href="{{route('register')}}">Đăng Ký</a>
                            @endif
                    </div>
                </div>
                <div class="col-12">
                    <input type="text" id="seach-mobi"  name="search" placeholder="Nhập từ khóa tìm kiếm" aria-label="Search">
                </div>
            </div>
        </div>
    </div>

    <div id="main-menu">
        <!-- Static navbar -->
        <div class="container">

            <nav class="navbar navbar-expand-lg n ">
                <div class="container">
                    <a class="navbar-brand" href="{{route('home_trang_chu')}}" style="color: black">TRANG CHỦ</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>

                    </button>

                    <div class="collapse navbar-collapse" id="navbarsExample07">
                        <ul class="navbar-nav mr-auto" >
                            <li class="nav-item active">
                                <a class="nav-link" href="{{route('route_list_giay')}}">TẤT CẢ GIÀY<span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="{{route('route_list_giay_nam')}}">GIÀY NAM<span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="{{route('route_list_giay_nu')}}">GIÀY NỮ<span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="{{route('route_list_giay_ky_sale')}}">GIÀY SALE<span class="sr-only">(current)</span></a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">KÝ GỬI</a>
                                <div class="dropdown-menu" aria-labelledby="dropdown07">
                                    <a class="dropdown-item" style="color: black" href="{{route('route_list_giay_ky_gui')}}">giày ký gửi</a>
                                    <a class="dropdown-item" style="color: black" href="{{route('route_ky_gui')}}">ký gửi giày</a>
                                </div>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-md-0" role="search">
                            <div class="form-group">
                                <input type="text" class="form-controller" id="search-input" name="search" placeholder="Tìm kiếm...">
                            </div>

                        </form>
                    </div>
                </div>

            </nav>

        </div>

    </div>
    <div class="col-6 col-md-4">
        <div id="san-pham-sech">
        </div>
    </div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#search-input').on('keyup', function () {
        $value = $(this).val();
        console.log($value);
        $.ajax({
            type: 'get',
            url: '{{ URL::to('search') }}',
            data: {
                'search': $value
            },
            success: function (data) {
                $('#san-pham-sech').html(data);
            }
        });
    })
    $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});

    $('#seach-mobi').on('keyup', function () {
        $value = $(this).val();
        console.log($value);
        $.ajax({
            type: 'get',
            url: '{{ URL::to('search') }}',
            data: {
                'search': $value
            },
            success: function (data) {
                $('#san-pham-sech').html(data);
            }
        });
    })
    $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});
</script>



