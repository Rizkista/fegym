(function ($) {
    $.ajax({
        url: "dashboard/informasi_anggota",
        method: "GET",
        dataType: "json",
        success: function (json) {
            $('#total-anggota').html(json.total_anggota);
            $('#total-member').html(json.total_member);
            $('#member-baru').html(json.member_baru);
            $('#member-expired').html(json.member_expired);
            $('#persen-total-anggota').html(json.persen_total_anggota);
            $('#persen-total-member').html(json.persen_total_member);
            $('#persen-member-baru').html(json.persen_member_baru);
            $('#persen-member-expired').html(json.persen_member_expired);
        },
    });

    $("#grafik-statistik-pendaftaran").html("");
    Morris.Bar({
        element: 'grafik-statistik-pendaftaran',
        data: [
        { y: '01', L: 0, P: 90 },
        { y: '02', L: 0,  P: 65 },
        { y: '03', L: 50,  P: 40 },
        { y: '04', L: 75,  P: 65 },
        { y: '05', L: 50,  P: 40 },
        { y: '06', L: 75,  P: 65 },
        { y: '07', L: 0, P: 0 },
        { y: '08', L: 5, P: 7 },
        { y: '09', L: 75,  P: 65 },
        { y: '10', L: 75,  P: 65 },
        { y: '01', L: 0, P: 90 },
        { y: '02', L: 0,  P: 65 },
        { y: '03', L: 50,  P: 40 },
        { y: '04', L: 75,  P: 65 },
        { y: '05', L: 50,  P: 40 },
        { y: '06', L: 75,  P: 65 },
        { y: '07', L: 0, P: 0 },
        { y: '08', L: 5, P: 7 },
        { y: '09', L: 75,  P: 65 },
        { y: '10', L: 75,  P: 65 },
        { y: '01', L: 0, P: 90 },
        { y: '02', L: 0,  P: 65 },
        { y: '03', L: 50,  P: 40 },
        { y: '04', L: 75,  P: 65 },
        { y: '05', L: 50,  P: 40 },
        { y: '06', L: 75,  P: 65 },
        { y: '07', L: 0, P: 0 },
        { y: '08', L: 5, P: 7 },
        { y: '09', L: 75,  P: 65 },
        { y: '10', L: 75,  P: 65 },
        ],
        xkey: 'y',
        ykeys: ['L', 'P'],
        labels: ['Laki-laki', 'Perempuan'],
        resize: true,
        redraw: true,
        stacked: true,
        lineColors: ["#f77eb9"],
        barColors: ['#716aca','#35cd3a'],
        
    });
    console.log('ok')
})(jQuery);