@extends('layout', ['title' => 'Home'])

@section('page-content')

    <section class="hero-section position-relative bg-light-blue padding-medium">
        <div class="hero-content">
            <div class="container">
                <div class="row">
                    <div class="text-center padding-large no-padding-bottom">
                        <h1 class="display-2 text-uppercase text-dark">Cart</h1>
                        <div class="breadcrumbs">
                            <span class="item">
                                <a href="index.html">Home ></a>
                            </span>
                            <span class="item">Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shopify-cart padding-large">
        <div class="container">
            <!-- Message Alers -->
            @if (Session::has('wrong'))
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Opps !</strong> {{ Session::get('wrong') }}
                </div>
            @endif
            @if (Session::has('success'))
                <br>
                <div class="success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Congrats !</strong> {{ Session::get('success') }}
                </div>
                <br>
            @endif
            <!-- Message Aler Ends-->

            <div class="row">
                <div class="cart-table">
                    <div class="cart-header">
                        <div class="row d-flex text-uppercase">
                            <h3 class="cart-title col-lg-4 pb-3">Product</h3>
                            <h3 class="cart-title col-lg-3 pb-3">Quantity</h3>
                            <h3 class="cart-title col-lg-4 pb-3">Subtotal</h3>
                        </div>
                    </div>
                    @php $total = 0 @endphp
                    @foreach ($carts as $product)
                        @php $total += $product['price'] * $product['quantity'] @endphp
                        <div class="cart-item border-top border-bottom padding-small">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-md-3">
                                    <div class="cart-info d-flex flex-wrap align-items-center mb-4">
                                        <div class="col-lg-5">
                                            <div class="card-image">
                                                <img src="images/cart-item1.jpg" alt="cloth" class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card-detail ps-3">
                                                <h3 class="card-title text-uppercase">
                                                    <a href="#">{{ $product->name }}</a>
                                                </h3>
                                                <div class="card-price">
                                                    <span class="money text-primary"
                                                        data-currency-usd="{{ $product->price }}">${{ $product->price }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-7">
                                    <div class="row d-flex">
                                        <div class="col-md-6">
                                            <div class="qty-field">
                                                <div class="qty-number d-flex">
                                                    <div class="quntity-button incriment-button">+</div>
                                                    <input class="spin-number-output bg-light no-margin" type="text"
                                                        readonly="" value="{{ $product->quantity }}">
                                                    <div class="quntity-button decriment-button">-</div>
                                                </div>
                                                <div class="regular-price"></div>
                                                <div class="quantity-output text-center bg-primary"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="total-price">
                                                <span class="money text-primary">${{ $product->price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-2">
                                    <div class="cart-remove">
                                        <div class="cart-remove">
                                            <a href="#">
                                                <form method="post" action="{{ route('cart.destroy', $product) }}"
                                                    onsubmit="return confirm('Sure?')">
                                                    @csrf
                                                    <button style="background: white">
                                                        <svg class="close" width="38px">
                                                            <use xlink:href="#close"></use>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <table id="cart" class="table table-condensed container">
                        @if ($total_price != 0)
                            @foreach ($extra_charge as $chrage)
                                <tr>
                                    <td>{{ $chrage->name }}</td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>

                                    <td style="text-align:center">{{ $chrage->price }} USD</td>
                                </tr>
                            @endforeach
                        @endif

                        <tfoot class="d-flex">
                            <form method="post" action="{{ route('coupon/apply') }}">
                                @csrf

                                @if ($total_price == 0)
                                    <td colspan="3" class="text-right"><strong>
                                            <p style="margin-top:8px !important;">Coupon Code</p>
                                        </strong></td>
                                    <td> <input type="text" name="code" class="form-control"
                                            id="exampleFormControlInput1" placeholder=""></td>
                                    <td> <button type="submit" class="btn btn-dark" disabled>Apply</button> </td>
                                @endif
                                @if ($total_price != 0)
                                    <td colspan="10" class="text-right"><strong>
                                            <p style="margin-top:8px !important;">Coupon Code</p>
                                        </strong></td>
                                    <td> <input type="text" name="code" class="form-control"
                                            id="exampleFormControlInput1" placeholder=""></td>
                                    <td> <button type="submit" class="btn btn-dark">Apply</button>
                                    </td>
                                @endif
                            </form>
                            <tr>
                                @php
                                    
                                    $total = $total_price + $total_extra_charge;
                                    
                                    Session::put('total', $total_price);
                                    
                                    if ($total_price != 0) {
                                        $total_price = $total_price + $total_extra_charge;
                                        $without_discount_price = $without_discount_price + $total_extra_charge;
                                    }
                                    
                                @endphp
                                <table cellspacing="0" class="table text-uppercase">
                                    <tbody>
                                        <tr class="subtotal pt-2 pb-2 border-top border-bottom">
                                            <th>Subtotal</th>
                                            <td data-title="Subtotal">
                                                <span class="price-amount amount text-primary ps-5">
                                                    <bdi>
                                                        <span
                                                            class="price-currency-symbol">$</span>{{ $without_discount_price }}
                                                    </bdi>
                                                </span>
                                            </td>
                                        </tr>
                                        <h2 class="display-7 text-uppercase text-dark pb-4">Cart Totals</h2>

                                        <tr class="order-total pt-2 pb-2 border-bottom">
                                            <th>Discount</th>
                                            <td data-title="Total">
                                                <span class="price-amount amount text-primary ps-5">
                                                    <bdi>
                                                        <span
                                                            class="price-currency-symbol">$</span>{{ $discount_price }}</bdi>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="order-total pt-2 pb-2 border-bottom">
                                            <th>Total (With Discount)</th>
                                            <td data-title="Total">
                                                <span class="price-amount amount text-primary ps-5">
                                                    <bdi>
                                                        <span
                                                            class="price-currency-symbol">$</span>{{ $total_price }}</bdi>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="button-wrap">
                {{-- <button class="btn btn-black btn-medium text-uppercase me-2 mb-3 btn-rounded-none">Update
                    Cart</button> --}}
                <a href="{{ url('/menu') }}"
                    class="btn btn-black btn-medium text-uppercase me-2 mb-3 btn-rounded-none"><i
                        class="fa fa-angle-left"></i>
                    Continue Shopping</a>

                <form style="display:inline" method="post" action="{{ route('cart.checkout', $total) }}">
                    @csrf
                    @if ($total_price == 0)
                        <button class="btn btn-black btn-medium text-uppercase mb-3 btn-rounded-none"
                            disabled>Checkout</button>
                    @else
                        <button class="btn btn-black btn-medium text-uppercase mb-3 btn-rounded-none">Proceed to
                            Checkout</button>
                    @endif
                </form>
            </div>
        </div>
    </section>
@endsection


<style>
    .alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
    }


    .success {
        padding: 20px;
        background-color: #4BB543;
        color: white;
    }


    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>
