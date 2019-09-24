@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            @foreach($listProduct as $product)
            $("button#btnAddToCart{{$product->id}}").click(function (e) {
                e.preventDefault();
                //alert('Its working!');
                var product_id = "{{$product->id}}";
                var url = "{{route('add-product-to-cart', $product->id)}}";

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
            <div class="row">
                @foreach($listProduct as $product)
                    <div class="col-md-3 col-sm-6">
                        <div class="single-shop-product">
                            <div class="product-upper">
                                <a href="{{route('product-detail', $product->id)}}">
                                    <img src="{{asset($images[array_rand($images,1)])}}" alt="{{$product->name}}">
                                </a>
                            </div>
                            <div class="product-name">
                                <h2><a href="{{route('product-detail', $product->id)}}">{{$product->name}}</a></h2>
                            </div>
                            <div class="product-carousel-price">
                                <span style="color: red;">{{'(-'. ($product->discount_percent * 100) . '%)'}}</span>
                                <ins>{{number_format((float)$product->current_price - ($product->current_price * $product->discount_percent), 2,",", ".") . ' VNĐ'}}</ins>
                                <br>
                                <del>{{number_format((float)$product->current_price,2,",", ".") . ' VNĐ'}}</del>
                            </div>

                            <div class="product-option-shop" style="text-align: center;">
                                {{--<a class="add_to_cart_button" href="{{route('add-product-to-cart', $product->id)}}">Add to cart</a>--}}
                                <button class="add_to_cart_button" id="btnAddToCart{{$product->id}}">
                                    <i class="fa fa-shopping-cart"> Thêm vào giỏ hàng</i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="text-align: center">
            {{ $listProduct->links()}}
            </div>

            {{--<div class="row">
                <div class="col-md-12">
                    <div class="product-pagination text-center">
                        <nav>
                            <ul class="pagination">
                                <li>
                                    <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li>
                                    <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
@endsection
