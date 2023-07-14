<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Register Account</title>
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
    <form id="form-register" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
		<div class="wrapper wrapper-login">
			<div class="container container-login container-register animated fadeIn">
				<div class="left-register">
					<a href="https://rivvana.id/" target="blank_" class="logo-icon-login-register">
						<img src="<?= base_url() ?>assets/img/fegym-icon.png">
					</a>
				</div>
				<div class="right-register">
					<div class="card-login">
						<h1 class="text-dark-blue text-center mb-1">DAFTAR USER</h1>
						<h6 class="text-base text-center mb-5" style="font-size:11px">Pastikan data sudah benar</h6>
                        <div class="login-form">
                            <p class="text-dark-blue">Data Owner</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control input-pill" id="nama" name="nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label>No Hp</label>
                                        <input type="text" class="form-control input-pill" id="telp" name="telp" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control input-pill" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control input-pill" id="alamat" name="alamat" required>
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
                                    <div class="form-group">
                                        <label>Ulangi Password</label>
                                        <div class="position-relative">
                                        <input type="password" class="form-control input-pill" id="password_repet" name="password_repet" required>
                                            <div class="show-password">
                                                <i class="flaticon-interface"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-dark-blue mt-5">Data Perusahaan</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Perusahaan</label>
                                        <input type="text" class="form-control input-pill" id="nama_office" name="nama_office" required>
                                    </div>
                                    <div class="form-group">
                                        <label>No Hp Perusahaan</label>
                                        <input type="text" class="form-control input-pill" id="telp_office" name="telp_office" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Perusahaan</label>
                                        <input type="email" class="form-control input-pill" id="email_office" name="email_office" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Perusahaan</label>
                                        <input type="text" class="form-control input-pill" id="alamat_office" name="alamat_office" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-dark-blue mt-5">Data Lokasi Gym</p>
                                    <div class="form-group">
                                        <label>Kode Lokasi <sup><font>(3 char)</font></sup></label>
                                        <input type="text" class="form-control input-pill" id="kode_lokasi" name="kode_lokasi" oninput="this.value = this.value.slice(0, 3).toUpperCase()" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Lokasi</label>
                                        <input type="text" class="form-control input-pill" id="nama_lokasi" name="nama_lokasi" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Lokasi</label>
                                        <input type="text" class="form-control input-pill" id="alamat_lokasi" name="alamat_lokasi" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-dark-blue mt-5">Data Admin Gym</p>
                                    <div class="form-group">
                                        <label>Nama Admin</label>
                                        <input type="text" class="form-control input-pill" id="nama_admin" name="nama_admin" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Admin</label>
                                        <input type="email" class="form-control input-pill" id="email_admin" name="email_admin" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password Admin</label>
                                        <div class="position-relative">
                                        <input type="password" class="form-control input-pill" id="password_admin" name="password_admin" required>
                                            <div class="show-password">
                                                <i class="flaticon-interface"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="setuju">
                                    <label class="custom-control-label" for="setuju">Saya setuju dengan syarat dan ketentuan.</label>
                                </div>
                            </div>
                            <div class="form-group text-center pb-0 mt-4">
                                <button type="submit" id="register" class="btn btn-login bg-darkblue-gradient text-white">Daftar & Login</button>
                            </div>
                            <div class="information-text">
                                Sudah punya akun ? <a href="<?= base_url() ?>login" class="link text-base">Login</a>
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
		$("#register").on("click", function (e) {
			e.preventDefault();
            let validasi = document.getElementById("form-register").reportValidity();
            if (validasi) {
                var formData = new FormData(document.querySelector("#form-register"));
                if($('#password').val() != $('#password_repet').val()){
                    swal("Peringatan","Password owner tidak sama!",{
                        icon: "warning",
                        buttons:{
                            confirm:{
                                className: "btn btn-warning btn-sm",
                            },
                        },
                    });
                } else if($('#kode_lokasi').val().length != 3){
                    swal("Peringatan","Kode lokasi harus 3 character!",{
                        icon: "warning",
                        buttons:{
                            confirm:{
                                className: "btn btn-warning btn-sm",
                            },
                        },
                    });
                } else if (!$("#setuju").is(":checked")) {
                    swal("Peringatan","Syarat dan ketentuan harus dicentang untuk melanjutkan pendaftaran!",{
                        icon: "warning",
                        buttons:{
                            confirm:{
                                className: "btn btn-warning btn-sm",
                            },
                        },
                    });
                } else {
                    $("#register").prop('disabled', true);
                    $.ajax({
                        url: "home/aksi_register",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
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
                                $("#register").prop('disabled', false);
                            }else{
                                document.location.href = message + 'dashboard';
                            }
                        }
                    });
                }
            }
		});
	</script>
</body>
</html>