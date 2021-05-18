
<!DOCTYPE html>
<title> @yield('title') Trang Sản Phẩm</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css-style/style-san-pham.css')}}">
@extends('layout_master')

<!-- phần body -->
    @section('content')
        <div id="body-san-pham">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h4>Tìm kiếm theo</h4>
                        <div id=loc-san-pham>
                            <form action="" method="get">
                                <h4>Lọc Giá Sản Phẩm</h4>
                                @foreach($mingia as $item )
                                    @php $min = $item->price @endphp
                                @endforeach
                                @foreach($maxgia as $item )
                                    @php $max = $item->price @endphp
                                @endforeach
                                @if(empty($_GET['gia']))
                                    <input name="gia" id="slide" type="range" min="{{$min}}" max="{{$max}}"
                                           value="0"
                                           oninput="displayValue(event)"/>
                                @endif
                                @if(!empty($_GET['gia']))
                                    <input name="gia" id="slide" type="range" min="{{$min}}" max="{{$max}}"
                                           value="{{$_GET['gia']}}"
                                           oninput="displayValue(event)"/>
                                @endif

                                <span id="val"></span>
                                <br><br>
                                <div id="gia">Giá :
                                    <b>
                                    @php
                                        if(!empty($_GET['gia'])){
                                            if ($_GET['gia'] == $min){
                                             echo number_format($min).'đ';
                                            }
                                            elseif ($_GET['gia'] <= $min*2){
                                             echo ' từ '.number_format($min).'đ đến '.number_format($min*2).' đ';
                                            }
                                             elseif ($_GET['gia'] <= $min*3){
                                             echo ' từ '.number_format($min*2).'đ đến '.number_format($min*3).' đ';
                                            }
                                            elseif ($_GET['gia'] <= $max){
                                             echo ' từ '.number_format($min*3).'đ đến '.number_format($max).' đ';
                                            }
                                        }
                                    @endphp
                                    </b>
                                </div>
                                <input id="loc" type="submit" value="LỌC">
                            </form>
                        </div>

                        <div id="san-pham-da-xem">
                            <h4>Sản phẩm đã xem</h4>
                            @php
                            foreach ($allsp as $sp) {
                                foreach ($_COOKIE as $k => $v) {
                                    if (is_numeric($k)) {
                                        if ($sp->id == $k) {
                                            echo '<a style="color:white" href="'.route('route_chi_tiet').'?id='.$sp->id.'">';
                                                echo '<div id="sp-da-xem">';
                                                    echo '<img src="'.asset('/storage/'.$sp->image).'">';
                                                    echo '<span>'.$sp->name.'</span>';
                                                    if($sp->id_sale == 1){
                                                        echo'<span href="">'.number_format($sp->price).'đ</span>';
                                                        echo'<span style="text-decoration:line-through;color:black;" href="">0 đ</span>';
                                                    }
                                                    if($sp->id_sale != 1){
                                                        echo'<span style="text-decoration:line-through; color:black;" href="">'.($sp->price).' <u>đ</u></span>';

                                                        $price_sale = $sp->price*($sp->sale_phan_tram/100);
                                                        $price_sale = $sp->price - $price_sale;
                                                        echo'<a style="color:  #ed1b24;" href="">'.($price_sale).'<u>đ</u></a>';


                                                    echo '<div id="layer_sale" >';
                                                        echo'<div id="sale">';
                                                            echo'<span id="nb_sale">'.$sp->sale_phan_tram.'%</span>';
                                                        echo '</div>';
                                                    echo'</div>';
                                                    }
                                                echo '</div>';
                                            echo '</a>';
                                        }
                                    }
                                }
                            }
                            @endphp
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            @php
                                if(!empty($_GET['gia'])){
                                    if ($_GET['gia'] <= $min){
                                        foreach ($allsp as $sp){
                                            if ($sp->price <= $min){
                                            echo '<div class="col-6 col-md-4">';
                                                echo '<div id="san-pham">';
                                                    echo'<img class="col-12 col-md-12"
                                                         src="'.asset('/storage/'.$sp->image).'">';
                                                    echo'<li><a href="">'.$sp->name.'</a></li>';
                                                    if($sp->id_sale == 1){
                                                        echo'<li><a href="">'.number_format($sp->price).'đ</a></li>';
                                                        echo'<li style="text-decoration:line-through;"><span href="">0 đ</span></li>';
                                                    }
                                                    if($sp->id_sale != 1){
                                                    echo '<li style="text-decoration:line-through;">';
                                                        echo'<a href="">'.($sp->price).' <u>đ</u></a>';
                                                    echo '</li>';

                                                    $price_sale = $sp->price*($sp->sale_phan_tram/100);
                                                    $price_sale = $sp->price - $price_sale;

                                                    echo'<li style="font-weight: bold;">';
                                                        echo'<a style="color:  #ed1b24;" href="">'.($price_sale).'<u>đ</u></a>';
                                                    echo'</li>';

                                                    echo '<div id="layer_sale">';
                                                        echo'<div id="sale">';
                                                            echo'<span id="nb_sale">'.$sp->sale_phan_tram.'%</span>';
                                                        echo '</div>';
                                                    echo'</div>';
                                                    }
                                                    echo'<a href="'.route('route_chi_tiet').'?id='.$sp->id.'" >
                                                    <input type="button" name="" value="MUA"></a>';
                                                echo'</div>';
                                            echo'</div>';
                                            }
                                        }
                                    }
                                    elseif ($_GET['gia'] <= $min*2){
                                     foreach ($allsp as $sp){
                                            if ($min <= $sp->price){
                                            if ($sp->price <= $min*2){
                                            echo '<div class="col-6 col-md-4">';
                                                echo '<div id="san-pham">';
                                                    echo'<img class="col-12 col-md-12"
                                                         src="'.asset('/storage/'.$sp->image).'">';
                                                    echo'<li><a href="">'.$sp->name.'</a></li>';
                                                    if($sp->id_sale == 1){
                                                        echo'<li><a href="">'.number_format($sp->price).'đ</a></li>';
                                                        echo'<li style="text-decoration:line-through;"><span href="">0 đ</span></li>';
                                                    }
                                                    if($sp->id_sale != 1){
                                                    echo '<li style="text-decoration:line-through;">';
                                                        echo'<a href="">'.($sp->price).' <u>đ</u></a>';
                                                    echo '</li>';

                                                    $price_sale = $sp->price*($sp->sale_phan_tram/100);
                                                    $price_sale = $sp->price - $price_sale;

                                                    echo'<li style="font-weight: bold;">';
                                                        echo'<a style="color:  #ed1b24;" href="">'.($price_sale).'<u>đ</u></a>';
                                                    echo'</li>';

                                                    echo '<div id="layer_sale">';
                                                        echo'<div id="sale">';
                                                            echo'<span id="nb_sale">'.$sp->sale_phan_tram.'%</span>';
                                                        echo '</div>';
                                                    echo'</div>';
                                                    }
                                                    echo'<a href="'.route('route_chi_tiet').'?id='.$sp->id.'" >
                                                    <input type="button" name="" value="MUA"></a>';
                                                echo'</div>';
                                            echo'</div>';
                                            }
                                            }
                                        }
                                    }
                                    elseif ($_GET['gia'] <= $min*3){
                                     foreach ($allsp as $sp){
                                            if ($min*2 <= $sp->price){
                                            if ($sp->price <=  $min*3){
                                            echo '<div class="col-6 col-md-4">';
                                                echo '<div id="san-pham">';
                                                    echo'<img class="col-12 col-md-12"
                                                         src="'.asset('/storage/'.$sp->image).'">';
                                                    echo'<li><a href="">'.$sp->name.'</a></li>';
                                                    if($sp->id_sale == 1){
                                                        echo'<li><a href="">'.number_format($sp->price).'đ</a></li>';
                                                        echo'<li style="text-decoration:line-through;"><span href="">0 đ</span></li>';
                                                    }
                                                    if($sp->id_sale != 1){
                                                    echo '<li style="text-decoration:line-through;">';
                                                        echo'<a href="">'.($sp->price).' <u>đ</u></a>';
                                                    echo '</li>';

                                                    $price_sale = $sp->price*($sp->sale_phan_tram/100);
                                                    $price_sale = $sp->price - $price_sale;

                                                    echo'<li style="font-weight: bold;">';
                                                        echo'<a style="color:  #ed1b24;" href="">'.($price_sale).'<u>đ</u></a>';
                                                    echo'</li>';

                                                    echo '<div id="layer_sale">';
                                                        echo'<div id="sale">';
                                                            echo'<span id="nb_sale">'.$sp->sale_phan_tram.'%</span>';
                                                        echo '</div>';
                                                    echo'</div>';
                                                    }
                                                    echo'<a href="'.route('route_chi_tiet').'?id='.$sp->id.'" >
                                                    <input type="button" name="" value="MUA"></a>';
                                                echo'</div>';
                                            echo'</div>';
                                            }
                                            }
                                        }
                                    }



                                    elseif ($_GET['gia'] <= $max){
                                     foreach ($allsp as $sp){
                                            if ($max <= $sp->price){
                                            if ($sp->price <= $max){
                                            echo '<div class="col-6 col-md-4">';
                                                echo '<div id="san-pham">';
                                                    echo'<img class="col-12 col-md-12"
                                                         src="'.asset('/storage/'.$sp->image).'">';
                                                    echo'<li><a href="">'.$sp->name.'</a></li>';
                                                    if($sp->id_sale == 1){
                                                        echo'<li><a href="">'.number_format($sp->price).'đ</a></li>';
                                                        echo'<li style="text-decoration:line-through;"><span href="">0 đ</span></li>';
                                                    }
                                                    if($sp->id_sale != 1){
                                                    echo '<li style="text-decoration:line-through;">';
                                                        echo'<a href="">'.($sp->price).' <u>đ</u></a>';
                                                    echo '</li>';

                                                    $price_sale = $sp->price*($sp->sale_phan_tram/100);
                                                    $price_sale = $sp->price - $price_sale;

                                                    echo'<li style="font-weight: bold;">';
                                                        echo'<a style="color:  #ed1b24;" href="">'.($price_sale).'<u>đ</u></a>';
                                                    echo'</li>';

                                                    echo '<div id="layer_sale">';
                                                        echo'<div id="sale">';
                                                            echo'<span id="nb_sale">'.$sp->sale_phan_tram.'%</span>';
                                                        echo '</div>';
                                                    echo'</div>';
                                                    }
                                                    echo'<a href="'.route('route_chi_tiet').'?id='.$sp->id.'" >
                                                    <input type="button" name="" value="MUA"></a>';
                                                echo'</div>';
                                            echo'</div>';
                                            }
                                            }
                                        }
                                    }
                                }
                            @endphp
                            @if(empty($_GET['gia']))
                                @foreach($list as $sp)
                                    <div class="col-6 col-md-4">
                                        <div id="san-pham">
                                            @if(isset($sp->id_trang_thai))
                                                <img class="col-12 col-md-12"
                                                     src="{{asset('/storage/'.$sp->image)}}">
                                                <li><a href="">{{$sp->name}}</a></li>
                                                <li><a href="">{{number_format($item->price)}} <u>đ</u></a></li>
                                                <a href="{{route('route_chi_tiet_kg')}}?id={{$sp->id}}">
                                                    <input type="button" name="" value="MUA">
                                                </a>


                                            @elseif(!isset($sp->id_trang_thai))
                                                <img class="col-12 col-md-12"
                                                     src="{{asset('/storage/'.$sp->image)}}">
                                                <li><a href="">{{$sp->name}}</a></li>
                                                @if($sp->id_sale != 1)
                                                    <li style="text-decoration:line-through;">
                                                        <a href="">{{number_format($item->price)}} <u>đ</u></a>
                                                    </li>
                                                    <?php
                                                    $price_sale = $sp->price*($sp->sale_phan_tram/100);
                                                    $price_sale = $sp->price - $price_sale;
                                                    ?>
                                                    <li style="font-weight: bold;">
                                                        <a style="color:  #ed1b24;" href="">{{number_format($price_sale)}} <u>đ</u></a>
                                                    </li>
                                                @elseif($sp->id_sale == 1)
                                                    <li><a href="">{{number_format($item->price)}} <u>đ</u></a></li>
                                                    <li><a style="text-decoration:line-through;" href="">0 <u>đ</u></a></li>
                                                @endif
                                                <a href="{{route('route_chi_tiet')}}?id={{$sp->id}}">
                                                    <input type="button" name="" value="MUA">
                                                </a>
                                                @if($sp->id_sale != 1)
                                                    <div id="layer_sale">
                                                        <div id="sale">
                                                            <span id="nb_sale">{{$sp->sale_phan_tram}}%</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                        </div>
                        <div id="chuyen-trang" class="row">
                            {{ $list->appends(['minid' => 6, 'maxid' => 10])->links() }}
                        </div>
                                @endif

                    </div>
                </div>
            </div>
        </div>
        @php
            if (!empty($_GET['id'])){
                $cookie_name = $_GET['id'];
                $cookie_value = "id";
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

            }
        @endphp



