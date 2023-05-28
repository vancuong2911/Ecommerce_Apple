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
    <section id="selling-product" class="single-product padding-xlarge">
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="product-preview mb-3">
                        <img src="{{ asset('clients/images_upload/Products/' . $product->image) }}" alt="single-product"
                            class="img-fluid" style="height: 450px; margin-left: 100px">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-info">
                        <div class="element-header">
                            <h3 itemprop="name" class="display-7 text-uppercase">{{ $product->name }}</h3>
                            <div class="rating-container d-flex align-items-center">
                                <span class="product_rating">
                                    <?php
                                    $per_rate = number_format($product->average_rating, 1);
                                    $whole = floor($per_rate);
                                    $fraction = $per_rate - $whole;
                                    ?>

                                    @for ($i = 1; $i <= $whole; $i++)
                                        <i class="fa fa-star "></i>
                                    @endfor

                                    @if ($fraction != 0)
                                        <i class="fa fa-star-half"></i>
                                    @endif

                                    <span class="rating_avg">({{ $per_rate }})</span>
                                </span>
                            </div>
                        </div>
                        <div class="product-price pt-3 pb-3">
                            <strong class="text-primary display-6 fw-bold">${{ $product->price }}</strong>
                        </div>
                        <p>{{ $product->description }}</p>
                        <div class="product-quantity">
                            <div class="stock-number text-dark">{{ $product->quantity }} in stock</div>
                            <div class="stock-button-wrap pt-3">
                                <div class="input-group product-qty">
                                    <div class="qty-button d-flex flex-wrap pt-12">
                                        @if ($product->available == 'Stock')
                                            <form method="post" action="{{ route('cart.store', $product->id) }}">
                                                @csrf
                                                <input type="number" id="myNumber" name="number"
                                                    class="form-control input-number" value="1" min="1"
                                                    max="100">
                                                <button type="submit" name="add-to-cart" value="1269"
                                                    class="btn btn-black  text-uppercase mt-3">Add to
                                                    cart</button>
                                            </form>
                                        @endif
                                        @if ($product->available != 'Stock')
                                            <button type="submit" name="add-to-cart" value="1269"
                                                class="btn btn-black  text-uppercase mt-3" disabled>Add to
                                                cart</button>
                                        @endif
                                    </div>
                                    <form action="{{ route('cart.buynow', $product->id) }}" method="get">
                                        <button type="submit" class="btn btn-primary text-uppercase me-3 mt-3">Buy
                                            now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="meta-product py-2">
                        <div class="meta-item d-flex align-items-baseline">
                            <h4 class="item-title no-margin pe-2">Category:</h4>
                            <ul class="select-list list-unstyled d-flex">
                                <li data-value="S" class="select-item">
                                    <a href="#">{{ $product->category }}</a>,
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-12" style="padding-top: 150px;">
                <div class="row bg-light-blue p-5 rounded">
                    <h2 style="margin-bottom: 15px">Reviews</h2>
                    @if ($already_rate > 0)
                        <div class="col-md-3">
                            <img src="{{ asset('clients/images_upload/products/' . $product->image) }}" class="w-100">
                        </div>
                        <div class="col-md-9">
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
                            <div class="section-heading">
                                <h2>{{ $product->name }}</h2>
                                <h4>{{ $product->price }}$</h4>
                                <p class="text-uppercase text-dark">{{ $product->description }}</p>
                            </div>
                            <div id="rate" class="rate border-top">
                                <h2>Rating of you</h2>
                                @for ($i = 1; $i <= $find_rate; $i++)
                                    <i class="fa fa-star" style="color: #E9C46A;"></i>
                                @endfor

                                <span class="rating_avg">({{ $find_rate }})</span>

                            </div>
                            <hr>
                            <div class="comments">
                                <div class="section-heading">
                                    <h2 style="color:#182c53">Comments of you</h2>
                                </div>
                                @foreach ($comments as $comment)
                                    <div class="comment">
                                        <span
                                            class="text-uppercase text-dark"style="font-size: 2rem">{{ $comment->comments }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <a href="/edit/rate/{{ $product->id }}" class="text-success btn btn-warning me-3"><b
                                        style="color:#fff">Edit
                                        Rating</b></a>
                                <a href="/delete/rate/" class="text-danger btn btn-danger"><b style="color:#fff">Delete
                                        Rating</b></a>
                            </div>
                        </div>
                    @else
                        <div class="col-md-3">
                            <img src="{{ asset('clients/images_upload/products/' . $product->image) }}" class="w-100">
                        </div>
                        <div class="col-md-9">
                            <span class="product_rating">
                                @php
                                    $roundedRating = floor($product->average_rating);
                                @endphp
                                @for ($i = 1; $i <= $roundedRating; $i++)
                                    <i class="fa fa-star " style="color: #E9C46A;"></i>
                                @endfor

                                @if ($roundedRating != 0 && $roundedRating != $product->average_rating)
                                    <i class="fa fa-star-half" style="color: #E9C46A;"></i>
                                @endif
                                <span class="rating_avg">({{ $roundedRating }})</span>
                            </span>
                            <div class="section-heading">
                                <h2>{{ $product->name }}</h2>
                                <h4>{{ $product->price }}$</h4>
                                <p>{{ $product->description }}</p>
                            </div>

                            <form method="POST" action="{{ route('store_rate') }}">
                                @csrf

                                <div class="form-group">
                                    <h4>Đánh giá:</h4>
                                    <select name="star_value" id="star_value" class="form-control">
                                        <option value="1">1 sao</option>
                                        <option value="2">2 sao</option>
                                        <option value="3">3 sao</option>
                                        <option value="4">4 sao</option>
                                        <option value="5">5 sao</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <h4>Bình luận:</h4>
                                    <textarea name="comments" id="comments" class="form-control" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Đăng bình luận</button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <style>
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
        // Set time hidden alert
        setTimeout(function() {
            $('.notification').hide(); // Ẩn phần tử HTML có class 'notyf'
        }, 4000); // Thời gian 1 giây
    </script>
@endsection
