<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Sistem FeGym | <?= $title ?></title>
	<meta content="" name="description">
	<meta content="" name="keywords">
	
	<!-- Favicons -->
	<link rel="icon" href="<?= base_url() ?>assets/img/icon.png" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?= base_url() ?>assets/js/plugin/webfont/webfont.min.js"></script>
	<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/family.css" media="all"> -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.css" media="all">

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/morris.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/daterangepicker.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/datepicker.css">
  	<link rel="stylesheet" href="<?= base_url() ?>assets/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/select2.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.signature.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/color.calender.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/loader.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css?v=<?= $vrs ?>">

</head>
<body>
	
<!-- Loading Load -->
<input type="hidden" name="login-sess" value="<?= $this->session->userdata('login') ?>">
<?php 
	$show_lod = "";
	if($this->session->userdata('login')){
		?><div class="wait"><div class="loader-load"><div class="loader__ball"></div><div class="loader__ball"></div><div class="loader__ball"></div></div></div><?php 
		$show_lod = "none";
	}else{
		$show_lod = "";
	}
	$this->session->set_userdata('login', false); 
?>

<div class="load <?= $show_lod ?>">
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header">
				<a href="<?= base_url('dashboard') ?>" class="logo">
					<img src="<?= base_url() ?>assets/img/logo-darkblue.svg" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark2">
				<div class="container-fluid">
					<div class="collapse left-nav">
						<a onClick="window.location.href=window.location.href" class="logo pointer">
							<span class="loading-trans text-base text-12-gray shadow" id="realtime"> xx xxx xxxx xxxxxxxx xx </span>
						</a>
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown hidden-caret">
							<a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="far fa-bell"></i>
								<span class="notification none">!</span>
							</a>
							<ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
								<li>
									<div class="dropdown-title notif-title"></div>
								</li>
								<li>
									<div class="notif-center" id="notif-acc"></div>
								</li>
								<li>
									<a class="see-all" onClick="window.location.href=window.location.href">Refres notifikasi<i class="fa fa-sync-alt"></i> </a>
								</li>
							</ul>
						</li>

						<li class="nav-item dropdown hidden-caret username shadow"><?= $account['nama'] ?></li>
						<?php
							if($account['photo'] == NULL || $account['photo'] == ''){ $photo = 'profile.jpg'; }
							else{ $photo = $account['photo']; }
						?>
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="<?= base_url() ?>assets/img/photo/<?= $photo; ?>" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="<?= base_url() ?>assets/img/photo/<?= $photo; ?>" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4><?= strlen($account['nama']) > 18 ?  substr($account['nama'],0,18).'..' : $account['nama'] ?></h4>
												<p class="text-muted"><?= strlen($account['email']) > 20 ?  substr($account['email'],0,20).'..' : $account['email'] ?></p>
												<a href="<?= base_url('logout') ?>" class="btn btn-xs btn-danger btn-sm mb-0">Logout</a>
											</div>
										</div>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</div>

		<?php require_once('sidebar.php'); ?>

        <div class="main-panel">
			<div class="content">
<!-- ========================== Batas Header ========================== -->