@extends('admin/adminlayout')

@section('container')
    @foreach ($products as $product)
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Menu</h4>
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

                    <form class="forms-sample" action="{{ asset('/product/edit/process/' . $product->id) }}" method="post"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="form-group">
                            <label for="exampleInputName1">Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" class="form-control"
                                id="exampleInputName1">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea1">Description</label>
                            <textarea class="form-control" value="{{ $product->description }}" name="description" id="exampleTextarea1"
                                rows="5">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea1">Description Short</label>
                            <textarea class="form-control" value="{{ $product->description_short }}" name="description" id="exampleTextarea1"
                                rows="5">{{ $product->description_short }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword4">Price</label>
                            <input type="number" name="price" value="{{ $product->price }}" class="form-control"
                                id="exampleInputPassword4">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Category</label>
                            <select class="form-control" name="category" id="exampleSelectGender">
                                <option value="iphone" @php if($product->category=="iphone"){ echo"selected"; } @endphp>
                                    Iphone</option>
                                <option value="apple_watch"
                                    @php if($product->category=="appleWatch"){ echo"selected"; } @endphp>
                                    Apple Watch</option>
                                <option value="desktop" @php if($product->category=="desktop"){ echo"selected"; } @endphp>
                                    Desktop</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleSelectGender">Available</label>
                            <select class="form-control" name="available" id="exampleSelectGender">
                                <option @php if($product->available=="Stock"){ echo"selected"; } @endphp>Stock</option>
                                <option @php if($product->available=="Out Of Stock"){ echo"selected"; } @endphp>Out of Stock
                                </option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Is Banner</label>
                            <select class="form-control" name="is_banner" id="exampleSelectGender">
                                <option value="0">No banner</option>
                                <option value="1">Banner</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Quantity</label>
                            <input type="number" name="quantity" class="form-control" id="exampleInputPassword4">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image</label>
                            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                        </div>


                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <button class="btn btn-dark">Cancel</button>
                    </form>
                </div>
            </div>

        </div>
    @endforeach
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
