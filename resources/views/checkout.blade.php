@extends('layout', ['title' => 'Home'])

@section('page-content')
    <style>
        .payment_order {
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .payment_order h1 {
            font-size: 3rem;
            margin-top: 70px;
            font-weight: 700;
        }
    </style>
    <div class="payment_order">
        <h1>Số tiền đơn hàng của bạn là {{ $total }} USD</h1><br>
        <h4 style="color:#264653">Hiện tại chúng tôi chỉ nhận tiền mặt khi nhận hàng, hãy thông cảm!</h4>
        <img src="https://i.gifer.com/Wpo3.gif" width="200px" height="200px">
        <input ng-model="myVar" type="radio" id="cod" name="cod" value="cod">
        <label for="cod"><img style="max-width:150px; margin-top: 20px;"
                src="https://th.bing.com/th/id/OIP.sZGs1UbEzOSvxu-qT05VNQHaHa?pid=ImgDet&w=512&h=512&rs=1"></label><br>
        <div ng-switch="myVar">
            @if (Auth::check())
                <div ng-switch-when="cod">
                    <form style="display:inline" method="post" action="{{ route('mails.shipped', $total) }}">
                        @csrf
                        <input class="btn btn-success" type="submit" value="Place Order">
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
