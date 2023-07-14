(function ($) {
    const id_posisi = $('input[name="id_posisi"]').val();
    if(id_posisi == 1){ 
        //Dashboard Developer

    }else if(id_posisi == 2){ 
        //Dashboard Owner
        informasi_anggota();
        grafik_statistik_pendaftaran();
        pembayaran();
        penjualan();
    }else if(id_posisi == 3){ 
        //Dashboard Admin
        informasi_anggota();
        grafik_statistik_pendaftaran();
    }

    function informasi_anggota(){
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
    }

    function grafik_statistik_pendaftaran(){
        $("#date-grafik-statistik-pendaftaran").datepicker({
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months",
        }).on("changeDate", function (selected) {
            $(this).datepicker("hide");
            var date = new Date(selected.date.valueOf());
            var m = date.getMonth()+1;
            var y = date.getFullYear();
            grafik(m,y);
        });
    
        var today = new Date();
        grafik((today.getMonth()+1),today.getFullYear());
    
        function grafik(m,y){
            $.ajax({
                url: "dashboard/grafik_statistik_pendaftaran",
                method: "POST",
                dataType: "json",
                data: {
                    month: m,
                    year: y,
                },
                beforeSend: function() {
                    $("#grafik-statistik-pendaftaran").html("");
                },
                success: function (data) {
                    $("#grafik-statistik-pendaftaran").html("");
                    Morris.Bar({
                        element: 'grafik-statistik-pendaftaran',
                        data: data,
                        xkey: 'TGL',
                        ykeys: ['L', 'P'],
                        labels: ['Laki-laki', 'Perempuan'],
                        resize: true,
                        redraw: true,
                        stacked: true,
                        lineColors: ["#f77eb9"],
                        gridLineColor: ["#e6e6e6"],
                        barColors: ['#716aca','#35cd3a'],
                    });
                },
            });
        }
    }
    
    function pembayaran(){
        change();
        filter();
        $('select[name="filter-tipe1"]').change(function(){
            change();
            filter();
        });
        $('select[name="filter-lokasi1"]').change(function(){
            filter();
        });
        
        function change(){
            var tipe = $('select[name="filter-tipe1"]').val();
            if(tipe==1){
                $("#bulanan1").removeClass("none");
                $("#tahunan1").addClass("none");
                $('#avrg1').html('Rata-Rata Harian');
                bulanan();
            }else{
                $("#bulanan1").addClass("none");
                $("#tahunan1").removeClass("none");
                $('#avrg1').html('Rata-Rata Bulanan');
                tahunan();
            }
        }
        
        function bulanan(){
            $('input[name="bulan1"]').val(moment().format('MM-YYYY'));
            $('input[name="start-date1"]').val(date_string(moment().format('MM-YYYY'),'first'));
            $('input[name="end-date1"]').val(date_string(moment().format('MM-YYYY'),'last'));

            $("#bulan1").datepicker({
                format: "mm-yyyy",
                viewMode: "months", 
                minViewMode: "months",
            }).on("changeDate", function (selected) {
                $(this).datepicker("hide");
                var date = new Date(selected.date.valueOf());
                var start = date_value(date,'first');
                var end = date_value(date,'last');
                $('input[name="start-date1"]').val(start);
                $('input[name="end-date1"]').val(end);
                filter();
            });

            function date_value(d,ket){
                var m = d.getMonth()+1;
                var y = d.getFullYear();
                if(ket=='first'){
                    return y+'-'+(m < 10 ? '0'+m : m)+'-'+'01';
                }else{
                    var date = new Date(parseInt(y), parseInt(m), 0);
                    var month = date.getMonth()+1;
                    var year = date.getFullYear();
                    var date = date.getDate();
                    return year+'-'+(month < 10 ? '0'+month : month)+'-'+date;
                }
            }

            function date_string(d,ket){
                var date = new Date(parseInt(d.substring(3,7)), parseInt(d.substring(0,2)), 0);
                var month = date.getMonth()+1;
                var year = date.getFullYear();
                var date = ket == 'first' ? '01' : date.getDate();
                return year+'-'+(month < 10 ? '0'+month : month)+'-'+date;
            }
        }

        function tahunan(){
            $('input[name="tahun1"]').val(moment().format(' YYYY'));
            $('input[name="start-date1"]').val(date_string(moment().format(' YYYY'),'first'));
            $('input[name="end-date1"]').val(date_string(moment().format(' YYYY'),'last'));

            $("#tahun1").datepicker({
                format: " yyyy",
                viewMode: "years", 
                minViewMode: "years",
            }).on("changeDate", function (selected) {
                $(this).datepicker("hide");
                var date = new Date(selected.date.valueOf());
                var start = date_value(date,'first');
                var end = date_value(date,'last');
                $('input[name="start-date1"]').val(start);
                $('input[name="end-date1"]').val(end);
                filter();
            });

            function date_value(d,ket){
                var m = 1;
                var y = d.getFullYear();
                if(ket=='first'){
                    return y+'-'+(m < 10 ? '0'+m : m)+'-'+'01';
                }else{
                    var date = new Date(parseInt(y), parseInt(m), 0);
                    var month = 12;
                    var year = date.getFullYear();
                    var date = date.getDate();
                    return year+'-'+(month < 10 ? '0'+month : month)+'-'+date;
                }
            }

            function date_string(d,ket){
                var date = new Date(parseInt(d.substring(1,5)), ket == 'first' ? 1 : 12, 0);
                var month = date.getMonth()+1;
                var year = date.getFullYear();
                var date = ket == 'first' ? '01' : date.getDate();
                return year+'-'+(month < 10 ? '0'+month : month)+'-'+date;
            }
        }

        function filter(){
            
            let start_date = $('input[name="start-date1"]').val();
            let end_date = $('input[name="end-date1"]').val();
            let lokasi = $('select[name="filter-lokasi1"]').val();
            let tipe = $('select[name="filter-tipe1"]').val();
            console.log(start_date, end_date, lokasi, tipe)

            $.ajax({
                url: "dashboard/grafik_pembayaran",
                method: "POST",
                dataType: "json",
                data: {
                    start_date : $('input[name="start-date1"]').val(),
                    end_date : $('input[name="end-date1"]').val(),
                    lokasi : $('select[name="filter-lokasi1"]').val(),
                    tipe : $('select[name="filter-tipe1"]').val(),
                },
                beforeSend: function() {
                    $("#morrisLine1").html("");
                },
                success: function (json) {
                    $('#total_transaksi1').removeClass('loading');
                    $('#total_pembayaran1').removeClass('loading');
                    $('#rata_rata1').removeClass('loading');

                    $('#total_transaksi1').html(json.transaksi);
                    $('#total_pembayaran1').html(json.pembayaran);
                    $('#rata_rata1').html(json.rata_rata);
                    
                    $("#morrisLine1").html("");
                    new Morris.Line({
                        element: "morrisLine1",
                        data: json.morris,
                        xkey: "tanggal",
                        ykeys: ["value"],
                        labels: ["total"],
                        lineColors: ["#177dff"],
                        gridLineColor: ["#e6e6e6"],
                        lineWidth: "3px",
                        resize: true,
                        redraw: true,
                    });
                },
            });
        }
    }
    
    function penjualan(){
        change();
        filter();
        $('select[name="filter-tipe2"]').change(function(){
            change();
            filter();
        });
        $('select[name="filter-lokasi2"]').change(function(){
            filter();
        });
        
        function change(){
            var tipe = $('select[name="filter-tipe2"]').val();
            if(tipe==1){
                $("#bulanan2").removeClass("none");
                $("#tahunan2").addClass("none");
                $('#avrg2').html('Rata-Rata Harian');
                bulanan();
            }else{
                $("#bulanan2").addClass("none");
                $("#tahunan2").removeClass("none");
                $('#avrg2').html('Rata-Rata Bulanan');
                tahunan();
            }
        }
        
        function bulanan(){
            $('input[name="bulan2"]').val(moment().format('MM-YYYY'));
            $('input[name="start-date2"]').val(date_string(moment().format('MM-YYYY'),'first'));
            $('input[name="end-date2"]').val(date_string(moment().format('MM-YYYY'),'last'));

            $("#bulan2").datepicker({
                format: "mm-yyyy",
                viewMode: "months", 
                minViewMode: "months",
            }).on("changeDate", function (selected) {
                $(this).datepicker("hide");
                var date = new Date(selected.date.valueOf());
                var start = date_value(date,'first');
                var end = date_value(date,'last');
                $('input[name="start-date2"]').val(start);
                $('input[name="end-date2"]').val(end);
                filter();
            });

            function date_value(d,ket){
                var m = d.getMonth()+1;
                var y = d.getFullYear();
                if(ket=='first'){
                    return y+'-'+(m < 10 ? '0'+m : m)+'-'+'01';
                }else{
                    var date = new Date(parseInt(y), parseInt(m), 0);
                    var month = date.getMonth()+1;
                    var year = date.getFullYear();
                    var date = date.getDate();
                    return year+'-'+(month < 10 ? '0'+month : month)+'-'+date;
                }
            }

            function date_string(d,ket){
                var date = new Date(parseInt(d.substring(3,7)), parseInt(d.substring(0,2)), 0);
                var month = date.getMonth()+1;
                var year = date.getFullYear();
                var date = ket == 'first' ? '01' : date.getDate();
                return year+'-'+(month < 10 ? '0'+month : month)+'-'+date;
            }
        }

        function tahunan(){
            $('input[name="tahun2"]').val(moment().format(' YYYY'));
            $('input[name="start-date2"]').val(date_string(moment().format(' YYYY'),'first'));
            $('input[name="end-date2"]').val(date_string(moment().format(' YYYY'),'last'));

            $("#tahun2").datepicker({
                format: " yyyy",
                viewMode: "years", 
                minViewMode: "years",
            }).on("changeDate", function (selected) {
                $(this).datepicker("hide");
                var date = new Date(selected.date.valueOf());
                var start = date_value(date,'first');
                var end = date_value(date,'last');
                $('input[name="start-date2"]').val(start);
                $('input[name="end-date2"]').val(end);
                filter();
            });

            function date_value(d,ket){
                var m = 1;
                var y = d.getFullYear();
                if(ket=='first'){
                    return y+'-'+(m < 10 ? '0'+m : m)+'-'+'01';
                }else{
                    var date = new Date(parseInt(y), parseInt(m), 0);
                    var month = 12;
                    var year = date.getFullYear();
                    var date = date.getDate();
                    return year+'-'+(month < 10 ? '0'+month : month)+'-'+date;
                }
            }

            function date_string(d,ket){
                var date = new Date(parseInt(d.substring(1,5)), ket == 'first' ? 1 : 12, 0);
                var month = date.getMonth()+1;
                var year = date.getFullYear();
                var date = ket == 'first' ? '01' : date.getDate();
                return year+'-'+(month < 10 ? '0'+month : month)+'-'+date;
            }
        }

        function filter(){
            $.ajax({
                url: "dashboard/grafik_penjualan",
                method: "POST",
                dataType: "json",
                data: {
                    start_date : $('input[name="start-date2"]').val(),
                    end_date : $('input[name="end-date2"]').val(),
                    lokasi : $('select[name="filter-lokasi2"]').val(),
                    tipe : $('select[name="filter-tipe2"]').val(),
                },
                beforeSend: function() {
                    $("#morrisLine2").html("");
                },
                success: function (json) {
                    $('#total_transaksi2').removeClass('loading');
                    $('#total_penjualan2').removeClass('loading');
                    $('#rata_rata2').removeClass('loading');

                    $('#total_transaksi2').html(json.transaksi);
                    $('#total_penjualan2').html(json.penjualan);
                    $('#rata_rata2').html(json.rata_rata);
                    
                    $("#morrisLine2").html("");
                    new Morris.Line({
                        element: "morrisLine2",
                        data: json.morris,
                        xkey: "tanggal",
                        ykeys: ["value"],
                        labels: ["total"],
                        lineColors: ["#177dff"],
                        gridLineColor: ["#e6e6e6"],
                        lineWidth: "3px",
                        resize: true,
                        redraw: true,
                    });
                },
            });
        }
    }
})(jQuery);