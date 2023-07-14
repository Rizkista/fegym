<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Login Account</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link rel="icon" href="<?= base_url() ?>assets/img/icon.png" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?= base_url() ?>assets/js/plugin/webfont/webfont.min.js"></script>
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
</head>
<body class="login">
    <form novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
		<div class="wrapper wrapper-login">
			<div class="container container-login animated fadeIn">
				<div class="left">
					<a href="https://rivvana.id/" target="blank_" class="logo-icon-login">
						<img src="<?= base_url() ?>assets/img/fegym-icon.png">
					</a>
				</div>
				<div class="right">
					<div class="card-login">
						<h1 class="text-dark-blue text-center mb-1">USER LOGIN</h1>
						<h6 class="text-base text-center mb-5" style="font-size:11px">Gym Management System</h6>
						<div class="login-form">
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control input-pill" id="email" name="email" required>
							</div>
							<div class="form-group">
								<label>Password</label>
								<div class="position-relative">
								<input type="password" class="form-control input-pill" id="password" name="password" required>
									<div class="show-password">
										<i class="flaticon-interface"></i>
									</div>
								</div>
							</div>
							<div class="forgot-login">
								<a href="#" class="link text-base">Lupa Password ?</a>
							</div>
							<div class="form-group text-center pb-0 mt-4">
								<button type="submit" id="login" class="btn btn-login bg-darkblue-gradient text-white">LOGIN</button>
							</div>
							<div class="information-text">
								Belum punya akun ? <a href="<?= base_url() ?>register" class="link text-base">Daftar</a>
							</div>
							<div class="information-text mt-0">
								<a href="<?= base_url() ?>" class="link text-base">Kembali ke beranda</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </form>
	
	<script src="<?= base_url() ?>assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="<?= base_url() ?>assets/js/core/popper.min.js"></script>
	<script src="<?= base_url() ?>assets/js/core/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/js/ready.js"></script>

	<script>
		$("#login").on("click", function (e) {
			e.preventDefault();
			let email = $('input[name="email"]').val();
			let password = $('input[name="password"]').val();
			if(email == ""){
				swal("Gagal","Email tidak boleh kosong!",{
					icon: "error",
					buttons:{
						confirm:{
							className: "btn btn-danger btn-sm",
						},
					},
				});
			} else if(password == ""){
				swal("Gagal","Password tidak boleh kosong!",{
					icon: "error",
					buttons:{
						confirm:{
							className: "btn btn-danger btn-sm",
						},
					},
				});
			} else{
				$.ajax({
					url: "home/aksi_login",
					type: "POST",
					dataType: "json",
					data: {
						'email': email,
						'password': password,
					},
					success: function(output){
						let message = output.message;
						let result = output.result;
						
						if(result == 'error'){
							swal("Gagal",message,{
								icon: "error",
								buttons:{
									confirm:{
										className: "btn btn-danger btn-sm",
									},
								},
							});
						}else{
							document.location.href = message + 'dashboard';
						}
					}
				});
			}
		});
	</script>
</body>
</html>