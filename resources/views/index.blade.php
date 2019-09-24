@extends('layouts.template')

@section('content')
    @include ('layouts.slider')

    {{--<script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>--}}
    {{--<script src="{{asset('js/add-to-cart.js')}}"></script>--}}
    <script>
        $(document).ready(function () {
            @foreach($listAllProduct as $product)
            $("button#btnAddToCart{{$product->id}}").click(function (e) {
                e.preventDefault();
                //alert('Its working!');
                var product_id = "{{$product->id}}";
                var url = "{{route('add-product-to-cart', $product->id)}}";
                //alert(product_id);
                //console.log(url);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    cache: false,
                    url: url,
                    data: {product_id: product_id},
                    dataType: "json",
                    success: function (data) {
                        //console.log(data);
                        //console.log((data.num_price_product).length);
                        //console.log(data.num_price_product[0]);
                        //console.log(data.num_price_product[1]);

                        if (data.message == 'The product already exists!') {
                            //alert('Sản phẩm đã có trong giỏ hàng!');
                            $('div.alert-info').css('display', 'block');
                            $('div.alert-info strong').html('Đã có trong giỏ hàng!');

                            $('div.brand{{$product->brand_id}} span').html(' Đã có trong giỏ hàng!').delay(2000).fadeOut('slow');
                            setTimeout(function () {
                                $('div.brand{{$product->brand_id}} span').html('').fadeIn()
                            }, 2500);
                        } else {
                            //alert('Đã thêm vào giỏ hàng!');
                            //console.log(num, pay);
                            //console.log(data);
                            $('div.alert-info').css('display', 'block');
                            $('div.alert-info strong').html('Đã thêm vào giỏ hàng!');

                            var num = data.num_price_product[0];
                            var pay = data.num_price_product[1];

                            $('div.cart-info-count a').html(num + ' sản phẩm');
                            $('div.cart-info-value a').html(
                                pay.toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                            );
                            $('div.brand{{$product->brand_id}} span').html(' Đã thêm vào giỏ hàng!').delay(2000).fadeOut('slow');
                            setTimeout(function () {
                                $('div.brand{{$product->brand_id}} span').html('').fadeIn()
                            }, 2500);
                        }

                        $('div.alert-info span').click(function (e) {
                            e.preventDefault();
                            $('div.alert-info').fadeOut('slow');
                        });

                        setTimeout(function () {
                            $('div.alert-info').fadeOut('slow');
                        }, 1500);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
            @endforeach

        });
    </script>

    <div class="promo-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo1">
                        <i class="fa fa-refresh"></i>
                        <p>30 ngày đổi trả</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo2">
                        <i class="fa fa-truck"></i>
                        <p>Phí giao hàng rẻ</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo3">
                        <i class="fa fa-lock"></i>
                        <p>Bảo mật thông tin</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="single-promo promo4">
                        <i class="fa fa-gift"></i>
                        <p>Nhiều sản phẩm mới</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End promo area -->

    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @foreach($listProduct as $listProductOfBrand)
                        <div class="latest-product">
                            {{--<h2 class="section-title">ĐiệnThoại</h2>--}}
                            @foreach($listBrand as $brand)
                                @foreach($listProductOfBrand as $product)
                                    @if($brand->id == $product->brand_id)
                                        @if($brand->name == 'N/A')
                                            <div class="brand-name {{'brand'.$product->brand_id}}">
                                                <h2>{{'Phụ Kiện'}}<span style="color: orangered"></span></h2>
                                            </div>
                                        @else
                                            <div class="brand-name {{'brand'.$product->brand_id}}">
                                                <h2>{{$brand->name}}<span style="color: orangered"></span></h2>
                                            </div>
                                        @endif
                                    @endif
                                    @break
                                @endforeach
                            @endforeach
                            {{--<dialog id="dialog-message" title="Thông báo">This is an open dialog window</dialog>--}}

                            <div class="product-carousel">
                                @foreach($listProductOfBrand as $product)
                                    <div class="single-product">
                                        {{--<input type="text" id="brand_id" value="{{$product->brand_id}}">
                                        <input type="text" id="product_id" value="{{$product->id}}">--}}
                                        <div class="cart-message"><p></p></div>
                                        <div class="product-f-image">
                                            <div>
                                                {{--<img src="{{asset($images[array_rand($images,1)])}}" alt="{{$product->name}}">--}}
                                                <img
                                                    src="{{$imagesProduct[($product->brand_id)][array_rand($imagesProduct[($product->brand_id)], 1)]}}"
                                                    alt="{{$product->name}}">
                                            </div>
                                            <div class="product-hover">
                                                <button class="btn-add-to-cart" id="btnAddToCart{{$product->id}}">
                                                    <i class="fa fa-shopping-cart"> Thêm vào giỏ hàng</i>
                                                </button>
                                                {{--<a href="{{route('add-product-to-cart', $product->id)}}" class="add-to-cart-link">
                                                    <i class="fa fa-shopping-cart"> Add to cart</i>
                                                </a>--}}
                                                <a href="{{route('product-detail', $product->id)}}"
                                                   class="view-details-link">
                                                    <i class="fa fa-link"> Xem chi tiết</i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-name">
                                            <h2>
                                                <a href="{{route('product-detail', $product->id)}}">{{$product->name}}</a>
                                            </h2>
                                        </div>

                                        <div class="product-carousel-price">
                                            <span
                                                style="color: red;">{{'(-'. ($product->discount_percent * 100) . '%)'}}</span>
                                            <ins>{{number_format((float)$product->current_price - ($product->current_price * $product->discount_percent), 2,",", ".") . ' VNĐ'}}</ins>
                                            <br>
                                            <del>{{number_format((float)$product->current_price,2,",", ".") . ' VNĐ'}}</del>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->

    <div class="brands-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-wrapper">
                        <div class="brand-list">
                            @for($i=1; $i<=4; $i++)
                                <img src="img/brands/brand{{$i}}.png" alt="">
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End brand area -->

    <div class="product-widget-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <div style="text-align: center"><h2 class="product-wid-title">Sản phẩm mới</h2></div>
                        @if($topNewProducts->isEmpty())
                            <div style="text-align: center">
                                <p style="color: green; font-size: 30px;">Đang cập nhật dữ liệu</p>
                            </div>
                        @else
                            @foreach($topNewProducts as $newP)
                                <div class="single-wid-product">
                                    <div style="position: relative">
                                        <a href="product/{{$newP->id}}">
                                            <img src="img/product-thumb-2.jpg" alt="{{$newP->name}}" class="product-thumb">
                                        </a>
                                        <h2><a href="product/{{$newP->id}}">{{$newP->name}}</a></h2>
                                        <div class="product-wid-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <button type="submit" class="btn-add-to-cart" id="btnAddToCart{{$newP->id}}"
                                                style="position: absolute; top: 0; right: 0;">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                    <div class="product-wid-price">
                                        <span style="color: red;">{{'(-'. ($newP->discount_percent * 100) . '%)'}}</span>
                                        <ins>{{number_format((float)$newP->current_price - ($newP->current_price * $newP->discount_percent), 2,",", ".") . ' VNĐ'}}</ins>
                                        <del>{{number_format((float)$newP->current_price,2,",", ".") . ' VNĐ'}}</del>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="single-product-widget">
                        <div style="text-align: center"><h2 class="product-wid-title">Bán chạy nhất</h2></div>
                        @if($topSellProduct==[])
                            <div style="text-align: center">
                                <p style="color: green; font-size: 30px;">Đang cập nhật dữ liệu</p>
                            </div>
                        @else
                            @foreach ($topSellProduct as $listP)
                                {{--@foreach ($listP as $sellP)--}}
                                <div class="single-wid-product">
                                    <div style="position: relative">
                                        <a href="product/{{$listP->id}}"><img src="img/product-thumb-1.jpg" alt="{{$listP->name}}"
                                                                   class="product-thumb"></a>
                                        <h2><a href="product/{{$listP->id}}">{{$listP->name}}</a></h2>
                                        <div class="product-wid-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <button type="submit" class="btn-add-to-cart" id="btnAddToCart{{$listP->id}}"
                                                style="position: absolute; top: 0; right: 0;">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                    <div class="product-wid-price">
                                        <span style="color: red;">{{'(-'. ($listP->discount_percent * 100) . '%)'}}</span>
                                        <ins>{{number_format((float)$listP->current_price - ($listP->current_price * $listP->discount_percent), 2,",", ".") . ' VNĐ'}}</ins>
                                        <del>{{number_format((float)$listP->current_price,2,",", ".") . ' VNĐ'}}</del>
                                    </div>
                                </div>
                                {{--@endforeach--}}
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="single-product-widget">
                        <div style="text-align: center"><h2 class="product-wid-title">Siêu giảm giá</h2></div>
                        @if($topSaleProducts->isEmpty())
                            <div style="text-align: center">
                                <p style="color: green; font-size: 30px;">Đang cập nhật dữ liệu</p>
                            </div>
                        @else
                            @foreach($topSaleProducts as $saleP)
                                <div class="single-wid-product">
                                    <div style="position: relative">
                                        <a href="product/{{$saleP->id}}"><img src="img/product-thumb-4.jpg" alt="{{$saleP->name}}"
                                                                   class="product-thumb"></a>
                                        <h2><a href="product/{{$saleP->id}}">{{$saleP->name}}</a></h2>
                                        <div class="product-wid-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <button type="submit" class="btn-add-to-cart" id="btnAddToCart{{$saleP->id}}"
                                                style="position: absolute; top: 0; right: 0;">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                    <div class="product-wid-price">
                                        <span style="color: red;">{{'(-'. ($saleP->discount_percent * 100) . '%)'}}</span>
                                        <ins>{{number_format((float)$saleP->current_price - ($saleP->current_price * $saleP->discount_percent), 2,",", ".") . ' VNĐ'}}</ins>
                                        <del>{{number_format((float)$saleP->current_price,2,",", ".") . ' VNĐ'}}</del>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End product widget area -->
@endsection
