@extends('layout', ['title' => 'Home'])

@section('page-content')
    <br>
    <br>
    @if (Session::has('wrong'))
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Opps !</strong> {{ Session::get('wrong') }} <br>
        </div>
    @endif
    @if (Session::has('success'))
        <div class="success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Congrats !</strong> {{ Session::get('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div style="margin-top: 150px">
                <p id="text-area" style="font-size:50px;marigin-bottom:-20px;">Please, rate our service</p>
            </div>
        </div>
        <div class="container mt-12" style="padding-top: 60px;">
            <div class="row bg-light-blue p-5 rounded">
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
            </div>
        </div>

    </div>
@endsection
