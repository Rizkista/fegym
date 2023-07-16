(function ($) {     
    $('#reportrange').daterangepicker({
        startDate: moment(),
        endDate: moment(),
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    },cbreport);
    cbreport(moment(),moment());
    
    function cbreport(start,end) { 
        $('input[name="daterange"]').val('');
        $('input[name="daterange"]').val(start.format('D MMMM YYYY') +' - ' + end.format('D MMMM YYYY'));
        $('input[name="start-date"]').val(start.format('YYYY-MM-DD'));
        $('input[name="end-date"]').val(end.format('YYYY-MM-DD'));
        $('#tgl-show').html(start.format('D MMMM YYYY') +' - ' + end.format('D MMMM YYYY'));
        show_laporan();
    }

    $('select[name="filter-lokasi"]').change(function() {
        show_laporan();
    });

    function show_laporan(){
        var start_date = $('input[name="start-date"]').val();
        var end_date = $('input[name="end-date"]').val();
        var lokasi = $('select[name="filter-lokasi"]').val();
        var id_lokasi = lokasi == "" ? null : lokasi;
        $('#info-lokasi').html($('#filter-lokasi option:selected').text());
        
        $.ajax({
            url: "laporan/read_rekap_kasir_paket",
            method: "POST",
            dataType: "json",
            data: {
                start_date : start_date,
                end_date : end_date,
                id_lokasi : id_lokasi,
            },
            beforeSend: function() {
                $("#tabel-rekap-kasir-paket tbody").html(
                    '<td colspan="2" style="margin:2px; width:100%; font-size:14px; height:40px; background-color:#f4f4f4;">'+
                        '<center>'+
                            '<span class="mt-2 fa-stack fa-lg"><i class="fa fa-spinner fa-spin fa-stack-2x fa-fw"></i></span>'+
                            '<p class="mt-3 mb-2">Data sedang di proses</p>'+
                        '</center>'+
                    '</td>');
            },
            success: function (list) {
                var tabel = "";
                for (var i=0; i<list.length; i++) {
                    tabel +=
                        '<tr>'+
                            '<td class="text-left text-uppercase">'+ list[i].deskripsi +'</td>'+
                            '<td class="text-right">'+ list[i].amount +'</td>'+
                        '</tr>';
                }
                $("#tabel-rekap-kasir-paket tbody").html(tabel);
            },
        });
    }

    function formatDateIDN(IDN_date){
        const months = [
            'Janurai',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        const d = new Date(IDN_date);
        const monthName = months[d.getMonth()];
        const year = d.getFullYear();
        const date = d.getDate();
        return `${date} ${monthName} ${year}`;
    }

})(jQuery);