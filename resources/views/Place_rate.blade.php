<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <title>Successful Rating</title>
</head>
<style>
    body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
    }

    h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
    }
</style>

<body>
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            <i class="checkmark">✓</i>
        </div>
        <h1>Success</h1>
        <p>Thank you! <br />We received your rating </p>
        <button class="btn btn-primary" style="margin-top: 20px">
            <a href="{{ route('home') }}" style="color: #fff;">Go to back home or 10s auto go
                back</a>
        </button>
    </div>


</body>

<script>
    setTimeout(function() {
        window.location.href = "{{ route('home') }}"; //thay đổi url muốn chuyển hướng
    }, 10000); //5 giây
    // Set thời gian giảm để hiển thị màn hình
    var countdown = document.getElementById("countdown");

    var count = 5;
    var countdownInterval = setInterval(function() {
        countdown.innerHTML = count;
        count--;
        if (count < 0) {
            clearInterval(countdownInterval);
            countdown.style.display = "none";
        }
    }, 1000);
</script>

</html>
