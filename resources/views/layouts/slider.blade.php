<div class="slider-area">
    <!-- Slider -->
    <div class="block-slider block-slider4">
        <ul class="" id="bxslider-home4">
            <?php
            /*PHP duyệt tất cả hình ảnh trong thư mục*/
            $path = 'img/slides';
            $titles = [];
            if ($dh = opendir($path)) {
                while (($title = readdir($dh)) !== false) {
                    if (preg_match('/([a-zA-Z0-9\.\-\_\\s\(\)]+)\.([a-zA-Z0-9]+)$/', $title, $m)) {
                        //var_dump($m); die;
                        //echo $title . '<br />';
                        $titles[] = $title;
                    }
                }
            }
            /*foreach ($t as $tit) {
                echo $path.$tit;
            }*/
            ?>
            @foreach($titles as $t)
                <?php

                    $arrayString = explode('-', substr($t, 0, -4))//explode(): tách chuổi; substr(): cắt chuổi
                ?>
                <li><img src="{{asset($path.'/'.$t)}}" alt="Slide">
                    <div class="caption-group">
                        {{--<h2 class="caption title">
                            Apple <span class="primary">Store <strong>Ipod</strong></span>
                        </h2>
                        <h4 class="caption subtitle">& Phone</h4>--}}
                        <a class="caption button-radius" href="{{route('list-product-of-brand', strtolower($arrayString[0]))}}"><span class="icon"></span>Xem ngay</a>
                    </div>
                </li>
            @endforeach

        </ul>
    </div><!-- ./Slider -->
</div> <!-- End slider area -->
