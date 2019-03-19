<!DOCTYPE html>
<html lang="en"
      style="
      color: #474747;
      font-weight: normal;"
>
<head>
    <title>Confirm Register</title>
</head>
<body style="
  top: 0;
  left: 0;
  margin: auto;
  background: #f5f5f5;
">

<div style="width: 100%;
  height: 100%;
  margin-top: 10%;
	margin: 10px 10px 10px 10px;" align="center">

    <!-- Logo & logo container -->
    <div style="
    margin-top: 5%;
    width: 800px;
    overflow: hidden;"
    >
        <div class="logo">
            <img src="http://www.logospng.com/images/91/vector-business-people-circle-download-logos-free-91002.png" height="50%" width="44%">
            <br /><br />
        </div>
    </div>
    <!---------->


    <!-- MAIL CONTENT -->
    <div style="width: 800px;
  height: 100%;
  background: #fff;
  border-top: 3px solid #d1d1d1;
	-webkit-border-image: -webkit-linear-gradient(left, #0092c0 0%, #00bad7 100%);
	border-image: linear-gradient(to right, #0092c0 0%, #00bad7 100%);
	border-image-slice: 1;" align="left">
        <div style="height: 770px;
  padding: 10px 10px 10px 10px;
	border-top: 1px solid #fff;
	border-left: 1px solid #d1d1d1;
	border-right: 1px solid #d1d1d1;
	border-bottom: 1px solid #d1d1d1;">
            <h1 align="center">Xác nhận đăng ký User</h1>
            <br />
            <h3>Xin chào, chúng tôi đã nhận được thông tin đăng ký của bạn từ hệ thống</h3>
            <p>Nếu đây là bạn vui lòng <a href="{{config('app.admin_server').'/api/v1/verify-email?token='.$token}}">click vào đây</a> để xác nhận đăng ký</p>
            <p>Bỏ qua thư này nếu đây không phải bạn!</p>
            <br /><br />
            Trân trọng,<br />
            <b>Chicongst</b><br /><br />

            Team<br />
            Department<br /><br />

            E-mail: support@chicongst.com<br />
            _______<br /><br />

            Số điện thoại: +84 935 014 751<br />
            Địa chỉ: 16 Lê Quang Sung - Đà Nẵng
        </div>
        <div style="height: 30px;
  background: #fff;
	border: 1px solid #d1d1d1;
	border-top: none;
	line-height: 30px;" align="center">
            Chicongst - Just a simple man
        </div>
    </div>
    <!---------->
</div>
</body>
</html>