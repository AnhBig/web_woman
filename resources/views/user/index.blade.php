@extends('user.layout.main')

@section('main')
<main class="main">
    <div class="intro-section bg-lighter pt-5 pb-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">
                        <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside"
                            data-toggle="owl"
                            data-owl-options='{
                                        "nav": false, 
                                        "responsive": {
                                            "768": {
                                                "nav": true
                                            }
                                        }
                                    }'>
                            <div class="intro-slide">
                                <figure class="slide-image">
                                    <picture>
                                        <source media="(max-width: 480px)"
                                            srcset="{{ asset('/') }}assets_fe/images/slider/slide-3-480w.jpg">
                                        <img class="img_slider" height="480"
                                            src="{{ asset('/') }}assets_fe/images/slider/slide-3-480w.jpg"
                                            alt="Image Desc">
                                    </picture>
                                </figure>
                                <!-- End .slide-image -->


                            </div>
                            <!-- End .intro-slide -->

                            <div class="intro-slide">
                                <figure class="slide-image">
                                    <picture>
                                        <source media="(max-width: 480px)"
                                            srcset="{{ asset('/') }}assets_fe/images/slider/slide-2-480w.jpg">
                                        <img class="img_slider"
                                            src="{{ asset('/') }}assets_fe/images/slider/slide-2.jpg"
                                            alt="Image Desc">
                                    </picture>
                                </figure>
                                <!-- End .slide-image -->

                            </div>
                            <!-- End .intro-slide -->

                            <div class="intro-slide">
                                <figure class="slide-image">
                                    <picture>
                                        <source media="(max-width: 480px)"
                                            srcset="{{ asset('/') }}assets_fe/images/slider/slide-1-480w.jpg">
                                        <img class="img_slider"
                                            src="{{ asset('/') }}assets_fe/images/slider/slide-1.jpg"
                                            alt="Image Desc">
                                    </picture>
                                </figure>
                                <!-- End .slide-image -->

                            </div>
                            <!-- End .intro-slide -->
                        </div>
                        <!-- End .intro-slider owl-carousel owl-simple -->

                        <span class="slider-loader"></span>
                        <!-- End .slider-loader -->
                    </div>
                    <!-- End .intro-slider-container -->
                </div>
                <!-- End .col-lg-8 -->
                {{-- <div class="col-lg-4">
                        <div class="intro-banners">
                            <div class="row row-sm">
                                <div class="col-md-6 col-lg-12">
                                    <div class="banner banner-display">
                                        <a href="#">
                                            <img src="{{ asset('/') }}assets_fe/images/banners/home/intro/banner-1.jpg"
                alt="Banner">
                </a>

                <div class="banner-content">
                    <h4 class="banner-subtitle text-darkwhite"><a href="#">Clearence</a></h4>
                    <!-- End .banner-subtitle -->
                    <h3 class="banner-title text-white"><a href="#">Chairs & Chaises <br>Up to
                            40% off</a></h3>
                    <!-- End .banner-title -->
                    <a href="#" class="btn btn-outline-white banner-link">Shop Now<i
                            class="icon-long-arrow-right"></i></a>
                </div>
                <!-- End .banner-content -->
            </div>
            <!-- End .banner -->
        </div>
        <!-- End .col-md-6 col-lg-12 -->

        <div class="col-md-6 col-lg-12">
            <div class="banner banner-display mb-0">
                <a href="#">
                    <img src="{{ asset('/') }}assets_fe/images/banners/home/intro/banner-2.jpg"
                        alt="Banner">
                </a>

                <div class="banner-content">
                    <h4 class="banner-subtitle text-darkwhite"><a href="#">New in</a></h4>
                    <!-- End .banner-subtitle -->
                    <h3 class="banner-title text-white"><a href="#">Best Lighting
                            <br>Collection</a></h3>
                    <!-- End .banner-title -->
                    <a href="#" class="btn btn-outline-white banner-link">Discover Now<i
                            class="icon-long-arrow-right"></i></a>
                </div>
                <!-- End .banner-content -->
            </div>
            <!-- End .banner -->
        </div>
        <!-- End .col-md-6 col-lg-12 -->
    </div>
    <!-- End .row row-sm -->
    </div>
    <!-- End .intro-banners -->
    </div> --}}
    <!-- End .col-lg-4 -->
    </div>
    <!-- End .row -->

    <div class="mb-6"></div>
    <!-- End .mb-6 -->

    <div class="owl-carousel owl-simple" data-toggle="owl"
        data-owl-options='{
                            "nav": false, 
                            "dots": false,
                            "margin": 30,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":2
                                },
                                "420": {
                                    "items":3
                                },
                                "600": {
                                    "items":4
                                },
                                "900": {
                                    "items":5
                                },
                                "1024": {
                                    "items":6
                                }
                            }
                        }'>
        <a href="#" class="brand">
            <img src="{{ asset('/') }}assets_fe/images/brands/1.png" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ asset('/') }}assets_fe/images/brands/2.png" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ asset('/') }}assets_fe/images/brands/3.png" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ asset('/') }}assets_fe/images/brands/4.png" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ asset('/') }}assets_fe/images/brands/5.png" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ asset('/') }}assets_fe/images/brands/6.png" alt="Brand Name">
        </a>
    </div>
    <!-- End .owl-carousel -->
    </div>
    <!-- End .container -->
    </div>



    <!-- End .bg-lighter -->

    <div class="mb-6"></div>
    <!-- End .mb-6 -->

    <div class="container">
        <div class="heading heading-center mb-3">
            <h2 class="title-lg text-uppercase">Sản Phẩm Hot</h2>
        </div>
        <!-- End .heading -->

        <div class="tab-content tab-content-carousel">
            <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel"
                aria-labelledby="trendy-all-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                    @foreach ($productHot as $item)
                    <div class="product product-11 text-center">
                        <figure class="product-media">
                            @php
                            $getImage = App\Models\Product::limitImage($item->id);
                            @endphp
                            <a href="{{ url($item->slug) }}">
                                @foreach ($getImage as $key => $img)
                                <img src="{{ $img->checkImage() }}" alt="Product image"
                                    class="{{ $key == 0 ? 'product-image' : 'product-image-hover' }}">
                                @endforeach
                            </a>

                            <div class="product-action-vertical">
                                @if (Auth::check())
                                <div data-id="{{ $item->id }}" data-user-id="{{ Auth::id() }}"
                                    style="cursor: pointer;" class="btn-product-icon btn-wishlist"><span>Thêm
                                        danh sách yêu thích</span>
                                </div>
                                @endif
                            </div>
                        </figure>
                        <!-- End .product-media -->

                        <div class="product-body">
                            <h3 class="product-title"><a
                                    href="{{ url($item->slug) }}">{{ Str::limit($item->title, 25) }}</a>
                            </h3>
                            <div class="product-price">
                                {{ number_format($item->price, 0, ',', '.') }}₫
                            </div>
                        </div>

                    </div>
                    <!-- End .product -->
                    @endforeach

                </div>
                <!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->

        </div>
        <!-- End .tab-content -->
    </div>
    <!-- End .container -->

    <div class="container">
        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-6">
                <div class="icon-box icon-box-card text-center">
                    <span class="icon-box-icon">
                        <i class="icon-rocket"></i>
                    </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Thanh toán & Giao hàng</h3>
                        <!-- End .icon-box-title -->
                        <p>Miễn phí vận chuyển cho đơn hàng trên 200k</p>
                    </div>
                    <!-- End .icon-box-content -->
                </div>
                <!-- End .icon-box -->
            </div>
            <!-- End .col-lg-4 col-sm-6 -->

            <div class="col-lg-4 col-sm-6">
                <div class="icon-box icon-box-card text-center">
                    <span class="icon-box-icon">
                        <i class="icon-rotate-left"></i>
                    </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Hoàn & trả tiền</h3>
                        <p>Đảm bảo hoàn tiền miễn phí 100%</p>
                    </div>
                    <!-- End .icon-box-content -->
                </div>
                <!-- End .icon-box -->
            </div>
            <!-- End .col-lg-4 col-sm-6 -->

            <div class="col-lg-4 col-sm-6">
                <div class="icon-box icon-box-card text-center">
                    <span class="icon-box-icon">
                        <i class="icon-life-ring"></i>
                    </span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Hỗ trợ chất lượng</h3>
                        <!-- End .icon-box-title -->
                        <p>Luôn phản hồi trực tuyến 24/7</p>
                    </div>
                    <!-- End .icon-box-content -->
                </div>
                <!-- End .icon-box -->
            </div>
            <!-- End .col-lg-4 col-sm-6 -->
        </div>
        <!-- End .row -->

        <div class="mb-2"></div>
        <!-- End .mb-2 -->
    </div>
    <!-- End .container -->

    <div class="mb-5"></div>
    <!-- End .mb-6 -->


    <div class="container">
        <div class="heading heading-center mb-6">
            <h2 class="title">DANH SÁCH SẢN PHẨM</h2>
            <!-- End .title -->

            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="top-all-link" data-toggle="tab" href="#top-all-tab"
                        role="tab" aria-controls="top-all-tab" aria-selected="true">Tất cả</a>
                </li>
                @foreach ($category as $ct)
                <li class="nav-item">
                    <a class="nav-link list_product_category" data-category="{{ $ct->id }}"
                        id="top-fur-link" data-toggle="tab" href="#top-fur-tab" role="tab"
                        aria-controls="top-fur-tab" aria-selected="false">{{ $ct->name }}</a>
                </li>
                @endforeach

            </ul>
        </div>
        <!-- End .heading -->

        <div class="tab-content">
            <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel"
                aria-labelledby="top-all-link">
                <div class="products">
                    <div class="row justify-content-center" id="renderSeeMoreProductHome">
                        @foreach ($product as $item)
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <div class="product product-11 mt-v3 text-center">
                                <figure class="product-media">
                                    @php
                                    $getImage = App\Models\Product::limitImage($item->id);
                                    @endphp
                                    <a href="{{ url($item->slug) }}">
                                        @foreach ($getImage as $key => $img)
                                        <img src="{{ $img->checkImage() }}" alt="Product image"
                                            class="{{ $key == 0 ? 'product-image' : 'product-image-hover' }}">
                                        @endforeach
                                    </a>

                                    <div class="product-action-vertical">
                                        @if (Auth::check())
                                        <div data-id="{{ $item->id }}"
                                            data-user-id="{{ Auth::id() }}" style="cursor: pointer;"
                                            class="btn-product-icon btn-wishlist"><span>Thêm
                                                danh sách yêu thích</span>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- End .product-action-vertical -->
                                </figure>
                                <!-- End .product-media -->

                                <div class="product-body">
                                    <h3 class="product-title"><a
                                            href="{{ url($item->slug) }}">{{ Str::limit($item->title, 25) }}</a>
                                    </h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        {{ number_format($item->price, 0, ',', '.') }}₫
                                    </div>
                                    <!-- End .product-price -->


                                </div>

                            </div>
                            <!-- End .product -->
                        </div>
                        @endforeach
                    </div>
                    <!-- End .row -->
                </div>
                <!-- End .products -->
            </div><!-- .End .tab-pane -->

            <div class="tab-pane p-0 fade" id="top-fur-tab" role="tabpanel" aria-labelledby="top-fur-link">
                <div class="products" id="productByCategoryId">

                </div>
            </div>


            <!-- .End .tab-pane -->
        </div>
        <!-- End .tab-content -->

        @if (count($productAll) > 8)
        <div class="more-container text-center">
            <button class="btn btn-outline-darker btn-more" id="loadMoreProductHome"><span>Xem thêm</span><i
                    class="icon-long-arrow-down"></i></butt>
        </div>
        @endif
        <!-- End .more-container -->
    </div>
    <!-- End .container -->


    <!-- End .container -->
    <div class="blog-posts pt-7 pb-7" style="background-color: #fafafa;">
        <div class="container">
            <h2 class="title-lg text-center mb-3 mb-md-4">Tin tức mới nhất</h2>
            <!-- End .title-lg text-center -->

            <div class="owl-carousel owl-simple carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                }
                            }
                        }'>
                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ asset('/') }}assets_fe/images/blog/home/post-1.jpg" alt="image desc">
                        </a>
                    </figure>
                    <!-- End .entry-media -->

                    <div class="entry-body pb-4 text-center">
                        <div class="entry-meta">
                            <a href="#">Nov 22, 2018</a>, 0 Comments
                        </div>
                        <!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="single.html">Sed adipiscing ornare.</a>
                        </h3>
                        <!-- End .entry-title -->

                        <div class="entry-content">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus
                                hendrerit.<br>Pelletesque aliquet nibh necurna. </p>
                            <a href="single.html" class="read-more">Read More</a>
                        </div>
                        <!-- End .entry-content -->
                    </div>
                    <!-- End .entry-body -->
                </article>
                <!-- End .entry -->

                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ asset('/') }}assets_fe/images/blog/home/post-2.jpg" alt="image desc">
                        </a>
                    </figure>
                    <!-- End .entry-media -->

                    <div class="entry-body pb-4 text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 12, 2018</a>, 0 Comments
                        </div>
                        <!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="single.html">Fusce lacinia arcuet nulla.</a>
                        </h3>
                        <!-- End .entry-title -->

                        <div class="entry-content">
                            <p>Sed pretium, ligula sollicitudin laoreet<br>viverra, tortor libero sodales leo, eget
                                blandit nunc tortor eu nibh. Nullam mollis justo. </p>
                            <a href="single.html" class="read-more">Read More</a>
                        </div>
                        <!-- End .entry-content -->
                    </div>
                    <!-- End .entry-body -->
                </article>
                <!-- End .entry -->

                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ asset('/') }}assets_fe/images/blog/home/post-3.jpg" alt="image desc">
                        </a>
                    </figure>
                    <!-- End .entry-media -->

                    <div class="entry-body pb-4 text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 19, 2018</a>, 2 Comments
                        </div>
                        <!-- End .entry-meta -->

                        <h3 class="entry-title">
                            <a href="single.html">Quisque volutpat mattis eros.</a>
                        </h3>
                        <!-- End .entry-title -->

                        <div class="entry-content">
                            <p>Suspendisse potenti. Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae
                                luctus metus libero eu augue. </p>
                            <a href="single.html" class="read-more">Read More</a>
                        </div>
                        <!-- End .entry-content -->
                    </div>
                    <!-- End .entry-body -->
                </article>
                <!-- End .entry -->
            </div>
            <!-- End .owl-carousel -->
        </div><!-- container -->

        <div class="more-container text-center mb-0 mt-3">
            <a href="blog.html" class="btn btn-outline-darker btn-more"><span>Xem thêm</span><i
                    class="icon-long-arrow-right"></i></a>
        </div>
        <!-- End .more-container -->
    </div>

    <!-- End .cta -->
