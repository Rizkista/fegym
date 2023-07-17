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

        var main_tabel = $("#tabel-pendapatan-produk").DataTable({
            ajax: {
                url: "laporan/read_pendapatan_produk",
                type: "POST",
                data:function(data){
                   data.start_date = start_date;
                   data.end_date = end_date;
                   data.id_lokasi = id_lokasi;
                }
            },
            order: [],
            bDestroy: true,
            bAutoWidth: false,
            deferRender: true,
            ordering: false,
            aLengthMenu: [
                [-1, 20, 40, 60],
                ["All", 20, 40, 60],
            ],
            columnDefs: [
                {
                    "targets": '_all',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        let style = 'padding-bottom: 8px !important; padding-top: 8px !important;'
                        $(td).attr('style', style);
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                emptyTable: "Data tidak ditemukan!",
                infoEmpty: "Tidak ada data untuk ditampilkan!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: "",
                sLoadingRecords: "<span class='mt-2 fa-stack fa-lg'><i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                            </span><p class='mt-3 mb-2'>Data sedang diproses.</p>",
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'pageLength',
                    className: "btn btn-primary btn-icon-text wid-max-select mb-1",
                    text: '<i class="fa fa-angle-down mr-2" data-feather="check"></i>'
                            +' Entries',
                    init:function(api,node,config){
                        $(node).removeClass('btn-primary');
                        $(node).addClass('btn-secondary text-white');
                    }
                },
                {
                    extend: "excel",
                    className: "btn btn-secondary wid-max-select text-white",
                    text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            body: function ( data, row, column, node ) {
                                const nominal = [5,6,7,8,9,10];
                                return nominal.includes(column) ? data.replace(/[Rp,. ]/g, '') : data;
                            }
                        }
                    },
                    messageTop: "Dari Tanggal " + formatDateIDN(start_date) + ' - ' + formatDateIDN(end_date),
                },
                {
                    className: "btn btn-secondary wid-max-select text-white",
                    text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                    action: function (e, dt, node, config) {
                        main_tabel.ajax.reload();
                    },
                },
            ],
            columns: [
                { data: "no" },
                { data: "nama_lokasi" },
                { data: "nonota" },
                { data: "tanggal" },
                { data: "tipe_bayar" },
                { data: "harga" },
                { data: "diskon_produk" },
                { data: "diskon_transaksi" },
                { data: "ppn" },
                { data: "charge" },
                { data: "total" },
            ],
            rowCallback:function(row,data,index){
                $('td', row).eq(5).addClass('nowraping text-right');
                $('td', row).eq(6).addClass('nowraping text-right');
                $('td', row).eq(7).addClass('nowraping text-right');
                $('td', row).eq(8).addClass('nowraping text-right');
                $('td', row).eq(9).addClass('nowraping text-right');
                $('td', row).eq(10).addClass('nowraping text-right');
            },
        });

        $.ajax({
            url: "laporan/read_pendapatan_produk",
            method: "POST",
            dataType: "json",
            data: {
                start_date : start_date,
                end_date : end_date,
                id_lokasi : id_lokasi,
            },
            beforeSend: function() {
                $("#summary-pendapatan-produk tbody").html(
                    '<td colspan="8" style="margin:2px; width:100%; font-size:14px; height:40px; background-color:#f4f4f4;">'+
                        '<center>'+
                            '<span class="mt-2 fa-stack fa-lg"><i class="fa fa-spinner fa-spin fa-stack-2x fa-fw"></i></span>'+
                            '<p class="mt-3 mb-2">Data sedang di proses</p>'+
                        '</center>'+
                    '</td>');
            },
            success: function (json) {
                $('#tgl-show').html(json.tanggal);
                var summary = json.summary;
                var tabel = "";
                for (var i=0; i<summary.length; i++) {
                    let fw_bold = (i == summary.length-1 ? 'fw-bold' : '');
                    tabel +=
                        '<tr>'+
                            '<td class="'+fw_bold+'">'+ summary[i].nama_lokasi +'</td>' +
                            '<td class="border-left-0 border-right-0 text-right text-danger nowraping '+fw_bold+'">'+ summary[i].jumlah +'</td>'+
                            '<td class="border-left-0 border-right-0 text-right text-danger nowraping '+fw_bold+'">'+ summary[i].harga +'</td>'+
                            '<td class="border-left-0 border-right-0 text-right text-danger nowraping '+fw_bold+'">'+ summary[i].diskon_produk +'</td>'+
                            '<td class="border-left-0 border-right-0 text-right text-danger nowraping '+fw_bold+'">'+ summary[i].diskon_transaksi +'</td>'+
                            '<td class="border-left-0 border-right-0 text-right text-danger nowraping '+fw_bold+'">'+ summary[i].ppn +'</td>'+
                            '<td class="border-left-0 border-right-0 text-right text-danger nowraping '+fw_bold+'">'+ summary[i].charge +'</td>'+
                            '<td class="border-left-0 border-right-0 text-right text-danger nowraping fw-bold">'+ summary[i].total +'</td>'+
                        '</tr>';
                }
                if (summary == 0) {
                    $("#summary-pendapatan-produk tbody").html(
                        '<tr><td colspan="8" style="margin:2px; width:100%; font-size:14px; background-color:#f4f4f4;"><center>Data tidak ditemukan!</center></td></tr>'
                    );
                } else {
                    $("#summary-pendapatan-produk tbody").html(tabel);
                }
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