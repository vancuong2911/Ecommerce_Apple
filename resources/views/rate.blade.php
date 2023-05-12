@extends('layout', ['title' => 'Home'])

@section('page-content')
    <div class="container">

        <div class="row justify-content-center">
            <div>

                <p id="text-area" style="font-size:50px;marigin-bottom:-50px;">Please, rate our service</p>

            </div>
        </div>
        <div class="container mt-12" style="padding-top: 180px;">
            <div class="row bg-light-blue p-5 rounded">
                <div class="col-md-3">
                    <img src="{{ asset('clients/images_upload/products/' . $products->image) }}" class="w-100">
                </div>
                <?php
                
                Session::put('product_id', $products->id);
                
                $whole = floor($per_rate); // 1
                $fraction = $per_rate - $whole;
                
                ?>


                <div class="col-md-9">
                    <span class="product_rating">
                        @for ($i = 1; $i <= $whole; $i++)
                            <i class="fa fa-star "></i>
                        @endfor

                        @if ($fraction != 0)
                            <i class="fa fa-star-half"></i>
                        @endif


                        <span class="rating_avg">({{ $per_rate }})</span>
                    </span>
                    <div class="section-heading">
                        <h2>{{ $products->name }}</h2>
                        <h4>{{ $products->price }}$</h4>
                        <p>{{ $products->description }}</p>
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
                            <textarea name="comments" id="comments" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Đăng bình luận</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
