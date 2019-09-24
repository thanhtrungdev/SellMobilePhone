<div class="footer-top-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer-about-us">
                    <h2><span>PHONE STORE</span></h2>
                    <p>Tư vấn miễn phí: <a href="tel:18006601">1800 6601</a> (7:30-22:00)</p>
                    <p>Gọi mua hàng: <a href="tel:18001060">1800 1060</a> (7:30-22:00)</p>
                    <p>Hỗ trợ kỹ thuật: <a href="tel:18001763">1800 1763</a> (7:30-22:00)</p>
                    <p>Email liên hệ: <a href="mailto:support@phonestore.com">support@phonestore.com</a></p>
                    <div class="footer-social">
                        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">Chỉ dẫn</h2>
                    <ul>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Giao hàng và thanh toán</a></li>
                        <li><a href="#">Hướng dẫn mua hàng online</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">Danh mục sảm phẩm</h2>
                    <ul>
                        @foreach($listBrand as $brand)
                            @if($brand->name != 'N/A')
                                <li>
                                    <a class="" href="{{route('list-product-of-brand', strtolower($brand->name))}}">
                                        {{'Điện thoại '. $brand->name}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        <li><a class="" href="{{route('list-accessories')}}">Phụ kiện chính hãng</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-newsletter">
                    <h2 class="footer-wid-title">Góp ý</h2>
                    <div class="contact-us-form">
                        <form method="post" action="{{route('feedback')}}">
                            @csrf
                            @if($errors->has('message'))
                                <p style="color: red;">{{$errors->first('message')}}</p>
                            @endif
                            <textarea rows="4" name="message" value="{{old('message')}}" placeholder="Nội dung tin nhắn ..."></textarea>
                            @if($errors->has('user_email'))
                                <p style="color: red;">{{$errors->first('user_email')}}</p>
                            @endif
                            <input type="email" name="user_email" value="{{old('user_email')}}" placeholder="Email của bạn?">
                            <button type="submit">Gửi phản hồi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End footer top area -->

<div class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="copyright">
                    <p>&copy; 2019 Phone Store. All Rights Reserved.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card-icon">
                    <i class="fa fa-cc-discover"></i>
                    <i class="fa fa-cc-mastercard"></i>
                    <i class="fa fa-cc-paypal"></i>
                    <i class="fa fa-cc-visa"></i>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End footer bottom area -->
<!-- Latest jQuery form server -->
{{--<script src="https://code.jquery.com/jquery.min.js"></script>--}}
{{--<script src="js/jquery.min.js"></script>--}}
<script src="{{asset('js/jquery.min.js')}}"></script>

<!-- Input mask -->
<script src="{{asset('js/inputmask.min.js')}}"></script>
<script src="{{asset('js/jquery.inputmask.min.js')}}"></script>

<!-- Bootstrap JS form CDN -->
{{--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>--}}
{{--<script src="js/bootstrap.min.js"></script>--}}
<script src="{{asset('js/bootstrap.min.js')}}"></script>

<!-- jQuery sticky menu -->
{{--<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.sticky.js"></script>--}}
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/jquery.sticky.js')}}"></script>

<!-- jQuery easing -->
{{--<script src="js/jquery.easing.1.3.min.js"></script>--}}
<script src="{{asset('js/jquery.easing.1.3.min.js')}}"></script>

<!-- Main Script -->
{{--<script src="js/main.js"></script>--}}
<script src="{{asset('js/main.js')}}"></script>

<!-- Slider -->
{{--<script type="text/javascript" src="js/bxslider.min.js"></script>
<script type="text/javascript" src="js/script.slider.js"></script>--}}
<script type="text/javascript" src="{{asset('js/bxslider.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/script.slider.js')}}"></script>

</body>
</html>
