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
	
    $('body').on('click','#log_out_click', function(){
		swal({
			title: 'Yakin nih...?',
			type: 'warning',
			icon : "warning",
			buttons:{
				cancel: {
					text : 'Batal',
					visible: true,
					className: 'btn btn-danger'
				},
				confirm: {
					text : 'Ya, Keluar!',
					className : 'btn btn-success'
				},
			}
		}).then((Delete) => {
			if (Delete) {
				var base_url = $('input[name="base_url"]').val();
				document.location.href = base_url + 'logout';
			} else {
				swal.close();
			}
		});
    });
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
