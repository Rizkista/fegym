<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Lupa Password</title>
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
						<h1 class="text-dark-blue text-center mb-1">LUPA PASSWORD</h1>
						<h6 class="text-base text-center mb-5" style="font-size:11px">Gym Management System</h6>
						<div class="card-sub text-center alert-login m-0 p-2 mb-3" style="font-size:11px">Inputkan email Anda, sistem <br> akan mengirim tautan ke pada Anda.</div>
						<div class="login-form">
                            <div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control input-pill" id="email" name="email" required>
							</div>
							<div class="form-group text-center pb-0 mt-4">
								<button type="submit" id="kirim-email" class="btn btn-login bg-darkblue-gradient text-white">Kirim Email</button>
							</div>
							<div class="information-text">
								<a href="<?= base_url() ?>login" class="link text-base">Kembali ke menu Login</a>
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
		$("#kirim-email").on("click", function (e) {
			e.preventDefault();
			let email = $('input[name="email"]').val();
			if(email == ""){
				swal("Gagal","Email tidak boleh kosong!",{
					icon: "error",
					buttons:{
						confirm:{
							className: "btn btn-danger btn-sm",
						},
					},
				});
			} else{
				$.ajax({
					url: "home/aksi_lupa_password",
					type: "POST",
					dataType: "json",
					data: {
						'email': email,
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
							$('input[name="email"]').val('');
							swal("Berhasil",message,{
								icon: "success",
								buttons:{
									confirm:{
										className: "btn btn-success",
									},
								},
							});
						}
					}
				});
			}
		});
	</script>
</body>
</html>