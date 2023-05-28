@extends('layout', ['title' => 'Home'])

@section('page-content')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <div class="row justify-content-center">
        <div>
            @if ($already_rate == 0)
                <p id="text-area" style="font-size:50px;marigin-bottom:-50px;">Please, rate our service</p>
            @endif
        </div>
    </div>
    <div class="container mt-12" style="padding-top: 180px;">
        <div class="row bg-light-blue p-5 rounded">
            <div class="col-md-3">
                <img src="{{ asset('clients/images_upload/products/' . $product->image) }}" class="w-100">
            </div>
            <div class="col-md-9">
                <div class="section-heading">
                    <h2>{{ $product->name }}</h2>
                    <h4>{{ $product->price }}$</h4>
                    <p class="text-uppercase text-dark">{{ $product->description }}</p>
                </div>

                <div class="d-flex text-center">
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
                    <div id="rate" class="rate border-top">
                        <div class="section-heading">
                            <h2 style="color:#182c53">Your rating</h2>
                        </div>
                        @for ($i = $find_rate + 1; $i <= 5; $i++)
                            <label id="star{{ $i }}" class="star-label"></label>
                        @endfor
                        @for ($i = 1; $i <= $find_rate; $i++)
                            <label id="star{{ $i }}" onclick="rate({{ $i }})"
                                class="star-label active"></label>
                        @endfor
                    </div>
                </div>
                <hr>
                <div class="comments">
                    <div class="section-heading">
                        <h2 style="color:#182c53">People's comments</h2>
                    </div>
                    @foreach ($comments as $comment)
                        <div class="comment">
                            {{-- @dd($comment) --}}
                            <span class="text-uppercase text-dark"style="font-size: 2rem">{{ $comment->comments }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <a href="/edit/rate/{{ $product->id }}" class="text-success btn btn-warning me-3"><b
                            style="color:#fff">Edit
                            Rating</b></a>
                    <a href="/delete/rate/" class="text-danger btn btn-danger"><b style="color:#fff">Delete Rating</b></a>
                </div>

            </div>
        </div>
    </div>
@endsection
<style>
    p {
        font-family: Roboto;
        font-size: 3rem;
        font-weight: 600;
        color: black;
    }

    .center {
        width: 100vw;
        height: 40vh;
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;
        justify-content: center;
        align-items: center;

    }

    label {
        float: right;
        font-size: 0;
        color: #E5E5E5;
        margin: 1vw;
    }

    label::before {
        content: "\f005";
        font-family: 'Font Awesome 5 free';
        font-size: 8vh;
    }



    .active {
        color: #FCA311;
        font-weight: 900;
    }
</style>

<script>
    function rate(value) {
        clearRates(); //vacia clase active
        addRates(value); //añade clase active
    }


    //Aqui quitamos el color de las estrellas - Remove Active
    function clearRates() {
        for (var i = 1; i <= 5; i++) {
            //document.getElementById("star" +i).classList.remove("active");
        }

        document.getElementById("text-area").innerHTML = "Please, rate our service";
    }

    //Aqui añadimos el color a las estrellas - Add Active
    function addRates(value) {
        for (var i = 1; i <= value; i++) {
            document.getElementById("star" + i).classList.add("active");
        }

        document.getElementById("text-area").innerHTML = "Thank you!";
        window.location = "confirm/" + value;
    }

    //capturo cualquier click en cualquier sitio
    //si el click NO está dentro del div quitamos el color a las estrellas
    window.addEventListener("click", function(click) {
        if (!document.getElementById("rate").contains(click.target)) {
            clearRates();
        }
    })
</script>
