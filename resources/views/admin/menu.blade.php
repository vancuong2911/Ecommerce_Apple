@extends('admin/adminlayout')

@section('container')


    <a href="/add/product" type="button" class="btn btn-success" style="width:170px;height:35px;padding-top:9px;">+ Add
        Product</a>


    <br>

    <br>

    @if (Session::has('wrong'))
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Opps !</strong> {{ Session::get('wrong') }}
        </div>
        <br>
    @endif
    @if (Session::has('success'))
        <div class="success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Congrats !</strong> {{ Session::get('success') }}
        </div>
        <br>
    @endif

    <?php
    
    $i = 1;
    
    ?>
    @foreach ($products as $product)
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
        
        ?>




        @if ($i % 3 == 1)
            <div class="card-deck" style="margin-top:20px;">
        @endif

        {{-- {{ asset('assets/images/' . $product->image) }} --}}
        <div class="card">
            <img class="card-img-top" src="{{ asset('clients/images_upload/Products/' . $product->image) }}"
                style="width:100%;height:400px;" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ $product->description }}</p>

                <p style="text-transform:capitalize;">Category : {{ $product->category }}</p>

                <p style="text-transform:capitalize;">Price : {{ $product->price }} USD</p>
                @if ($product->available == 'Stock')
                    <p style="text-transform:capitalize;">Available : Stock </p>
                @endif

                @if ($product->available != 'Stock')
                    <p style="text-transform:capitalize;">Available : Out of Stock </p>
                @endif
                <span class="rating_avg">Quantity : {{ $product->quantity }}</span>


                <span class="rating_avg">Rating : {{ $per_rate }}</span>

            </div>
            <div class="card-footer">
                <small class="text-muted"><a href="{{ asset('/product/edit/' . $product->id) }}"
                        class="btn btn-primary">Edit</a>
                    <a href="{{ asset('/product/delete/' . $product->id) }}" class="btn btn-danger"
                        style="margin-left:10px;">Delete</a>



                </small>
            </div>
        </div>


        @if ($i % 3 == 0)
            </div>
        @endif



        <?php
        
        $i++;
        
        ?>
    @endforeach


    @if (($i - 1) % 3 != 0)
        @if ($fraction == 2)
            <div class="card" style="background-color:black;"></div>
        @endif

        @if ($fraction == 1)
            <div class="card" style="background-color:black;"></div>

            <div class="card" style="background-color:black;"></div>
        @endif
    @endif




@endsection()


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
