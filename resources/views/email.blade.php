<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="display: flex;
        align-items: center;
        justify-content: center;">
<style>




</style>
<div class="container"
     style="
          border: 2px solid #f4f2f2;
            height: 80vh;
            width: 650px;"
>
    <div class="email-header"
         style=" height: 100px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom:  2px solid #f4f2f2;"
    >
        <img src="https://www.admin.aqua-vim.com/co.png" alt="logo" class="logo2" style=" height: 100%;
        margin-left: 8px;">
        <img src="https://www.admin.aqua-vim.com/aqua.png" alt="logo" style="      height: 40px;
        margin-right: 5px;">
    </div>
    <div class="email-content">
        <div class="content-header" style="display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 7px;">
            <div class="infoBlock" style="    padding: 8px;
    height: 150px;
    padding-top: 40px;">
                <div class="infoblk" style="display: flex;
    justify-content: space-between;
    font-size: 16px;
    margin-bottom: 7px;">
                    <div class="attribute" style=" color: #999;">First Name </div>
                    <div class="value" style="    margin-left: 30px;
    color: #999;
    text-align: left;">{{ $firstName }}</div>
                </div>
                <div class="infoblk" style="display: flex;
    justify-content: space-between;
    font-size: 16px;
    margin-bottom: 7px;">
                    <div class="attribute" style=" color: #999;">Last Name :</div>
                    <div class="value" style="    margin-left: 30px;
    color: #999;
    text-align: left;">{{ $lastName }}</div>
                </div>
                <div class="infoblk" style="display: flex;
    justify-content: space-between;
    font-size: 16px;
    margin-bottom: 7px;">
                    <div class="attribute" style=" color: #999;">Phone Number :</div>
                    <div class="value" style="    margin-left: 30px;
    color: #999;
    text-align: left;">+213 {{$phone}}</div>
                </div>
                <div class="infoblk" style="display: flex;
    justify-content: space-between;
    font-size: 16px;
    margin-bottom: 7px;">
                    <div class="attribute" style=" color: #999;">Email Address :</div>
                    <div class="value" style="    margin-left: 30px;
    color: #999;
    text-align: left;"> {{ $email }}</div>
                </div>

            </div>
            <div class="imageBlock">
                <img src="https://www.admin.aqua-vim.com/content.png" alt="logo" class="content-h" style=" height: 190px;">
            </div>
        </div>

        <div class="message" style=" padding: 15px;">
            <div class="title" style=" color: #999;
    font-size: 18px;
    padding-bottom: 5px;
    border-bottom:2px solid #f4f2f2 ;">Message</div>
            <div class="text" style="    padding-top: 5px;color: #4a4a4a;">
                {{ $description }}
            </div>
        </div>
    </div>
</div>
</body>
</html>
