<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            border: 2px solid #f4f2f2;
            height: 80vh;
            width: 650px;
        }

        .content-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px;
        }
        .infoBlock {
            padding: 8px;
            height: 150px;
            padding-top: 40px
        }
        .infoblk {

            display: flex;
            justify-content: space-between;
            font-size: 16px;
            margin-bottom: 7px;
        }

        .attribute {
            color: #999;
        }

        .value {
            margin-left: 30px;
            color: #999;
            text-align: left;
        }

        .content-h {
            height: 190px;
        }
        .message {
            padding-left: 15px;
        }
        .title {
            color: #999;
            font-size: 18px;
            padding-bottom: 5px;
            border-bottom:2px solid #f4f2f2 ;
        }

        .text {
            padding-top: 5px;color: #4a4a4a;
        }

        .logo1 {
            margin-left: 5px;
            height: 70px;
            margin-left: 8px;
        }
        .logo {
            margin-right: 5px;
            height: 40px;
        }
        .email-header-content {
            height: 100px;
            width: 650px;
            display: flex;
            align-items: center;
            text-align: center;
            border-bottom:  2px solid #f4f2f2;
        }
        .logo-blk {
            text-align: right;
            width: 50%;
        }
        .logo-blk2 {
            width: 50%;
            text-align: left;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="email-header-content">

      <div class="logo-blk2">
            <img src="https://www.admin.aqua-vim.com/co.png" alt="logo" title="my image" class="logo1">
        </div>
        <div class="logo-blk">
            <img src="https://www.admin.aqua-vim.com/aqua.png" alt="logo" class="logo">
        </div>

    </div>
    <div class="email-content">
        <div class="content-header" style="justify-content: space-between">
            <div class="infoBlock" >
                <div class="infoblk" >
                    <div class="attribute" >First Name </div>
                    <div class="value" >{{ $firstName }}</div>
                </div>
                <div class="infoblk" >
                    <div class="attribute" >Last Name :</div>
                    <div class="value" >{{ $lastName }}</div>
                </div>
                <div class="infoblk">
                    <div class="attribute" >Phone Number :</div>
                    <div class="value" >+213 {{$phone}}</div>
                </div>
                <div class="infoblk" >
                    <div class="attribute" >Email Address :</div>
                    <div class="value" > {{ $email }}</div>
                </div>

            </div>
            <div class="imageBlock">
                <img src="https://www.admin.aqua-vim.com/content.png" alt="logo" class="content-h">
            </div>
        </div>

        <div class="message" >
            <div class="title">Message</div>
            <div class="text">
                {{ $description }}
            </div>
        </div>
    </div>
</div>
</body>
</html>
