"use strict";
var check = $('input[name="login-sess"]').val();
if(check){
	$(window).ready(function () {
		$('.wait').fadeOut(1000,function(){$(this).remove();});
		$(".load").fadeIn(1000);
	});
}

$(document).ready(function() {
	if(document.getElementById('realtime')){
		$('#realtime').removeClass('loading-trans');
		$('#realtime').html(moment().format('DD MMM YYYY') + '<i class="ml-1 mr-1"></i>' + moment().format('hh:mm:ss A'));
		setInterval(function() {
			$('#realtime').html(moment().format('DD MMM YYYY') + '<i class="ml-1 mr-1"></i>' + moment().format('hh:mm:ss A'));
		}, 1000);
	}
	if(document.getElementById('notif-acc')){
		// setInterval(function() {
		// 	if(moment().format('ss') === "00"){
		// 		ajax_notif();
		// 	}
		// }, 1000);

		ajax_notif();
		function ajax_notif(){
			$.ajax({
				url: "dashboard/notification",
				method: "GET",
				dataType: "json",
				success: function (json) {
					var lembur = json.lembur;
					var ijincuti_atasan = json.ijincuti_atasan;
					var ijincuti_personalia = json.ijincuti_personalia;
					var dinasluar_atasan = json.dinasluar_atasan;
					var dinasluar_hrd = json.dinasluar_hrd;
					var dinasluar_direktur = json.dinasluar_direktur;
					var reimburse_direktur = json.reimburse_direktur;
					var reimburse_accounting = json.reimburse_accounting;

					if(lembur || ijincuti_atasan || ijincuti_personalia || dinasluar_atasan || dinasluar_hrd || dinasluar_direktur || reimburse_direktur || reimburse_accounting){
						$('.notification').removeClass('none');
						$('.notif-title').html('Terdapat notifikasi baru');
					}else{
						$('.notification').addClass('none');
						$('.notif-title').html('Tidak ada notifikasi');
					}

					var notif = "";
					if(lembur)
						notif += list_notif('ACC Lembur','acc-lembur','fax',lembur);
					if(ijincuti_atasan)
						notif += list_notif('ACC Ijin/Cuti (Atasan)','acc-ijincuti-atasan','file-signature',ijincuti_atasan);
					if(ijincuti_personalia)
						notif += list_notif('ACC Ijin/Cuti (Personalia)','acc-ijincuti-personalia','file-signature',ijincuti_personalia);
					if(dinasluar_atasan)
						notif += list_notif('ACC Dinas Diluar (Atasan)','acc-dinas-atasan','briefcase',dinasluar_atasan);
					if(dinasluar_hrd)
						notif += list_notif('ACC Dinas Diluar (HRD)','acc-dinas-hrd','briefcase',dinasluar_hrd);
					if(dinasluar_direktur)
						notif += list_notif('ACC Dinas Diluar (Direktur)','acc-dinas-direktur','briefcase',dinasluar_direktur);
					if(reimburse_direktur)
						notif += list_notif('ACC Reimburse (Direktur)','acc-dinas-direktur','money-bill',reimburse_direktur);
					if(reimburse_accounting)
						notif += list_notif('ACC Reimburse (Accounting)','acc-dinas-accounting','money-bill',reimburse_accounting);
					 
					$('#notif-acc').html(notif);
					function list_notif(text,href,icon,data){
						var base_url = $('input[name="base_url"]').val();
						return '<a href="'+base_url+href+'">'+
									'<div class="notif-icon notif-primary"><i class="fa fa-'+icon+'"></i></div>'+
									'<div class="notif-content">'+
										'<span class="block">'+text+'</span>'+
										'<span class="time">'+data+' pengajuan</span>'+
									'</div>'+
								'</a>';
					}
				},
			});
		}
	}
});

function layoutsColors() {
	$(".sidebar").is("[data-background-color]")
		? $("html").addClass("sidebar-color")
		: $("html").removeClass("sidebar-color"),
		$(".sidebar").is("[data-image]")
			? ($(".sidebar").append("<div class='sidebar-background'></div>"),
			  $(".sidebar-background").css(
					"background-image",
					'url("' + $(".sidebar").attr("data-image") + '")'
			  ))
			: ($(this).remove(".sidebar-background"),
			  $(".sidebar-background").css("background-image", ""));
}

