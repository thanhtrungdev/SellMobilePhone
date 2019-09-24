@extends('layouts.template')

@section('content')
    <script>
        function backToTop() {
            $("html, body").animate({scrollTop: 0}, 600);
            return false;
        }
    </script>

    <script>
        $(document).ready(function () {
            //alert('message');
            //$(".ship-check").click(function() { $(".input-receiver").attr("disabled", !this.checked); });

            if ($('.ship-check').is(':checked')) {
                //alert('Check');
                $('.input-receiver').prop("disabled", false);
                $('.input-receiver').val('');
                $('.user-hide').html('');

            }

            $('.ship-check').change(function () {
                if ($(this).is(':checked')) {
                    //alert('Check');
                    $('.input-receiver').prop("disabled", false);
                    $('.input-receiver').val('');
                    $('.user-hide').html('');

                } else {
                    //alert('Uncheck');
                    $('.input-receiver').prop("disabled", true);
                    $('.input-receiver').val('');
                    $('.user-hide').html(' (và nhận hàng)');
                    $('.input-user').prop("checked", true);
                    $('p.receiver-error-message').html('');
                }
                ;
            });
            // $('.user-name').change(function () { $('.receiver-name').val($(this).val()); });
            // $('.user-address').change(function () { $('.receiver-address').val($(this).val()); });
            // $('.user-phone').change(function () { $('.receiver-phone').val($(this).val()); });
            // $('.user-email').change(function () { $('.receiver-email').val($(this).val()); });

            //$(":input").inputmask();
            $("input.user-phone").inputmask();
            $("input.receiver-phone").inputmask();
            //$("input.input-qty").inputmask('Regex', { regex: "^[0-9]"});

        });
    </script>

    {{-- script edit quantity--}}
    <script>
        $(document).ready(function () {

            @if(Session::get('cart') != null)
            @foreach($getCart as $product_id => $v)
            @foreach($listProduct as $product)
            @if($product_id == $product->id)
            $("#btn-minus-{{$product_id}}").click(function (e) {
                e.preventDefault();

                if ($("#input-qty-{{$product_id}}").val() > 1) {
                    //alert('--');
                    //alert($("#input-qty-{{$product_id}}").val()-1);

                    var total = parseFloat($("span#cart-total").text().replace(/[.₫]/g, '').replace(',', '.'));
                    var discount = parseFloat($("span#cart-discount").text().replace(/[.₫]/g, '').replace(',', '.'));
                    /*var payment = parseFloat($("span#cart-payment").text().replace(/[.₫]/g,'').replace(',', '.'));
                    alert(payment);*/

                    var qty_old = $("#input-qty-{{$product_id}}").val();
                    var sub_discount_old = parseFloat($(".cart-sub-discount-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));

                    total -= qty_old * "{{$v['item']->current_price}}";
                    discount -= sub_discount_old;

                    $("#input-qty-{{$product_id}}").val($("#input-qty-{{$product_id}}").val() - 1);

                    var qty = $("#input-qty-{{$product_id}}").val();

                    total += qty * "{{$v['item']->current_price}}";

                    var cart_sub_discount = qty * ("{{$v['item']->current_price}}" * "{{$v['item']->discount_percent}}");
                    $(".cart-sub-discount-{{$product_id}}").html(
                        parseFloat(cart_sub_discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    var sub_discount = parseFloat($(".cart-sub-discount-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));

                    discount += sub_discount;

                    var cart_subtotal = qty * "{{$v['item']->current_price}}" - sub_discount;
                    $(".cart-subtotal-{{$product_id}}").html(
                        parseFloat(cart_subtotal).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    var subtotal = parseFloat($(".cart-subtotal-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));

                    $("span.discount-{{$product_id}}").html(
                        parseFloat(sub_discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $("span.subtotal-{{$product_id}}").html(
                        parseFloat(subtotal).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $(".cart-total span").html(
                        parseFloat(total).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $(".cart-discount span").html(
                        parseFloat(discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $(".cart-payment span").html(
                        parseFloat(total - discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $(".cart-info-value a").html(
                        parseFloat(total - discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                } else {
                    //alert('Số lượng tối thiểu bằng 1');

                    $('div.alert-info').css('display', 'block');
                    $('div.alert-info strong').html('Số lượng tối thiểu bằng 1');
                }
                $('div.alert-info span').click(function (e) {
                    e.preventDefault();
                    $('div.alert-info').fadeOut('slow');
                });

                setTimeout(function () {
                    $('div.alert-info').fadeOut('slow');
                }, 1500);
            });
            {{-- edit quantity (end minus function)--}}

            $("#btn-plus-{{$product_id}}").click(function (e) {
                e.preventDefault();
                //alert('++');
                //alert(+$("#input-qty-{{$product_id}}").val()+1);

                var currentQty = parseInt("{{$product->quantity}}");
                var inputQty = parseInt($("#input-qty-{{$product_id}}").val());

                if (currentQty > inputQty) {
                    var total = parseFloat($("span#cart-total").text().replace(/[.₫]/g, '').replace(',', '.'));
                    var discount = parseFloat($("span#cart-discount").text().replace(/[.₫]/g, '').replace(',', '.'));

                    var qty_old = $("#input-qty-{{$product_id}}").val();
                    var sub_discount_old = parseFloat($(".cart-sub-discount-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));

                    total -= qty_old * "{{$v['item']->current_price}}";
                    discount -= sub_discount_old;

                    $("#input-qty-{{$product_id}}").val(+$("#input-qty-{{$product_id}}").val() + 1);

                    var qty = $("#input-qty-{{$product_id}}").val();

                    total += qty * "{{$v['item']->current_price}}";

                    var cart_sub_discount = qty * ("{{$v['item']->current_price * $v['item']->discount_percent}}");
                    $(".cart-sub-discount-{{$product_id}}").html(
                        parseFloat(cart_sub_discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    var sub_discount = parseFloat($(".cart-sub-discount-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));

                    discount += sub_discount;

                    var cart_subtotal = qty * "{{$v['item']->current_price}}" - sub_discount;
                    $(".cart-subtotal-{{$product_id}}").html(
                        parseFloat(cart_subtotal).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    var subtotal = parseFloat($(".cart-subtotal-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));

                    $("span.discount-{{$product_id}}").html(
                        parseFloat(sub_discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $("span.subtotal-{{$product_id}}").html(
                        parseFloat(subtotal).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $(".cart-total span").html(
                        parseFloat(total).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $(".cart-discount span").html(
                        parseFloat(discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $(".cart-payment span").html(
                        parseFloat(total - discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                    $(".cart-info-value a").html(
                        parseFloat(total - discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                    );
                } else {
                    //alert('Mặt hàng này chỉ còn: ' + currentQty + ' cái.');

                    $('div.alert-info').css('display', 'block');
                    $('div.alert-info strong').html('Mặt hàng này chỉ còn: ' + currentQty + ' cái.');
                }

                $('div.alert-info span').click(function (e) {
                    e.preventDefault();
                    $('div.alert-info').fadeOut('slow');
                });

                setTimeout(function () {
                    $('div.alert-info').fadeOut('slow');
                }, 1500);
            });
            {{-- edit quantity (end plus function)--}}

            $("#input-qty-{{$product_id}}").focusin(function () {
                $(this).data('val', $(this).val());
            });
            $("#input-qty-{{$product_id}}").change(function () {
                if ($(this).val() == '') {
                    $('div.alert-info').css('display', 'block');
                    $('div.alert-info strong').html('Số lượng không được bỏ trống!');
                } else if (Number.isInteger($(this).val()) || $(this).val() < 1) {
                    $('div.alert-info').css('display', 'block');
                    $('div.alert-info strong').html('Số lượng phải là số nguyên dương!');
                } else {
                    var currentQty = parseInt("{{$product->quantity}}");
                    var inputQty = parseInt($("#input-qty-{{$product_id}}").val());

                    if (currentQty >= inputQty) {
                        $('.cart-notify').html('');

                        var discount = parseFloat($("span#cart-discount").text().replace(/[.₫]/g, '').replace(',', '.'));
                        var payment = parseFloat($("span#cart-payment").text().replace(/[.₫]/g, '').replace(',', '.'));

                        var sub_discount_old = parseFloat($(".cart-sub-discount-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));
                        var subtotal_old = parseFloat($(".cart-subtotal-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));
                        discount -= sub_discount_old;
                        payment -= subtotal_old; //gia tien khi chua co san pham $product_id

                        var qty = $("#input-qty-{{$product_id}}").val();

                        var cart_sub_discount = qty * ("{{$v['item']->current_price * $v['item']->discount_percent}}");
                        $(".cart-sub-discount-{{$product_id}}").html(
                            parseFloat(cart_sub_discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                        );
                        var sub_discount = parseFloat($(".cart-sub-discount-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));
                        discount += sub_discount;

                        var cart_subtotal_product = qty * "{{$v['item']->current_price}}" - sub_discount;
                        $(".cart-subtotal-{{$product_id}}").html(
                            parseFloat(cart_subtotal_product).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                        );
                        var subtotal = parseFloat($(".cart-subtotal-{{$product_id}}").text().replace(/[.₫]/g, '').replace(',', '.'));

                        payment += subtotal;

                        $("span.discount-{{$product_id}}").html(
                            parseFloat(sub_discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                        );
                        $("span.subtotal-{{$product_id}}").html(
                            parseFloat(subtotal).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                        );
                        $(".cart-total span").html(
                            parseFloat(payment + discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                        );
                        $(".cart-discount span").html(
                            parseFloat(discount).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                        );
                        $(".cart-payment span").html(
                            parseFloat(payment).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                        );
                        $(".cart-info-value a").html(
                            parseFloat(payment).toFixed(2).replace('.', ',').replace(/\d(?=(\d{3})+,)/g, '$&.') + '<sup>₫</sup>'
                        );
                    } else {
                        //alert('Mặt hàng này chỉ còn: ' + currentQty + ' cái.');

                        $('div.alert-info').css('display', 'block');
                        $('div.alert-info strong').html('Mặt hàng này chỉ còn: ' + currentQty + ' cái.');

                        //alert($(this).data('val'));
                        $(this).val($(this).data('val'));
                    }
                }

                $('div.alert-info span').click(function (e) {
                    e.preventDefault();
                    $('div.alert-info').fadeOut('slow');
                });

                setTimeout(function () {
                    $('div.alert-info').fadeOut('slow');
                }, 1500);
            });
            {{-- edit quantity (end change input function)--}}
            @endif
            @endforeach
            @endforeach
            @endif
        });
    </script> {{-- end script edit quantity--}}

    <script>
        function submitForm(action) {
            $('#cart-form').action = action;
            $('#cart-form').submit();
        }
    </script>

    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @if($errors != '[]')
                    <div id="show-me" class="collapse in">
                    @else
                    <div id="show-me" class="collapse">
                    @endif
                        <div style="text-align: right; margin-bottom: 10px;">
                            <button class="close-button button alt wc-forward" title="Đóng"
                                    data-toggle="collapse" href="#show-me"
                                    aria-expanded="false" aria-controls="show-me">
                                X
                            </button>
                            <p style="text-align: left; color: orangered;
                        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
                        font-size: 30px; font-weight: bold;"> Điền thông tin theo mẫu bên dưới để đặt
                                hàng! </p>
                        </div>
                        <form method="get" action="{{route('checkout')}}" class="user-order" id="order-form">
                            @csrf
                            {{--@method('PUT')--}}
                            @if(Session::get('user') === null)
                                <div class="col-md-6" class="user-info">
                                    <h3>Người đặt hàng<span class="user-hide"> (và nhận hàng)</span></h3>
                                    @if($errors->has('name'))
                                        <p class="user-error-message"
                                           style="color: red;">{{ $errors->first('name') }}</p>
                                    @endif
                                    <p><input class="input-user user-name" type="text" name="name"
                                              value="{{old('name')}}" placeholder="* Họ và tên">
                                    </p>

                                    @if($errors->has('address'))
                                        <p class="user-error-message"
                                           style="color: red;">{{ $errors->first('address') }}</p>
                                    @endif
                                    <p><input class="input-user user-address" type="text" name="address"
                                              value="{{old('address')}}" placeholder="* Địa chỉ (Từ số nhà, tên đường ... )">
                                    </p>

                                    @if($errors->has('phone'))
                                        <p class="user-error-message"
                                           style="color: red;">{{ $errors->first('phone') }}</p>
                                    @endif
                                    <p><input class="input-user user-phone" type="tel" name="phone"
                                              value="{{old('phone')}}" placeholder="* Số điện thoại"
                                              data-inputmask="'mask': '9999 999 999'">
                                    </p>

                                    @if($errors->has('email'))
                                        <p class="user-error-message"
                                           style="color: red;">{{ $errors->first('email') }}</p>
                                    @endif
                                    <p><input class="input-user user-email" type="text" name="email"
                                              value="{{old('email')}}" placeholder="Email"></p>
                                    <p>

                                        <label>
                                            <input id="user_pay" class="input-user" type="radio"
                                                   name="payment-check" value="user_pay" checked>
                                            Nhận hóa đơn và thanh toán
                                        </label>
                                    </p>
                                </div>
                            @else
                                <div class="col-md-6" class="user-info">
                                    <h3>Người đặt hàng<span class="user-hide"> (và nhận hàng)</span></h3>
                                    <p><input class="input-user user-name" type="text" name="name"
                                              value="{{Session::get('user')['user_name']}}"
                                              placeholder="* Họ và tên" readonly>
                                    </p>

                                    <p><input class="input-user user-address" type="text" name="address"
                                              value="{{Session::get('user')['user_address']}}"
                                              placeholder="* Địa chỉ  (Từ số nhà, tên đường ... )" readonly>
                                    </p>

                                    <p><input class="input-user user-phone" type="text" name="phone"
                                              value="{{Session::get('user')['user_phone']}}"
                                              placeholder="* Số điện thoại"
                                              data-inputmask="'mask': '9999 999 999'" readonly>
                                    </p>

                                    <p><input class="input-user user-email" type="text" name="email"
                                              value="{{Session::get('user')['user_email']}}"
                                              placeholder="Email" readonly></p>
                                    <p>
                                        <label>
                                            <input id="user_pay" class="input-user" type="radio"
                                                   name="payment-check" value="user_pay" checked>
                                            Nhận hóa đơn và thanh toán
                                        </label>
                                    </p>
                                </div>
                            @endif

                            <div class="col-md-6" class="receiver-info">
                                @if($errors->has('receiver-name') || $errors->has('receiver-address') ||
                                    $errors->has('receiver-phone') || $errors->has('receiver-email'))
                                    <h3><input type="checkbox" class="ship-check" checked> Người nhận hàng
                                    </h3>
                                    @if($errors->has('receiver-name'))
                                        <p class="receiver-error-message"
                                           style="color: red;">{{ $errors->first('receiver-name') }}</p>
                                    @endif
                                    <p><input class="input-receiver receiver-name" type="text"
                                              name="receiver-name"
                                              value="{{old('receiver-name')}}" placeholder="* Họ và tên">
                                    </p>

                                    @if($errors->has('receiver-address'))
                                        <p class="receiver-error-message"
                                           style="color: red;">{{ $errors->first('receiver-address') }}</p>
                                    @endif
                                    <p><input class="input-receiver receiver-address" type="text"
                                              name="receiver-address"
                                              value="{{old('receiver-address')}}" placeholder="* Địa chỉ (Từ số nhà, tên đường ... )">
                                    </p>

                                    @if($errors->has('receiver-phone'))
                                        <p class="receiver-error-message"
                                           style="color: red;">{{ $errors->first('receiver-phone') }}</p>
                                    @endif
                                    <p><input class="input-receiver receiver-phone" type="text"
                                              name="receiver-phone"
                                              value="{{old('receiver-phone')}}"
                                              placeholder="* Số điện thoại"
                                              data-inputmask="'mask': '9999 999 999'">
                                    </p>

                                    @if($errors->has('receiver-email'))
                                        <p class="receiver-error-message"
                                           style="color: red;">{{ $errors->first('receiver-email') }}</p>
                                    @endif
                                    <p><input class="input-receiver receiver-email" type="text"
                                              name="receiver-email"
                                              value="{{old('receiver-email')}}" placeholder="Email">
                                    </p>

                                    <p>
                                        <label>
                                            <input id="receiver_pay" class="input-receiver" type="radio"
                                                   name="payment-check" value="receiver_pay">
                                            Nhận hóa đơn và thanh toán
                                        </label>
                                    </p>
                                @else
                                    <h3><input type="checkbox" class="ship-check"> Người nhận hàng</h3>

                                    <p><input class="input-receiver receiver-name" type="text"
                                              name="receiver-name"
                                              value="{{old('receiver-name')}}" placeholder="* Họ và tên"
                                              disabled>
                                    </p>

                                    <p><input class="input-receiver receiver-address" type="text"
                                              name="receiver-address"
                                              value="{{old('receiver-address')}}" placeholder="* Địa chỉ (Từ số nhà, tên đường ... )"
                                              disabled>
                                    </p>

                                    <p><input class="input-receiver receiver-phone" type="text"
                                              name="receiver-phone"
                                              value="{{old('receiver-phone')}}"
                                              placeholder="* Số điện thoại"
                                              data-inputmask="'mask': '9999 999 999'" disabled>
                                    </p>

                                    <p><input class="input-receiver receiver-email" type="text"
                                              name="receiver-email"
                                              value="{{old('receiver-email')}}" placeholder="Email"
                                              disabled>
                                    </p>

                                    <p>
                                        <label>
                                            <input id="receiver_pay" class="input-receiver" type="radio"
                                                   name="payment-check" value="receiver_pay" disabled>
                                            Nhận hóa đơn và thanh toán
                                        </label>
                                    </p>
                                @endif
                            </div>

                            <div class="col-md-12" style="text-align: center;">
                                <p>
                                    <button type="submit" class="button" id="btnCheckout">Gửi Đơn Hàng
                                    </button>
                                </p>
                            </div>
                        </form>
                    </div>

                    {{-- List product--}}
                    <div class="col-md-12 product-content-right">
                        <div class="woocommerce">
                            <h2>Giỏ hàng của bạn
                                {{--<span class="cart-notify" style="color: orangered;"></span>--}}
                            </h2>
                            @if(!empty(Session::get('cart')->items))
                                <h3>(Vui lòng cập nhật giỏ hàng trước khi thanh toán!)</h3>
                            @endif
                            {{--<form method="post" action="{{route('update-cart')}}">
                                @csrf
                                @method('PUT')--}}
                            <form method="get" id="form-cart" action="{{route('update-cart')}}">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                    <tr>
                                        <th class="product-no">No.</th>
                                        <th class="product-thumbnail">Hình ảnh</th>
                                        <th class="product-name">Tên<br>Sản phẩm</th>
                                        <th class="product-price">Đơn giá<br>(VNĐ)</th>
                                        <th class="product-quantity">Số lượng<br>(Cái)</th>
                                        <th class="product-discount">Được giảm<br>(VNĐ)</th>
                                        <th class="product-subtotal">Thành tiền<br>(VNĐ)</th>
                                        <th class="product-remove"></th>
                                    </tr>
                                    </thead>
                                    @if(Session::get('cart') === null || empty(Session::get('cart')->items))
                                        <tbody>
                                        <tr>
                                            <td class="actions" colspan="8">
                                                {{'Bạn chưa thêm sản phẩm vào giỏ hàng!'}}
                                            </td>
                                        </tr>
                                        <tbody>
                                    @else
                                        <tbody>
                                        <?php $n = 1; ?>
                                        @foreach($getCart as $product_id => $v)
                                            <tr class="cart_item">
                                                <td class="product-remove">
                                                    <span>{{$n++}}</span>
                                                </td>
                                                <td class="product-thumbnail">
                                                    <a href="{{route('product-detail', $product_id)}}">
                                                        <img width="145" height="145" alt="poster_1_up"
                                                             class="shop_thumbnail"
                                                             src="{{$v['item']->image . '/samsung/400/samsung-galaxy-s10-plus-silver-400x400.jpg'}}">
                                                    </a>
                                                    <br><br>
                                                    <span class="amount" style="color: red;">KM: {{$v['item']->discount_percent * 100}} %</span>
                                                </td>

                                                <td class="product-name">
                                                    <a href="{{route('product-detail', $product_id)}}">{{$v['item']->name}}</a>
                                                </td>

                                                <td class="product-price">
                                                <span class="amount">
                                                    {{number_format((float)$v['item']->current_price,2,",", ".")}}<sup>₫</sup>
                                                </span>
                                                </td>

                                                <td class="product-quantity">
                                                    <div class="quantity buttons_added">
                                                        <input type="button" value="-"
                                                               id="btn-minus-{{$product_id}}"
                                                               class="btn-minus minus">

                                                        <style>::placeholder {
                                                                opacity: 0.2;
                                                            }</style>
                                                        <input type="number" pattern="\d*"
                                                               name="qty-product-{{$product_id}}" size="5"
                                                               id="input-qty-{{$product_id}}"
                                                               class="input-text input-qty"
                                                               title="Số lượng phải là số nguyên dương."
                                                               min="1" step="1"
                                                               @if($errors->has('qtyProduct'.$product_id))
                                                               value="{{old('qty-product-'.$product_id)}}"
                                                               placeholder="{{$v['qty']}}"
                                                               @else
                                                               value="{{$v['qty']}}"
                                                               @endif
                                                               required>

                                                        <input type="button" value="+"
                                                               id="btn-plus-{{$product_id}}"
                                                               class="btn-plus plus ">
                                                    </div>
                                                </td>

                                                <td class="product-discount cart-sub-discount-{{$product_id}}">
                                                <span class="amount discount-{{$product_id}}">
                                                    {{number_format((float)($v['qty'] * ($v['item']->current_price * $v['item']->discount_percent)),2,",", ".")}}<sup>₫</sup>
                                                </span>
                                                </td>

                                                <td class="product-subtotal cart-subtotal-{{$product_id}}">
                                                <span class="amount subtotal-{{$product_id}}">
                                                    {{number_format((float)($v['qty'] * ($v['item']->current_price -($v['item']->current_price * $v['item']->discount_percent)) ),2,",", ".")}}<sup>₫</sup>
                                                </span>
                                                </td>
                                                <td class="product-remove">
                                                    {{--<form action="{{route('remove-product-from-cart', $product_id)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-remove-from-cart" id="btnRemoveFromCart{{$product_id}}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>--}}
                                                    {{--<button class="btn-remove-from-cart" id="btnRemoveFromCart{{$product_id}}">
                                                            <i class="fa fa-trash"></i>
                                                    </button>--}}

                                                    <button type="submit"
                                                            formaction="{{route('remove-product-from-cart', $product_id)}}"
                                                            class="btn-remove-from-cart"
                                                            id="btnRemoveFromCart{{$product_id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>

                                                    {{--<a href="{{route('remove-product-from-cart', $product_id)}}"
                                                       class="remove remove-from-cart-link"
                                                       title="Xóa sản phẩm này khỏi giỏ hàng">
                                                        <i class="fa fa-trash"></i>
                                                    </a>--}}
                                                </td>
                                            </tr>
                                            @if($errors->has('qtyProduct'.$product_id))
                                                <tr class="qty-error-mesage" style="color: red;">
                                                    {{--<td colspan="8" > {{$errors}} </td>--}}
                                                    <td colspan="8">
                                                        {{$errors->first('qtyProduct'.$product_id)}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td class="no-border" colspan="2"><b>Tổng:</b></td>
                                            <td class="no-border"></td>
                                            <td class="no-border cart-total" colspan="2">
                                                {{-- Tổng tiền --}}
                                                <b><span>{{number_format((float)($total),2,",", ".")}}<sup>₫</sup></span></b>
                                            </td>
                                            <td class="no-border cart-discount">
                                                {{-- Số tiền được giảm --}}
                                                <b><span>{{number_format((float)($discount),2,",", ".")}}<sup>₫</sup></span></b>
                                            </td>
                                            <td class="no-border cart-payment">
                                                {{-- Số tiền phải thanh toán --}}
                                                <b><span>{{number_format((float)($total - $discount),2,",", ".")}}<sup>₫</sup></span></b>
                                            </td>
                                        </tr>
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                            <td class="actions" colspan="8">
                                                <a href="{{route('delete-cart')}}" class="delete-cart-link"
                                                   name="delete_cart" class="button" id="btnDeleteCart">
                                                    Hủy giỏ hàng
                                                </a>
                                                {{--<input type="submit" value="Cập nhật giỏ hàng" name="update_cart"
                                                       class="button" id="btnUpdateCart">--}}
                                                <button type="submit"
                                                        class="button" id="btnUpdateCart">
                                                    Cập nhật giỏ hàng
                                                </button>
                                                {{--<a href="{{route('update-cart')}}"
                                                   class="update-cart-link"
                                                   style="background-color: lightblue; padding: 10px; border-radius: 20px;">
                                                    <i class="fa fa-refresh "></i> Cập nhật giỏ hàng
                                                </a>--}}
                                            </td>
                                        </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </form>
                        </div>
                    </div>{{-- End list product--}}
                </div>

                @if(Session::get('cart') !== null && !empty(Session::get('cart')->items))
                <div class="col-md-3">
                    <div class="cart_totals ">
                        <h2>Thanh toán</h2>
                        <table cellspacing="0">
                            <tbody>
                            <tr class="totals cart-total">
                                <th>Tổng tiền</th>
                                <td>
                                    <span class="amount" id="cart-total">{{number_format((float)($total),2,",", ".")}}<sup>₫</sup></span>
                                </td>
                            </tr>

                            <tr class="discount cart-discount">
                                <th>Được giảm</th>
                                <td>
                                    <span class="amount" id="cart-discount">{{number_format((float)($discount),2,",", ".")}}<sup>₫</sup></span>
                                </td>
                            </tr>

                            <tr class="payment cart-payment">
                                <th>Phải trả</th>
                                <td>
                                    <strong>
                                        <span class="amount" id="cart-payment">{{number_format((float)($total - $discount),2,",", ".")}}<sup>₫</sup></span>
                                    </strong>
                                </td>
                            </tr>
                            </tbody>

                            <tfoot>
                            <tr>
                                <td colspan="2">
                                    <button class="payment_now"
                                            data-toggle="collapse" href="#show-me"
                                            aria-expanded="false" aria-controls="show-me"
                                            onclick="backToTop()">
                                        Thanh toán ngay
                                    </button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#receiver_pay').on('click', function () {
                $(this).val('receiver_pay');
            });
            $('#user_pay').on('click', function () {
                $(this).val('user_pay');
            });

            $("input.input-qty").on("keypress keyup blur", function (event) {
                //$(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

            setTimeout(function () {
                $("tr.qty-error-mesage").fadeOut('slow');
            }, 5000);

            @if(Session::get('cart') !== null)
                @foreach($getCart as $product_id => $v)
                    @if($errors->has('qtyProduct'.$product_id))
                        $('#show-me').removeClass('in');
                    @endif
                @endforeach
            @endif

            setTimeout(function () {
                $('div.alert-success').fadeOut('slow');
            }, 1500);
        })
    </script>
@endsection
