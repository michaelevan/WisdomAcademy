<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="shortcut icon" type="image" href="{{url("assets/img/wisdom-logo.png")}}">
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/img/education-book.png'); display: flex; justify-content: center">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="POST">
                    @csrf
					<span class="login100-form-title p-b-49">Login</span>

					<div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Masukkan username anda" required>
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Masukkan password anda" required>
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
                    <b style="color: red"><i>{{ $msg ?? "" }}</i></b> <br/>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit">Login</button>
						</div>
					</div><br>
                    <div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn2"></div>
							<a href="{{url('/')}}" style="text-decoration: none">
                                <button class="login100-form-btn" type="button">
                                    Kembali
                                </button>
                            </a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
	<script src="assets/js/main.js"></script>
</body>
</html>
