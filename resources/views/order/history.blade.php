@extends('layouts.template')

@section('content')
    <script>
        function backToTop() {
            $("html, body").animate({scrollTop: 120}, 600);
            return false;
        }
    </script>

    <div class="container mt-3 order-history">
    @if(Session::get('user') === null)
        <div class="product-big-title-area">
            <div class="product-bit-title text-center">
                <h2>Vui lòng đăng nhập để thực hiện chức năng này!</h2>
            </div>
        </div>
    @else
        <div class="product-big-title-area">
            <div class="product-bit-title text-center">
                <h2>Danh sách lịch sử đặt hàng của bạn</h2>
            </div>
        </div>
        <div class="rows order-detail">
            <div class="col-md-9 ">
                @foreach($getAll as $date=>$orderOfDate)
                    <?php krsort($orderOfDate)?>
                    @foreach($orderOfDate as $orderID=>$details)
                        @if(array_key_first($getAll) == $date && array_key_first($orderOfDate) == $orderID)
                            <div id="order{{$orderID}}" class="collapse in">
                                @foreach ($details as $productID=>$order)
                                    <div class="row order-info text-left">
                                        <div class="col-sm-4">
                                            <strong>Ngày đặt:</strong>
                                            <span>{{date("d/m/Y", strtotime($order->order_date))}}</span>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <strong>Ngày giao:</strong>
                                            @if($order->ship_date === null)
                                                <span>Đang cập nhật</span>
                                            @else
                                                <span>{{date("d/m/Y", strtotime($order->ship_date))}}</span>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <strong>Tình trạng:</strong>
                                            <span>{{$order->status}}</span>
                                        </div>
                                    </div>
                                    <div class="row order-address">
                                        <div class="col-sm-4">
                                            <strong>Điện thoại người nhận hàng:</strong>
                                            <br>
                                            <strong>Địa chỉ người nhận hàng:</strong>
                                            <br>
                                            <strong>Địa chỉ người nhận hóa đơn:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span>{{$order->phone_receiver}}</span>
                                            <br>
                                            <span>{{$order->ship_address}}</span>
                                            <br>
                                            <span>{{$order->billing_address}}</span>
                                        </div>
                                    </div>
                                    @break
                                @endforeach
                                <div class="order-product-list">
                                    <table class="shop_table">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá lúc mua</th>
                                            <th>Số lượng</th>
                                            <th>Được giảm</th>
                                            <th>Phải trả</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; $totalDiscount = 0; $totalAmount = 0;?>
                                        @foreach ($details as $productID=>$order)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td class="product-name"><a href="product/{{$productID}}">{{$order->name}}</a></td>
                                                <td class="product-price">
                                                    {{number_format((float)($order->amount / $order->qtyO),2,",", ".")}}<sup>₫</sup>
                                                </td>
                                                <td class="product-quantity">{{$order->qtyO}}</td>
                                                <td class="product-discount">
                                                    {{number_format((float)$order->discount_amount,2,",", ".")}}<sup>₫</sup>
                                                </td>
                                                <td class="product-subtotal">
                                                    {{number_format((float)$order->amount,2,",", ".")}}<sup>₫</sup>
                                                </td>
                                            </tr>
                                            <?php
                                                $totalDiscount += $order->discount_amount;
                                                $totalAmount += $order->amount;
                                            ?>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4"> Tổng tiền:</td>
                                            <td class="order-discount">
                                                {{number_format((float)$totalDiscount,2,",", ".")}}<sup>₫</sup>
                                            </td>
                                            <td class="order-total">
                                                {{number_format((float)$totalAmount,2,",", ".")}}<sup>₫</sup>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div id="order{{$orderID}}" class="collapse">
                                @foreach ($details as $productID=>$order)
                                    <div class="row order-info text-left">
                                        <div class="col-sm-4">
                                            <strong>Ngày đặt:</strong>
                                            <span>{{date("d/m/Y", strtotime($order->order_date))}}</span>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <strong>Ngày giao:</strong>
                                            @if($order->ship_date === null)
                                                <span>Đang cập nhật</span>
                                            @else
                                                <span>{{date("d/m/Y", strtotime($order->ship_date))}}</span>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <strong>Tình trạng:</strong>
                                            <span>{{$order->status}}</span>
                                        </div>
                                    </div>
                                    <div class="row order-address">
                                        <div class="col-sm-4">
                                            <strong>Điện thoại người nhận hàng:</strong>
                                            <br>
                                            <strong>Địa chỉ người nhận hàng:</strong>
                                            <br>
                                            <strong>Địa chỉ người nhận hóa đơn:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span>{{$order->phone_receiver}}</span>
                                            <br>
                                            <span>{{$order->ship_address}}</span>
                                            <br>
                                            <span>{{$order->billing_address}}</span>
                                        </div>
                                    </div>
                                    @break
                                @endforeach
                                <div class="order-product-list">
                                    <table class="shop_table">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá lúc mua</th>
                                            <th>Số lượng</th>
                                            <th>Được giảm</th>
                                            <th>Phải trả</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; $totalDiscount = 0; $totalAmount = 0;?>
                                        @foreach ($details as $productID=>$order)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td class="product-name"><a href="product/{{$productID}}">{{$order->name}}</a></td>
                                                <td class="product-price">
                                                    {{number_format((float)($order->amount / $order->qtyO),2,",", ".")}}<sup>₫</sup>
                                                </td>
                                                <td class="product-quantity">{{$order->qtyO}}</td>
                                                <td class="product-discount">
                                                    {{number_format((float)$order->discount_amount,2,",", ".")}}<sup>₫</sup>
                                                </td>
                                                <td class="product-subtotal">
                                                    {{number_format((float)$order->amount,2,",", ".")}}<sup>₫</sup>
                                                </td>
                                            </tr>
                                            <?php
                                            $totalDiscount += $order->discount_amount;
                                            $totalAmount += $order->amount;
                                            ?>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4"> Tổng tiền:</td>
                                            <td class="order-discount">
                                                {{number_format((float)$totalDiscount,2,",", ".")}}<sup>₫</sup>
                                            </td>
                                            <td class="order-total">
                                                {{number_format((float)$totalAmount,2,",", ".")}}<sup>₫</sup>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>

            <div class="col-md-3">
                <h3 class="text-center">Các đơn đặt hàng</h3>
                <div class="panel-group" id="accordion">
                    @foreach($getAll as $date=>$orderOfDate)
                    <?php krsort($orderOfDate)?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a id="date{{str_replace('-', '', $date)}}"
                                   data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse{{str_replace('-', '', $date)}}">
                                    Ngày: {{date("d/m/Y", strtotime($date))}}
                                </a>
                            </h4>
                        </div>
                        @if(array_key_first($getAll) == $date)
                        <div id="collapse{{str_replace('-', '', $date)}}" class="panel-collapse collapse in">
                            <div class="panel-body">
                                @foreach($orderOfDate as $orderID=>$details)
                                    @if(array_key_first($orderOfDate) == $orderID)
                                        <a type="button" class="btn btn-light active" id="btn{{$orderID}}"
                                           data-toggle="collapse" data-target="#order{{$orderID}}"
                                           onclick="backToTop()">
                                            Đơn hàng số {{$orderID}}
                                        </a>
                                    @else
                                        <a type="button" class="btn btn-light" id="btn{{$orderID}}"
                                           data-toggle="collapse" data-target="#order{{$orderID}}"
                                           onclick="backToTop()">
                                            Đơn hàng số {{$orderID}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div id="collapse{{str_replace('-', '', $date)}}" class="panel-collapse collapse">
                        {{--@endif--}}
                            <div class="panel-body">
                            @foreach($orderOfDate as $orderID=>$details)
                                <a type="button" class="btn btn-light" id="btn{{$orderID}}"
                                   data-toggle="collapse" data-target="#order{{$orderID}}"
                                   onclick="backToTop()">
                                    Đơn hàng số {{$orderID}}
                                </a>
                            @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    </div>

    <style>
        .active { color: darkblue;}
        .order-history, .order-detail {margin-top: 20px;}
        .order-no, .order-info, .order-address, .order-list {font-size: 18px; margin-bottom: 15px;}
        .order-no {padding-right: 15px; color: orangered;}
        .order-product-list tfoot tr {font-weight: bold;}
        .order-list ol {padding: 0; margin: 15px 0; list-style-type:decimal-leading-zero;}
        .order-list ol li {margin-left: 30px;}
        .order-history a {text-decoration: none;}
        .order-history a:hover {text-decoration: none; cursor: pointer;}
        .product-big-title-area {margin-bottom: 25px;}
        .panel-body a {margin-bottom: 5px;}
        hr { border: 3px solid green;}

    </style>
    <script>
        $(document).ready(function () {
            @if(Session::get('user') !== null)
                @foreach($getAll as $date=>$orderOfDate)
                    @foreach($orderOfDate as $orderID=>$details)
                        $("#btn{{$orderID}}").click(function (e) {
                            e.preventDefault();

                            $(this).addClass('active');

                            @foreach($getAll as $date=>$orderOfDate)
                                @foreach($orderOfDate as $oID=>$pDetails)
                                    @if($orderID != $oID)
                                        $("#order{{$oID}}").removeClass('in');
                                        {{--$("#order{{$oID}}").removeClass('show');--}}
                                        $("#btn{{$oID}}").removeClass('active');
                                    @endif
                                @endforeach
                            @endforeach
                        });
                    @endforeach
                @endforeach
            @endif
        });
    </script>
@endsection
