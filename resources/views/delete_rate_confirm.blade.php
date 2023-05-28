<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
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
        <p>Thank you! <br />We deleted your rating </p>
        <br>
        <p style="color: #c36100">Auto Redirect Home 4s!</p>
    </div>
</body>
<script>
    // Lấy thời gian hiện tại
    var currentTime = new Date().getTime();
    // Thời gian chờ là 5 giây (5000 milliseconds)
    var waitTime = 4000;
    // Tính thời gian kết thúc chờ
    var endTime = currentTime + waitTime;

    // Hàm chuyển trang
    function redirect() {
        window.location.href = '/';
    }

    // Đặt thời gian chờ và chuyển trang sau khi đủ thời gian
    setTimeout(redirect, waitTime);
</script>

</html>