</main>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        $(document).on('click', '.btn-wishlist', function() {
            var idProduct = $(this).data('id');
            var user_id = $(this).data('user-id');

            $.ajax({
                url: "{{ route('addProductWishList') }}",
                method: 'POST',
                data: {
                    user_id: user_id,
                    _token: '{{ csrf_token() }}',
                    product_id: idProduct,
                },
                success: function(response) {
                    if (response.status == "success") {
                        $(".wishlist-count").text(response.count);
                        Swal.fire({
                            title: response.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1800
                        });

                    } else {
                        Swal.fire({
                            title: response.message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1800
                        });
                    }

                },
            })
        })

        $(document).on('click', '.list_product_category', function() {
            var id = $(this).attr('data-category');

            $.ajax({
                url: "{{ route('getProductCategoryById') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: id
                },
                success: function(response) {
                    $('#productByCategoryId').html(response.view);

                },
                error: function(xhr, status, error) {
                    console.error(
                        'There was a problem with the AJAX request:',
                        status, error);
                }
            })
        })


        var limitOld = 8;
        $("#loadMoreProductHome").click(function() {
            var limit = limitOld + 8
            var url = "{{ route('seeMoreProductHome') }}";
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    limit: limit
                },
                success: function(response) {
                    console.log(response);
                    limitOld += 8;

                    $('#renderSeeMoreProductHome').html(response.view);

                    if (limitOld >= {
                            {
                                count($productAll)
                            }
                        }) {
                        $("#loadMoreProductHome").hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(
                        'There was a problem with the AJAX request:',
                        status, error);
                }
            })
        })

    })
</script>
@endsection