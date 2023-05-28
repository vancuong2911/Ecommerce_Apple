@extends('admin/adminlayout')

@section('container')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Product</h4>
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

                <form class="forms-sample" action="/product/add/process" method="post" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputName1">
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea1">Description</label>
                        <textarea class="form-control" name="description" id="exampleTextarea1" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea1">Description Short</label>
                        <textarea class="form-control" name="description_short" id="exampleTextarea1" rows="5"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword4">Price</label>
                        <input type="number" name="price" class="form-control" id="exampleInputPassword4">
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectGender">Category</label>
                        <select class="form-control" name="category" id="exampleSelectGender">
                            <option value="iphone">Iphone</option>
                            <option value="ppleWatch">Apple Watch</option>
                            <option value="desktop">Desktop</option>
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
                        <label for="exampleSelectGender">Available</label>
                        <select class="form-control" name="available" id="exampleSelectGender">
                            <option>Stock</option>
                            <option>Out Of Stock</option>
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


                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>

    </div>
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
