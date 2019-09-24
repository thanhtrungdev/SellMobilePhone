@extends('layouts.template')

@section('content')
    <script>
        $("document").ready(function(){
            const url = window.location.href;

            @foreach($listAllProduct as $product)
            if("{{$product->id }}" == url.split("/").pop()) {
                if("{{$product->category_id}}" == 1) {
                    @foreach($listBrand as $brand)
                        @if($product->brand_id == $brand->id)
                            $('div.navbar-collapse ul li a.phone-{{$brand->name}}').closest("li").addClass("active");
                            {{--alert("{{$brand->name}}");--}}
                        @endif
                    @endforeach
                }else {
                    $('div.navbar-collapse ul li a.accessories').closest("li").addClass("active");
                }
            }
            //js: url.split("/").pop();
            //php: end(explode('/', url))
            @endforeach

        });
    </script>

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
                        } else {
                            //alert('Đã thêm vào giỏ hàng!');
                            $('div.alert-info').css('display', 'block');
                            $('div.alert-info strong').html('Đã thêm vào giỏ hàng!');

                            var num = data.num_price_product[0];
                            var pay = data.num_price_product[1];

                            $('div.cart-info-count a').html(num + ' sản phẩm');
                            $('div.cart-info-value a').html(
                                pay.toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                            );
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

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            {{--<div class="product-breadcroumb">
                <a href="">Home</a>
                <a href="">Category Name</a>
            </div>--}}

            <div class="row">
                <div class="col-md-4">
                    <h2 class="product-name">{{$prd->name}}</h2>
                    <div class="product-images">
                        <div class="product-main-img">
                            <img src="img/product-2.jpg" alt="">
                        </div>

                        <div class="product-gallery">
                            <img src="img/product-thumb-1.jpg" alt="">
                            <img src="img/product-thumb-2.jpg" alt="">
                            <img src="img/product-thumb-3.jpg" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-md-4" style="position: relative;">
                    <div class="rating-wrap-post">
                        <i class="fa fa-star" style="color: #ffc808"></i>
                        <i class="fa fa-star" style="color: #ffc808"></i>
                        <i class="fa fa-star" style="color: #ffc808"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="product-inner-price" style="margin-top: 10px;">
                        <span style="color: red;">{{'(-'. ($prd->discount_percent * 100) . '%)'}}</span>
                        <ins>{{number_format((float)($prd->current_price - ($prd->current_price * $prd->discount_percent)),2,",", ".") .' VNĐ'}}</ins>
                        <del>{{number_format((float)$prd->current_price,2,",", ".") . ' VNĐ'}}</del>
                    </div>
                    <button type="submit" class="btn-add-to-cart" id="btnAddToCart{{$prd->id}}"
                            style="margin-bottom: 25px;">
                        <i class="fa fa-shopping-cart"> Thêm vào giỏ hàng</i>
                    </button>
                    <div class="product-inner">
                        <h3>Thông số kỹ thuật</h3>
                        <p>{{$prd->description}}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <h3>Bình Luận</h3>
                    <div class="submit-review">
                        <h4><b>Full Name</b>
                            (Đánh giá:
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>)
                        </h4>
                        <div>
                            <p>jbdsvjnsd ffnsdm,f sbb vjksdb mbssd csdcnkvsd
                                asknksdsmd,nkdsncascjvbdvsdnv
                                ạdvbnkl</p>
                        </div>
                        <h4><b>Full Name</b>
                            (Đánh giá:
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>)
                        </h4>
                        <div>
                            <p>jbdsvjnsd ffnsdm,f sbb vjksdb mbssd csdcnkvsd
                                asknksdsmd,nkdsncascjvbdvsdnv
                                ạdvbnkl</p>
                        </div>
                        <h4><b>Full Name</b>
                            (Đánh giá:
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i class="fa fa-star"></i>)
                        </h4>
                        <div>
                            <p>jbdsvjnsd ffnsdm,f sbb vjksdb mbssd csdcnkvsd
                                asknksdsmd,nkdsncascjvbdvsdnv
                                ạdvbnkl</p>
                        </div>

                    </div>
                    <hr>
                    <form class="submit-review">
                        <div class="rating-post">
                            <span>Đánh giá của bạn:</span>
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i  style="color: #ffc808" class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <textarea name="review" id="" cols="30" rows="10" placeholder="Bình luận về sản phẩm"></textarea>
                        <input type="submit" value="Bình luận">
                    </form>
                </div>
            </div>

            <div role="tabpanel">
                <ul class="product-tab" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#same-price" aria-controls="same-price" role="tab" data-toggle="tab">
                            @if(isset($listAccessoriesSamePrice))
                            Phụ kiện cùng mức giá
                            @else
                            Điện thoại cùng mức giá
                            @endif
                        </a>
                    </li>
                    @if(!isset($listAccessoriesSamePrice))
                    <li role="presentation">
                        <a href="#same-brand" aria-controls="same-brand" role="tab" data-toggle="tab">
                            @foreach($listBrand as $brand)
                                @if($prd->brand_id == $brand->id)
                                    Cùng hãng {{$brand->name}}
                                @endif
                            @endforeach
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="same-price">
                        @if(isset($listAccessoriesSamePrice) && sizeof($listAccessoriesSamePrice)!==0)
                            @foreach ($listAccessoriesSamePrice as $listAccessories)
                                <div class="row">
                                    @foreach($listAccessories as $accessories)
                                        <div class="col-md-4">
                                            <div class="single-sidebar">
                                                <div class="thubmnail-recent" style="position: relative;">
                                                    <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                                                    <h2><a href="product/{{$accessories->id}}">{{$accessories->name}}</a></h2>
                                                    <div class="product-sidebar-price">
                                                        <span style="color: red">(-{{$accessories->discount_percent * 100}}%)</span>
                                                        <ins>{{number_format((float)$accessories->current_price - ($accessories->current_price * $accessories->discount_percent),2,",", ".")}}<sup>₫</sup></ins>
                                                        <del>{{number_format((float)$accessories->current_price,2,",", ".")}}<sup>₫</sup></del>
                                                    </div>
                                                    <button id="btnAddToCart{{$accessories->id}}" class="add_to_cart_button" type="submit"
                                                            style="position: absolute; top: 5px; right: 0;">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif

                        {{-- other brand same price--}}
                        <div class="row">
                            @if(isset($listProductOfBrandSamePrice) && sizeof($listProductOfBrandSamePrice)!==0)
                                @foreach ($listProductOfBrandSamePrice as $brandName=>$productList)
                                    <div class="col-md-4">
                                        <div class="single-sidebar">
                                            <h3 class="sidebar-title text-center">{{$brandName}}</h3>
                                            @if (sizeof($productList) == 0)
                                                <div>Không có điện thoại  {{$brandName}}  nào phù hợp với mức giá này</div>
                                            @else
                                                @foreach($productList as $p)
                                                    <div class="thubmnail-recent" style="position: relative;">
                                                        <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                                                        <h2><a href="product/{{$p->id}}">{{$p->name}}</a></h2>
                                                        <div class="product-sidebar-price">
                                                            <span style="color: red">(-{{$p->discount_percent * 100}}%)</span>
                                                            <ins>{{number_format((float)$p->current_price - ($p->current_price * $p->discount_percent),2,",", ".")}}<sup>₫</sup></ins>
                                                            <del>{{number_format((float)$p->current_price,2,",", ".")}}<sup>₫</sup></del>
                                                        </div>
                                                        <button id="btnAddToCart{{$p->id}}" class="add_to_cart_button" type="submit"
                                                                style="position: absolute; top: 5px; right: 0;">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div> {{-- end other brand same price--}}
                    </div>

                    {{-- same brand--}}
                    <div role="tabpanel" class="tab-pane fade" id="same-brand">
                        @if(isset($listProduct) && sizeof($listProduct)!==0)
                            @foreach ($listProduct as $groupP)
                                <div class="row">
                                    @foreach($groupP as $product)
                                        <div class="col-md-4">
                                            <div class="single-sidebar">
                                                <div class="thubmnail-recent" style="position: relative;">
                                                    <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                                                    <h2><a href="product/{{$product->id}}">{{$product->name}}</a></h2>
                                                    <div class="product-sidebar-price">
                                                        <span style="color: red">(-{{$product->discount_percent * 100}}%)</span>
                                                        <ins>{{number_format((float)$product->current_price - ($product->current_price * $product->discount_percent),2,",", ".")}}<sup>₫</sup></ins>
                                                        <del>{{number_format((float)$product->current_price,2,",", ".")}}<sup>₫</sup></del>
                                                    </div>
                                                    <button id="btnAddToCart{{$product->id}}" class="add_to_cart_button" type="submit"
                                                            style="position: absolute; top: 5px; right: 0;">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div> {{-- end same brand--}}
                </div>
            </div>
        </div>
    </div>
@endsection
