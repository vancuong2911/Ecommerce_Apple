@extends('admin/adminlayout')

@section('container')
    <div class="row">

    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">Amount : {{ $pending_order }}</h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium"></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Pending Order</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">Amount : {{ $processing_order }}</h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium"></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Processing Order</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">Amount : {{ $cancel_order }}</h3>
                                <p class="text-danger ms-2 mb-0 font-weight-medium"></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-danger">
                                <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Cancel Order</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">Amount : {{ $complete_order }}</h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium"></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Complete Order</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Transaction History</h4>


                    {{-- <div id="chartContainer" style="height: 170px; width: 100%; background-color: transparent !important;">
                    </div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> --}}

                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">Total</h6>
                            <p class="text-muted mb-0"></p>
                        </div>
                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0">USD {{ $total }}</h6>
                        </div>
                    </div>

                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">Cash on Delivery</h6>
                            <p class="text-muted mb-0"></p>
                        </div>
                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0">USD {{ $cash_on_payment }}</h6>
                        </div>
                    </div>


                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">Online Payment</h6>
                            <p class="text-muted mb-0"></p>
                        </div>
                        {{-- <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0">USD {{ $online_payment }}</h6>
                        </div> --}}
                        <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0">0 USD</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title mb-1">Best Rating</h4>
                        <p class="text-muted mb-1">Voters</p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="preview-list">
                                @php
                                    $i = 1;
                                @endphp

                                @if (empty($per_rate))
                                    Không có đánh giá nào
                                @else
                                    @foreach ($per_rate as $prod)
                                        @if ($i > 5)
                                        @break;
                                    @endif
                                    @php
                                        $index_search = array_search($prod, $copy_product);
                                        
                                        $product_get = DB::table('products')
                                            ->where('id', $index_search)
                                            ->first();
                                        
                                        $copy_product[$index_search] = null;
                                        
                                        $voter = DB::table('rates')
                                            ->where('product_id', $index_search)
                                            ->count();
                                        $i++;
                                        
                                    @endphp
                                    <div class="preview-item border-bottom">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-primary">

                                                <img class="img-xs"
                                                    src="{{ asset('clients/images_upload/products/' . $product_get->image) }}"
                                                    alt="">

                                            </div>
                                        </div>

                                        <div class="preview-item-content d-sm-flex flex-grow">
                                            <div class="flex-grow">
                                                <h6 class="preview-subject">{{ $product_get->name }}</h6>
                                                <p class="text-muted mb-0">Rating : {{ $prod }}</p>
                                            </div>
                                            <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                                <p class="text-muted">{{ $voter }}</p>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Total Customer</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">{{ $customer }}</h2>
                            <p class="text-success ms-2 mb-0 font-weight-medium"></p>
                        </div>
                        <h6 class="text-muted font-weight-normal"></h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-codepen text-primary ms-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Total Delivery Boy</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">{{ $delivery_boy }}</h2>
                            <p class="text-success ms-2 mb-0 font-weight-medium"></p>
                        </div>
                        <h6 class="text-muted font-weight-normal"></h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-wallet-travel text-danger ms-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Total Admin</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">{{ $admin }}</h2>
                            <p class="text-danger ms-2 mb-0 font-weight-medium"></p>
                        </div>
                        <h6 class="text-muted font-weight-normal"></h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-monitor text-success ms-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Top Seller</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center;"> Product ID </th>
                                <th style="text-align:center;"> Product Name </th>
                                <th style="text-align:center;"> Price </th>
                                <th style="text-align:center;"> Quantity </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($product_cart as $prod)
                                @if ($i > 5)
                                @break;
                            @endif
                            @php
                                
                                $index_search = array_search($prod, $copy_cart);
                                
                                $product_get = DB::table('products')
                                    ->where('id', $index_search)
                                    ->first();
                                $copy_cart[$index_search] = null;
                                
                                $i++;
                                
                            @endphp

                            <tr>
                                <td style="text-align:center;"> {{ $product_get->id }} </td>
                                <td style="text-align:center;"> {{ $product_get->name }} </td>
                                <td style="text-align:center;"> {{ $product_get->price }} </td>
                                <td style="text-align:center;"> {{ $prod }} </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection()


<style>
canvas {
    background-color: ;
    color: ;

}

​
</style>
