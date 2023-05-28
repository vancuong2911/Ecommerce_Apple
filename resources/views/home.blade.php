@extends('layout', ['title' => 'Home'])

@section('page-content')
    @if (session('message'))
        <div class="notification-container">
            <div class="notification">
                <div class="notification-message">
                    {!! session('message') !!}
                </div>
            </div>
        </div>
    @endif
    <!-- ***** Main Banner Area Start ***** -->
    <section id="billboard" class="position-relative overflow-hidden bg-light-blue">
        <div class="swiper main-swiper">
            <div class="swiper-wrapper">
                @php
                    $hasBanner = false;
                @endphp
                @foreach ($products as $product)
                    @if ($product->is_banner == 1)
                        @php
                            $hasBanner = true;
                        @endphp
                        <div class="swiper-slide">
                            <div class="container">
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-6">
                                        <div class="banner-content">
                                            <h1 class="display-2 text-uppercase text-dark pb-5">
                                                {{ $product->description_short }}</h1>
                                            <a href="{{ route('single.product', $product->id) }}"
                                                class="btn btn-medium btn-dark text-uppercase btn-rounded-none"
                                                target="_blank">Shop
                                                Product</a>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="image-holder" style="margin: 73px 0 5px 0;">
                                            <img src="{{ asset('clients/images_upload/Products/' . $product->image) }}"
                                                alt="banner" height="675px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if (!$hasBanner)
                    <div class="swiper-slide" style="padding-top: 150px">
                        <div class="container">
                            <div class="row d-flex align-items-center">
                                <div class="col-md-12">
                                    <div class="banner-content">
                                        <h1 class="display-2 text-uppercase text-dark pb-5">
                                            We haven't updated any banners yet!</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        <div class="swiper-icon swiper-arrow swiper-arrow-prev">
            <svg class="chevron-left">
                <use xlink:href="#chevron-left" />
            </svg>
        </div>
        <div class="swiper-icon swiper-arrow swiper-arrow-next">
            <svg class="chevron-right">
                <use xlink:href="#chevron-right" />
            </svg>
        </div>
    </section>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** Company Service Start ***** -->
    <section id="company-services" class="padding-large">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="cart-outline">
                                <use xlink:href="#cart-outline" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Free delivery</h3>
                            <p>Consectetur adipi elit lorem ipsum dolor sit amet.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="quality">
                                <use xlink:href="#quality" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Quality guarantee</h3>
                            <p>Dolor sit amet orem ipsu mcons ectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="price-tag">
                                <use xlink:href="#price-tag" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">Daily offers</h3>
                            <p>Amet consectetur adipi elit loreme ipsum dolor sit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-3">
                    <div class="icon-box d-flex">
                        <div class="icon-box-icon pe-3 pb-3">
                            <svg class="shield-plus">
                                <use xlink:href="#shield-plus" />
                            </svg>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="card-title text-uppercase text-dark">100% secure payment</h3>
                            <p>Rem Lopsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Company Service End ***** -->

    <!-- ***** About Area Starts ***** -->
    <section id="about-us" class="padding-large no-padding-top">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center justify-content-between">
                <div class="col-lg-6 col-md-12">
                    <div class="section-heading">
                        <h6>About Us</h6>
                        <h2></h2>
                    </div>
                    @foreach ($about_us as $a_us_item)
                        <div class="image-holder mb-4">
                            <div>
                                <img src="{{ asset('clients/images_upload/Banners/' . $a_us_item->image) }}" alt="single"
                                    class="single-image">
                            </div>
                        </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="detail ps-5">
                        <div class="display-header">
                            <h2 class="display-7 text-uppercase text-dark">{{ $a_us_item->title }}</h2>
                            <p class="pb-3">{{ $a_us_item->description }}</p>
                            {{-- <a href="/menu" class="btn btn-medium btn-dark text-uppercase btn-rounded-none">Shop Our
                                store</a> --}}
                        </div>
                    </div>
                </div>
                <section class="section" id="about">
                    <div class="container">
                        <div class="section-heading">
                            <h6>Video History Iphone</h6>
                            <h2></h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div class="right-content">
                                    <div class="thumb">
                                        <a rel="nofollow" href="#" class="play-btn"
                                            data-video="{{ asset('clients/images_upload/About_Us/' . $a_us_item->youtube_link) }}">
                                            <i class="fa fa-play"></i>
                                        </a>
                                        <!-- Modal -->
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div id="videoModal" class="modal" style="overflow: hidden;">
                                                <span class="close">X</span>
                                                <video id="videoPlayer" controls>
                                                    <source
                                                        src="{{ asset('clients/images_upload/About_Us/' . $a_us_item->youtube_link) }}"
                                                        type="video/mp4">
                                                </video>
                                                <iframe id="videoFrame" src="" frameborder="0"
                                                    allowfullscreen></iframe>
                                            </div>
                                        </div>
                                        <img src="{{ asset('clients/images_upload/About_Us/' . $a_us_item->vd_image) }}"
                                            alt="" style="border-radius: 50px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ***** About Area Ends ***** -->

    <!-- ***** Menu Area Starts ***** -->
    <section class="section" id="offers">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4 text-center">
                    <div class="section-heading">
                        <h6>Love the power.</h6>
                        <h6>Love the price.</h6>
                        <h2>Which product is right for you??</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" id="tabs">
                        <div class="col-lg-12">
                            <div class="heading-tabs">
                                <div class="row">
                                    <div class="col-lg-6 offset-lg-3">
                                        <ul>
                                            {{-- Category lấy từ database ra 3 mục tương ứng
                                                - Có thể fix cứng, chỉ lấy dữ liệu con
                                            --}}
                                            <li><a href='#tabs-1'><img
                                                        src="{{ asset('clients/images/logo-iphone11.jpg') }}"
                                                        alt="" width="100px">Iphone</a></li>
                                            <li><a href='#tabs-2'><img
                                                        src="{{ asset('clients/images/logo-apple-watch.png') }}"
                                                        alt="" width="100px">Smart Watch</a></a></li>
                                            <li><a href='#tabs-3'><img
                                                        src="{{ asset('clients/images/icon-desktop.png') }}"
                                                        alt="" width="100px">Desktop</a></a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:center;" class="col-lg-12">
                            <section class='tabs-content'>
                                <article id='tabs-1'>
                                    <div class="row">
                                        @foreach ($iphoneProducts as $item)
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="left-list">
                                                        <div class="col-lg-12">
                                                            <div class="tab-item">
                                                                <img src="{{ asset('clients/images_upload/products/' . $item->image) }}"
                                                                    alt="" height="120px">
                                                                <h4><a target="_blank"
                                                                        href="{{ route('single.product', $item->id) }}">{{ $item->name }}</a>
                                                                </h4>
                                                                <p>{{ $item->description }}</p>
                                                                <div class="price">
                                                                    <h6>{{ $item->price }}$</h6>
                                                                </div>
                                                                <span class="product_rating">
                                                                    @php
                                                                        $per_rate = number_format($item->average_rating, 1);
                                                                        $roundedRating = floor($item->average_rating);
                                                                    @endphp
                                                                    <span class="product_rating">
                                                                        @for ($i = 1; $i <= $roundedRating; $i++)
                                                                            <i class="fa fa-star "></i>
                                                                        @endfor

                                                                        @if ($roundedRating != 0 && $roundedRating != $item->average_rating)
                                                                            <i class="fa fa-star-half"></i>
                                                                        @endif
                                                                        <span
                                                                            class="rating_avg">({{ $per_rate }})</span>
                                                                    </span>
                                                                </span>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </article>
                                <article id='tabs-2'>
                                    <div class="row">
                                        @foreach ($appleWatchProducts as $item)
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="left-list">
                                                        <div class="col-lg-12">
                                                            <div class="tab-item">
                                                                <img src="{{ asset('clients/images_upload/products/' . $item->image) }}"
                                                                    alt="" height="120px">
                                                                <h4><a target="_blank"
                                                                        href="{{ route('single.product', $item->id) }}">{{ $item->name }}</a>
                                                                </h4>
                                                                <p>{{ $item->description }}</p>
                                                                <div class="price">
                                                                    <h6>{{ $item->price }}$</h6>
                                                                </div>
                                                                @php
                                                                    $roundedRating = floor($item->average_rating);
                                                                @endphp
                                                                <span class="product_rating">
                                                                    @for ($i = 1; $i <= $roundedRating; $i++)
                                                                        <i class="fa fa-star "></i>
                                                                    @endfor

                                                                    @if ($roundedRating != 0 && $roundedRating != $item->average_rating)
                                                                        <i class="fa fa-star-half"></i>
                                                                    @endif

                                                                    <span
                                                                        class="rating_avg">({{ $item->average_rating }})</span>
                                                                </span>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </article>
                                <article id='tabs-3'>
                                    <div class="row">
                                        @foreach ($desktopProducts as $item)
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="left-list">
                                                        <div class="col-lg-12">
                                                            <div class="tab-item">
                                                                <img src="{{ asset('clients/images_upload/products/' . $item->image) }}"
                                                                    alt="" height="120px">
                                                                <h4><a target="_blank"
                                                                        href="{{ route('single.product', $item->id) }}">{{ $item->name }}</a>
                                                                </h4>
                                                                <p>{{ $item->description }}</p>
                                                                <div class="price">
                                                                    <h6>{{ $item->price }}$</h6>
                                                                </div>
                                                                <span class="product_rating">
                                                                    @php
                                                                        $roundedRating = floor($item->average_rating);
                                                                    @endphp
                                                                    <span class="product_rating">
                                                                        @for ($i = 1; $i <= $roundedRating; $i++)
                                                                            <i class="fa fa-star "></i>
                                                                        @endfor

                                                                        @if ($roundedRating != 0 && $roundedRating != $item->average_rating)
                                                                            <i class="fa fa-star-half"></i>
                                                                        @endif

                                                                        <span
                                                                            class="rating_avg">({{ $item->average_rating }})</span>
                                                                    </span>
                                                                </span>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </article>
                            </section>
                            <br>
                            <a href="/menu"><input style="color:#fff; background-color:#264653; font-size:20px;"
                                    class="btn" type="submit" value="Browse All"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ***** Yearly Sale Starts -->
    {{-- Di chuyển đến trang chỉ hiển thị sản phẩm giảm giá  --}}
    <section id="yearly-sale" class="bg-light-blue overflow-hidden mt-5 padding-xlarge"
        style="background-image: url('images/single-image1.png');background-position: right; background-repeat: no-repeat;">
        <div class="row d-flex flex-wrap align-items-center">
            <div class="col-md-6 col-sm-12">
                <div class="text-content offset-4 padding-medium">
                    <h3>10% off</h3>
                    <h2 class="display-2 pb-5 text-uppercase text-dark">New year sale</h2>
                    <a href="shop.html" class="btn btn-medium btn-dark text-uppercase btn-rounded-none">Shop Sale</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Yearly Sale Ends -->

    <!-- ***** Menu Area Starts ***** -->
    <section class="section" id="menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-heading">
                        <h6>Product Menu</h6>
                        <h2>Choose products with you</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item-carousel">
            <div class="col-lg-12">
                <div class="owl-menu-item owl-carousel">

                    @foreach ($menu as $product)
                        <div class="item">
                            <?php
                            $img = $product->image;
                            ?>
                            <div class='card'
                                style="background-image: url({{ asset('clients/images_upload/products/' . $img) }}); border-radius:15px;">

                                <div class="price">
                                    <h6>{{ $product->price }}$</h6>
                                    @if ($product->available != 'Stock')
                                        <h4>Out Of Stock</h4>
                                    @endif

                                </div>
                                <?php
                                
                                $total_rate = DB::table('rates')
                                    ->where('product_id', $product->id)
                                    ->sum('star_value');
                                
                                $total_voter = DB::table('rates')
                                    ->where('product_id', $product->id)
                                    ->count();
                                
                                if ($total_voter > 0) {
                                    $per_rate = $total_rate / $total_voter;
                                } else {
                                    $per_rate = 0;
                                }
                                
                                $per_rate = number_format($per_rate, 1);
                                
                                $whole = floor($per_rate); // 1
                                $fraction = $per_rate - $whole;
                                
                                ?>
                                <div class='info' style="opacity: 0.8;">
                                    <h1 class='title'><a target="_blank"
                                            href="{{ route('single.product', $product->id) }}">{{ $product->name }}</a>
                                    </h1>
                                    <p class='description'>{{ $product->description }}</p>
                                    <div class="main-text-button">
                                        <div class="scroll-to-section">
                                            <span class="product_rating">
                                                <span class="product_rating">
                                                    @php
                                                        $per_rate = number_format($product->average_rating, 1);
                                                        $roundedRating = floor($product->average_rating);
                                                    @endphp
                                                    @for ($i = 1; $i <= $roundedRating; $i++)
                                                        <i class="fa fa-star " style="color: #E9C46A;"></i>
                                                    @endfor

                                                    @if ($roundedRating != 0 && $roundedRating != $product->average_rating)
                                                        <i class="fa fa-star-half" style="color: #E9C46A;"></i>
                                                    @endif
                                                    <span class="rating_avg">({{ $per_rate }})</span>
                                                </span>
                                            </span>
                                            <br>
                                            <a href="/rate/{{ $product->id }}" style="color:#E9C46A;">Rate this</a>
                                            <p>Quantity: </p>
                                            @if ($product->available == 'Stock')
                                                <form method="post" action="{{ route('cart.store', $product->id) }}">
                                                    @csrf
                                                    <input type="number" name="number" style="width:50px;"
                                                        id="myNumber" value="1">
                                                    <input type="submit" class="btn btn-success" value="Add product">
                                                </form>
                                            @endif

                                            @if ($product->available != 'Stock')
                                                <form method="post" action="{{ route('cart.store', $product->id) }}">
                                                    @csrf
                                                    <input type="number" name="number" style="width:50px;"
                                                        id="myNumber" value="1">
                                                    <input type="submit" class="btn btn-success" disabled
                                                        value="Add Chart">
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ***** Blog latest ***** -->
    <section id="latest-blog" class="padding-large">
        <div class="container">
            <div class="row">
                <div class="display-header d-flex justify-content-between pb-3">
                    <h2 class="display-7 text-dark text-uppercase">Latest Posts</h2>
                    <div class="btn-right">
                        {{-- Di chuyển đến website hiển thị danh sách blog --}}
                        <a href="blog.html" class="btn btn-medium btn-normal text-uppercase">Read Blog</a>
                    </div>
                </div>
                <div class="post-grid d-flex flex-wrap justify-content-between">
                    {{-- Lấy sản phẩm từ database ra 3 hạng mục --}}
                    <div class="col-lg-4 col-sm-12">
                        <div class="card_poster border-none me-3">
                            <div class="card-image">
                                <img src="{{ asset('clients/images/post-item1.jpg') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                        <div class="card-body text-uppercase">
                            <div class="card-meta text-muted">
                                <span class="meta-date">feb 22, 2023</span>
                                <span class="meta-category">- Gadgets</span>
                            </div>
                            <h3 class="card-title">
                                <a href="#">Get some cool gadgets in 2023</a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Blog latest end ***** -->

    <!-- ***** Rate ***** -->
    <section id="testimonials" class="position-relative">
        <div class="container">
            <div class="row">
                <div class="review-content position-relative">
                    <div class="swiper-icon swiper-arrow swiper-arrow-prev position-absolute d-flex align-items-center">
                        <svg class="chevron-left">
                            <use xlink:href="#chevron-left" />
                        </svg>
                    </div>
                    <div class="swiper testimonial-swiper">
                        <div class="quotation text-center">
                            <svg class="quote">
                                <use xlink:href="#quote" />
                            </svg>
                        </div>
                        <div class="swiper-wrapper">
                            @foreach ($rates as $rate)
                                <div class="swiper-slide text-center d-flex justify-content-center">
                                    <div class="review-item col-md-10">
                                        <i class="icon icon-review"></i>
                                        <blockquote>“{{ $rate->comments }}”</blockquote>
                                        <div class="rating">
                                            @for ($i = 1; $i <= $rate->star_value; $i++)
                                                <svg class="star star-fill">
                                                    <use xlink:href="#star-fill"></use>
                                                </svg>
                                            @endfor
                                            @for ($i = 1; $i <= 5 - $rate->star_value; $i++)
                                                <svg class="star star-empty">
                                                    <use xlink:href="#star-empty"></use>
                                                </svg>
                                            @endfor
                                        </div>
                                        <div class="author-detail">
                                            <div class="name text-dark text-uppercase pt-2">{{ $rate->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-icon swiper-arrow swiper-arrow-next position-absolute d-flex align-items-center">
                        <svg class="chevron-right">
                            <use xlink:href="#chevron-right" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </section>
    <!-- ***** End Rate ***** -->

    <!-- ***** Contact Us Area Starts ***** -->
    <section class="section" id="reservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Contact Us</h6>
                            <h2>I will respond to your email soon</h2>
                        </div>
                        <p>Members of MiniStore are always active to response your call.</p>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="phone">
                                    <i class="fa fa-phone"></i>
                                    <h4>Phone Numbers</h4>
                                    <span><a href="0886160515">0886160515</a>
                                        <br><a href="#">0838083515</a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="message">
                                    <i class="fa fa-envelope"></i>
                                    <h4>Emails</h4>
                                    <span><a
                                            href="mailto:truongvancuong.jvb@gmail.com">truongvancuong.jvb@gmail.com</a><br>
                                        <a href="mailto:vancuongit2021@gmail.com">vancuongit2021@gmail.com</a><br>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form">
                        <form id="contact" action="/reserve/confirm" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>Contact us for more information</h4>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" id="name" placeholder="Your Name*"
                                            required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*"
                                            placeholder="Your Email Address" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="phone" type="text" id="phone" placeholder="Phone Number*"
                                            required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" id="message" placeholder="Message" required=""></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="main-button-icon">Make A
                                            Contact</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Contact Area Ends ***** -->
    <style>
        /* Modal */
        #videoModal {
            display: none;
            align-items: center;
            justify-content: center;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            overflow: auto;
        }

        /* Modal Content */
        #videoModal .modal-content {
            position: relative;
            /* margin: 15% auto 0 auto; */
            padding: 20px;
            max-width: 1;
            background-color: #fff;
            border-radius: 10px;
        }

        /* Close Button */
        #videoModal .close {
            position: absolute;
            top: 90px;
            right: 20px;
            font-size: 50px;
            color: #ffffff;
            cursor: pointer;
        }


        /* Video Player */
        #videoPlayer {
            margin-top: 5%;
            margin-left: 5%;
            width: 100%;
            height: 100%;
            height: auto;
            overflow: hidden;

        }

        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .notification {
            display: flex;
            align-items: center;
            cursor: pointer;
            background-color: #5ce644;
            color: #fff;
            font-size: 1.2rem;
            border-radius: 4px;
            padding: 12px 18px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            animation: slide-in 0.5s ease-in-out;
        }

        .notification-icon {
            margin-right: 10px;
        }

        .notification-message {
            flex: 1;
        }

        .notification-close {
            cursor: pointer;
            margin-left: 10px;
        }

        @keyframes slide-in {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy các phần tử cần sử dụng
            const playBtn = document.querySelector('.play-btn');
            const videoModal = document.getElementById('videoModal');
            const videoPlayer = document.getElementById('videoPlayer');

            // Lắng nghe sự kiện click vào nút play
            playBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Lấy đường dẫn video từ thuộc tính data-video của thẻ a
                const videoSrc = playBtn.dataset.video;

                // Gán đường dẫn video cho thẻ source
                videoPlayer.querySelector('source').src = videoSrc;

                // Hiển thị modal video
                videoModal.style.display = 'flex';

                // Tự động phát video khi modal hiển thị
                videoPlayer.play();
            });

            // Lắng nghe sự kiện click vào nút đóng modal
            document.querySelector('.close').addEventListener('click', function() {
                // Dừng phát video
                videoPlayer.pause();

                // Ẩn modal video
                videoModal.style.display = 'none';
            });
        });
    </script>
    <script>
        // Set time hidden alert
        setTimeout(function() {
            $('.notification').hide(); // Ẩn phần tử HTML có class 'notyf'
        }, 4000); // Thời gian 1 giây
    </script>
@endsection