function showPassword(a) {
	var s = $(a).parent().find("input");
	"password" === s.attr("type")
		? s.attr("type", "text")
		: s.attr("type", "password");
}

$(".nav-search .input-group > input")
	.focus(function (a) {
		$(this).parent().addClass("focus");
	})
	.blur(function (a) {
		$(this).parent().removeClass("focus");
	}),
	$(function () {
		$('[data-toggle="tooltip"]').tooltip(),
			$('[data-toggle="popover"]').popover(),
			layoutsColors();
	}),
	$(document).ready(function () {
		var a = $(".sidebar .scrollbar-inner");
		a.length > 0 && a.scrollbar();
		var s = $(".messages-scroll.scrollbar-outer");
		s.length > 0 && s.scrollbar();
		var e = $(".tasks-scroll.scrollbar-outer");
		e.length > 0 && e.scrollbar();
		var n = $(".quick-scroll");
		n.length > 0 && n.scrollbar();
		var i = $(".message-notif-scroll");
		i.length > 0 && i.scrollbar();
		var o = $(".notif-scroll");
		o.length > 0 && o.scrollbar(), $(".scroll-bar").draggable();
		var t = !1,
			l = !1,
			r = !1,
			c = !1,
			d = 0,
			g = 0,
			h = 0,
			m = 0;
		if (!t) {
			var p = $(".sidenav-toggler");
			p.on("click", function () {
				1 == d
					? ($("html").removeClass("nav_open"),
					  p.removeClass("toggled"),
					  (d = 0))
					: ($("html").addClass("nav_open"), p.addClass("toggled"), (d = 1));
			}),
				(t = !0);
		}
		if (!l) {
			var u = $(".topbar-toggler");
			u.on("click", function () {
				1 == g
					? ($("html").removeClass("topbar_open"),
					  u.removeClass("toggled"),
					  (g = 0))
					: ($("html").addClass("topbar_open"), u.addClass("toggled"), (g = 1));
			}),
				(l = !0);
		}
		if (!r) {
			var f = $(".btn-minimize");
			$("html").hasClass("sidebar_minimize") &&
				((h = 1),
				f.addClass("toggled"),
				f.html('<i class="fa fa-ellipsis-v"></i>')),
				f.on("click", function () {
					1 == h
						? ($("html").removeClass("sidebar_minimize"),
						  f.removeClass("toggled"),
						  f.html('<i class="fa fa-bars"></i>'),
						  (h = 0))
						: ($("html").addClass("sidebar_minimize"),
						  f.addClass("toggled"),
						  f.html('<i class="fa fa-ellipsis-v"></i>'),
						  (h = 1)),
						$(window).resize();
				}),
				(r = !0);
		}
		if (!c) {
			var b = $(".page-sidebar-toggler");
			b.on("click", function () {
				1 == m
					? ($("html").removeClass("pagesidebar_open"),
					  b.removeClass("toggled"),
					  (m = 0))
					: ($("html").addClass("pagesidebar_open"),
					  b.addClass("toggled"),
					  (m = 1));
			});
			$(".page-sidebar .back").on("click", function () {
				$("html").removeClass("pagesidebar_open"),
					b.removeClass("toggled"),
					(m = 0);
			}),
				(c = !0);
		}
		$(".sidebar").hover(
			function () {
				$("html").hasClass("sidebar_minimize") &&
					$("html").addClass("sidebar_minimize_hover");
			},
			function () {
				$("html").hasClass("sidebar_minimize") &&
					$("html").removeClass("sidebar_minimize_hover");
			}
		),
			$(".nav-item a").on("click", function () {
				$(this).parent().find(".collapse").hasClass("show")
					? $(this).parent().removeClass("submenu")
					: $(this).parent().addClass("submenu");
			}),
			$(".messages-contact .user a").on("click", function () {
				$(".tab-chat").addClass("show-chat");
			}),
			$(".messages-wrapper .return").on("click", function () {
				$(".tab-chat").removeClass("show-chat");
			}),
			$('[data-select="checkbox"]').change(function () {
				var a = $(this).attr("data-target");
				$(a).prop("checked", $(this).prop("checked"));
			}),
			$(".form-group-default .form-control")
				.focus(function () {
					$(this).parent().addClass("active");
				})
				.blur(function () {
					$(this).parent().removeClass("active");
				});
	}),
	$(".show-password").on("click", function () {
		showPassword(this);
	});