<script type="text/javascript">
    const span = document.querySelector('#val');
    const slide = document.querySelector('#slide');

    displayValue.call(slide, {});

    function displayValue(e) {
        const inp = e.target || this;
        const value = +inp.value;
        const min = inp.min;
        const max = inp.max;
        const width = inp.offsetWidth;
        const offset = -20;
        const percent = (value - min) / (max - min);
        const pos = percent * (width + offset) - 40;
        span.style.left = `${pos}px`;
        span.innerHTML = value;
    }

    function changeLimits() {
        const minVal = +min.value;
        const maxVal = +max.value;
        const value = (maxVal - minVal) * (Math.random() * (0.8 - 0.2) + 0.2) + minVal;
        slide.setAttribute('min', minVal);
        slide.setAttribute('max', maxVal);
        slide.setAttribute('value', value);
        displayValue.call(slide, {});
    }

    function checkPostiveInteger(e) {
        let c = e.keyCode;
        if ((c < 37 && c != 8 && c != 9) || (c > 40 && c < 48 && c != 46) || (c > 57 && c < 96) || (c > 105 && c != 109 && c != 189)) {
            e.preventDefault();
        }
        if (c === 13 && checkValidLimits()) {
            changeLimits();
        }
    }

    function checkValidLimits() {
        return (!min.value || !max.value || +max.value <= +min.value) ? (button.disabled = true, false) : (button.disabled = false, true);
    }
</script>
@endsection


