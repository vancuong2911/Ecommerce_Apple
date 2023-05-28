@extends('layout', ['title' => 'Home'])

@section('page-content')
    <section class="hero-section position-relative bg-light-blue padding-medium">
        <div class="hero-content">
            <div class="container">
                <div class="row">
                    <div class="text-center padding-large no-padding-bottom">
                        <h1 class="display-2 text-uppercase text-dark">Shop</h1>
                        <div class="breadcrumbs">
                            <span class="item">
                                <a href="index.html">Home ></a>
                            </span>
                            <span class="item">Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="shopify-grid padding-large">
        <div class="container">
            <div class="row">
                <main class="col-md-9">
                    <div class="filter-shop d-flex justify-content-between">
                        <div class="showing-product">
                            <p>Showing 1–9 of 55 results</p>
                        </div>
                        <div class="sort-by">
                            <select id="input-sort" class="form-control" data-filter-sort="" data-filter-order=""
                                style="width: 180px">
                                <option value="">Default sorting</option>
                                <option value="">Name (A - Z)</option>
                                <option value="">Name (Z - A)</option>
                                <option value="">Price (Low-High)</option>
                                <option value="">Price (High-Low)</option>
                                <option value="">Rating (Highest)</option>
                                <option value="">Rating (Lowest)</option>
                                <option value="">Model (A - Z)</option>
                                <option value="">Model (Z - A)</option>
                            </select>
                        </div>
                    </div>
                    <div class="product-content product-store d-flex justify-content-start flex-wrap">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="product-card position-relative pe-3 pb-3 bg-light-blue p-3 rounded mb-5">
                                    <div class="rate_product_as">
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



                                        <span class="product_rating">
                                            @for ($i = 1; $i <= $whole; $i++)
                                                <i class="fa fa-star "></i>
                                            @endfor

                                            @if ($fraction != 0)
                                                <i class="fa fa-star-half"></i>
                                            @endif


                                            <span class="rating_avg">({{ $per_rate }})</span>
                                        </span>
                                    </div>
                                    <!-- image -->
                                    <div class="image-holder">
                                        <img src="{{ asset('clients/images_upload/products/' . $product->image) }}"
                                            alt="product-item" class="img-fluid">
                                    </div>
                                    <!-- image end -->

                                    <!-- product -->
                                    <div class="cart-concern position-absolute">
                                        <div class="cart-button d-flex">
                                            <div class="btn-left d-flex">

                                                <form method="post" action="{{ route('cart.store', $product->id) }}">
                                                    @csrf

                                                    @if ($product->available == 'Stock')
                                                        <input type="number" name="number"
                                                            style="width:50px; margin-right:10px" id="myNumber"
                                                            value="1">
                                                        <button class="btn btn-lg btn-black">Add to Cart</button>
                                                        <svg class="cart-outline position-absolute">
                                                            <use xlink:href="#cart-outline"></use>
                                                        </svg>
                                                    @endif
                                                    @if ($product->available != 'Stock')
                                                        <p class="btn btn-danger">Out of Stock</p>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-detail d-flex justify-content-between pt-3 pb-3">
                                        <h3 class="card-title text-uppercase">
                                            <a href="#">{{ $product->name }}</a>
                                        </h3>
                                        <span class="item-price text-primary">${{ $product->price }}</span>
                                    </div>
                                    <!-- product end -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <nav class="navigation paging-navigation text-center padding-medium" role="navigation">
                        <div class="pagination loop-pagination d-flex justify-content-center align-items-center">
                            <a href="#">
                                <svg class="chevron-left pe-3">
                                    <use xlink:href="#chevron-left"></use>
                                </svg>
                            </a>
                            <span aria-current="page" class="page-numbers current pe-3">1</span>
                            <a class="page-numbers pe-3" href="#">2</a>
                            <a class="page-numbers pe-3" href="#">3</a>
                            <a class="page-numbers pe-3" href="#">4</a>
                            <a class="page-numbers" href="#">5</a>
                            <a href="#">
                                <svg class="chevron-right ps-3">
                                    <use xlink:href="#chevron-right"></use>
                                </svg>
                            </a>
                        </div>
                    </nav>
                </main>
                <aside class="col-md-3">
                    <div class="sidebar">
                        <div class="widget-menu">
                            <div class="widget-search-bar">
                                <form role="search" method="get" class="d-flex">
                                    <input class="search-field" placeholder="Search" type="search">
                                    <div class="search-icon bg-dark">
                                        <a href="#">
                                            <svg class="search text-light">
                                                <use xlink:href="#search"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="widget-price-filter pt-3">
                            <h5 class="widget-titlewidget-title text-decoration-underline text-uppercase">Filter By Price
                            </h5>
                            <ul class="product-tags sidebar-list list-unstyled">
                                <li class="tags-item">
                                    <a href="">Less than $10</a>
                                </li>
                                <li class="tags-item">
                                    <a href="">$10- $20</a>
                                </li>
                                <li class="tags-item">
                                    <a href="">$20- $30</a>
                                </li>
                                <li class="tags-item">
                                    <a href="">$30- $40</a>
                                </li>
                                <li class="tags-item">
                                    <a href="">$40- $50</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
@endsection
