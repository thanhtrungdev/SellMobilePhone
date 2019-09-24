<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phone Store</title>

    <!-- Google Fonts -->
    {{--<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet'
          type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>--}}

    <base href="{{asset('')}}">
    <!-- Bootstrap -->
    {{--<link rel="stylesheet" href="css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

    <!-- Font Awesome -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">--}}
    {{--<link rel="stylesheet" href="css/font-awesome.min.css">--}}
    {{--<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/font-awesome-4.7.0.min.css')}}">

    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>

    <!-- Custom CSS -->
    {{--<link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">--}}
    <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        $("document").ready(function(){
            $(function() {
                const url = window.location.href;

                //js: url.split("/").pop();
                //php: end(explode('/', url))

                $('div.navbar-collapse ul li a').each(function() {
                    // checks if its the same on the address bar
                    if(url == (this.href)) {
                        $(this).closest("li").addClass("active");
                    }
                });
                $('div.navbar-collapse div div a').each(function() {
                    // checks if its the same on the address bar
                    if(url == (this.href)) {
                        $('div.nav.cart-info').addClass("active");
                        //<div class="nav cart-info">
                    }
                });



            });

        });
    </script>
</head>
<body>

<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="user-menu">
                    <ul>
                        <li><a href="#"><i class="fa fa-map-marker"></i>Đà Nẵng, Việt Nam</a></li>
                        <li><a href="mailto:support@phonestore.com"><i class="fa fa-envelope"></i>support@phonestore.com</a>
                        </li>
                        <li><a href="tel:1800 6601"><i class="fa fa-phone"></i>Tư vẫn miễn phí: 1800 6601</a></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="header-right">
                    <ul class="list-unstyled list-inline">
                        @if(Session::get('user') === null)
                        <li><a href="{{route('form-login')}}">Đăng Nhập <i class="fa fa-lock"></i></a></li>
                        <li><a href="{{route('form-register')}}">Đăng Ký <i class="fa fa-user"></i></a></li>
                        @else
                            <li><a href="{{route('order-history')}}">Lịch sử đặt hàng <i class="fa fa-list"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End header area -->

<div class="site-branding-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 logo">
                <a href="{{route('homepage')}}"><img src="img/logo.png"></a>
            </div>
            <div class="col-sm-8 form_search">
                <form action="{{route('search')}}" method="get" id="search_form">
                    {{--<select class="search_phone">
                        <option>-- Chọn hãng điện thoại --</option>
                        @foreach($listBrand as $brand)
                            @if($brand->name == 'N/A')
                                <option>{{'Phụ kiện'}}</option>
                            @else
                                <option>{{$brand->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select class="search_price">
                        <option>-- Mức giá --</option>
                        <option>Dưới 1 triệu</option>
                        <option>Từ 1 triệu đến 3 triệu</option>
                        <option>Từ 3 triệu đến 7 triệu</option>
                        <option>Từ 7 triệu đến 10 triệu</option>
                        <option>Trên 10 triệu</option>
                    </select>--}}
                    <input type="text" name="q" value="{{\Request::get('q')}}"
                           placeholder="Nhập tên sản phẩm hoặc mức giá bạn muốn tìm ..." autofocus>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div> <!-- End site branding area -->

<div id="back-to-top">
    <a href="#"><i class="fa fa-arrow-circle-up"></i></a>
</div>

<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class=""><a href="{{route('homepage')}}">Home</a></li>
                    @foreach($listBrand as $brand)
                        @if($brand->name != 'N/A')
                            <li>
                                <a class="phone-{{$brand->name}}" href="{{route('list-product-of-brand', strtolower($brand->name))}}">
                                    {{strtolower($brand->name)}}
                                </a>
                            </li>
                        @endif
                    @endforeach
                    <li><a class="accessories" href="{{route('list-accessories')}}">Phụ Kiện</a></li>
                </ul>
                <div class="nav cart-info">
                    <div class="cart-info-count">
                        <a href="{{route('view-cart')}}">
                            {{(Session::has('cart') ? sizeof(Session::get('cart')->items) : 0) . ' sản phẩm'}}
                        </a>
                    </div>
                    <div class="cart-info-icon"><i class="fa fa-shopping-cart"></i></div>
                    <div class="cart-info-value">
                        <a href="{{route('view-cart')}}">
                            <?php
                            echo (Session::has('cart') ? number_format((float)(Session::get('cart')->totalPrice), 2, ",", ".") : 0) . '<sup>₫</sup>';
                            ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End mainmenu area -->

<style>
    .alert-success {text-align: center; font-size: 30px;}
    .alert-success strong{color: darkorange;}
    .alert-success .btnCloseMessage {color: black; margin-left: 20px;}
    .alert-success .btnCloseMessage:hover {color: red; cursor: pointer; transition: 0.3s;}

    .alert-info {position:fixed; right: 0; text-align: center; font-size: 30px; z-index: 9999; display: none;}
    .alert-info strong{color: darkorange; margin-right: 20px;}
    .alert-info .btnCloseMessage {color: black; float: right;}
    .alert-info .btnCloseMessage:hover {color: red; cursor: pointer; transition: 0.3s;}
</style>
@if(session('success'))
    <div class="alert alert-success">
        <strong>{{session('success')}}</strong>
        <span class="btnCloseMessage" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
@endif

@if(session('notify'))
    <div class="alert alert-success">
        <strong>{{session('notify')}}</strong>
        <span class="btnCloseMessage" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
@endif

@if($errors->has('message') || $errors->has('user_email'))
    <script>
        $(document).ready(function () {
            $("html, body").animate({ scrollTop: $(document).height()-$(window).height()});
        });
    </script>
@endif

<div class="alert alert-info" >
    <strong></strong>
    <span class="btnCloseMessage" {{--onclick="this.parentElement.style.display='none';"--}}>&times;</span>
</div>

{{--<script>
    $(document).ready(function () {
        $('div.alert-info span').click(function (e) {
            e.preventDefault();
            $('div.alert-info').fadeOut('slow');
        });
        setTimeout(function () {
            $('div.alert-info').fadeOut('slow');
        }, 1500);
    });
</script>--}}
