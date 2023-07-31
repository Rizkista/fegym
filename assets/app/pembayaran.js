(function ($) {
    $("#tab-1").on("click", function () {
        $('#tab-menu').val('1');
        switchmenu();
    });
    $("#tab-2").on("click", function () {
        $('#tab-menu').val('2');
        switchmenu();
    });

    switchmenu();
    function switchmenu(){
        var tab_menu = $('#tab-menu').val();
        if(tab_menu == '1'){
            $("#li-1").addClass("active");
            $("#li-2").removeClass("active");
            $("#transaksi").removeClass("none");
            $("#histori").addClass("none");
            list_transaksi();
        }else if(tab_menu == '2'){
            $("#li-1").removeClass("active");
            $("#li-2").addClass("active");
            $("#transaksi").addClass("none");
            $("#histori").removeClass("none");
            HistoryPembayaran();
        }
    }
    
    $('#pilih-lokasi').change(function() {
        $('#pilih-anggota').html('<span class="text-grey">Pilih Anggota</span>');
        $('#pilih-paket').html('<span class="text-grey">Pilih Paket</span>');
        $('#id_anggota').val('');
        $('#id_paket_gym').val('');
        $('#nt-tran-anggota').html('');
        $('#nt-tran-paket').html('');
        $('#nt-tran-harga').html('');
        $('#nt-tran-durasi').html('');
        $('#nt-tran-tanggal').html('');
        $('#tran-anggota').html('');
        $('#tran-paket').html('');
        $('#tran-harga').html('');
        $('#tran-durasi').html('');
        $('#tran-tanggal').html('');
        $('#tran-member').html('');
        $('#tgl_mulai').val('');
        $('#tgl_akhir').val('');
        list_transaksi();
    });

    $('#pilih-anggota').on('click',function(){
        $("#modal-anggota").modal();
		const id_posisi = $('input[name="id_posisi"]').val();
        if(id_posisi == 3){
            $(".lok-edit").addClass('gone');
            $("#id_lokasi").removeAttr('required');
        }else{
            $(".lok-edit").removeClass('gone');
            $("#id_lokasi").attr('required', '');
        }
        $(".anggota-show").removeClass('none');
        $(".anggota-new").addClass('none');
		$('#id_lokasi').val('');
		$('#nama_anggota').val('');
        $('#gender_anggota').val('');
		$('#telp_anggota').val('');
		$('#email_anggota').val('');
		$('#alamat_anggota').val('');
        list_transaksi();
    });

    $('#pilih-paket').on('click',function(){
        $("#modal-paket").modal();
		const id_posisi = $('input[name="id_posisi"]').val();
        const id_lokasi = $('#pilih-lokasi').val();
        if(id_posisi != 3 && id_lokasi == 0){
            $("#new_paket").prop('disabled', true);
        }else{
            $("#new_paket").prop('disabled', false);
        }
        $(".paket-show").removeClass('none');
        $(".paket-new").addClass('none');
		$('#nama_paket').val('');
		$('#harga_paket').val('');
		$('#durasi_paket').val('');
		$('#lama_durasi').val('');
		$('#status_member').val('');
        list_transaksi();
    });
    
    $('#tgl_paket').keyup(function(){
        durasi_tanggal();
        list_transaksi();
    });

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy HH:MM",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('#tgl_paket');

    function list_transaksi(){
		const id_posisi = $('input[name="id_posisi"]').val();
        const id_lokasi = $('#pilih-lokasi').val();
        if(id_posisi == 3){
            $('#info-lokasi').html($('#nama_lokasi').val());
        }else{
            $('#info-lokasi').html($('#pilih-lokasi option:selected').text());
        }

        var table_list_paket = $("#datatable-list-paket").DataTable({
            ajax: {
                url: "master/list_paket",
                type: "POST",
                data: { 
                    id_lokasi: id_lokasi,
                },
            },
            order:[], ordering:false, bDestroy:true, processing:true, bAutoWidth:false, deferRender:true, buttons:[],
            pageLength: 10,
            columnDefs: [
                {
                    "targets": '_all',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        let style = 'padding-bottom: 7px !important; padding-top: 7px !important;';
                        $(td).attr('style', style);
                    }
                }
            ],
            dom: 'Brt'+"<'row'<'col-sm-12'p>>",
            language: { emptyTable: id_posisi != 3 && id_lokasi == 0 ? "Pilih lokasi terlebih dahulu" : "Tidak ada daftar paket gym", },
            columns: [
                { data: "nama_paket" },
                { data: "harga_paket" , render: function(data, type, row, meta) {
                    return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
                }},
                { data: "durasi" , render : function ( data, type, row, meta ) {
                    const durasi = [null, 'MENIT', 'HARI', 'MINGGU', 'BULAN', 'TAHUN'];
                    return row['lama_durasi']+' '+'<sup><font color="#FF0000">'+durasi[row['durasi_paket']]+'</font></sup>';
                }},
                { data: "status_member" , render : function ( data, type, row, meta ) {
                    return data == 1 ? 'AKTIF' : 'TIDAK';
                }},
            ],
            fnDrawCallback:function(){
                $('#datatable-list-paket').attr('style','margin-top:0px; margin-bottom:0.5rem !important;');
                $('#datatable-list-paket_previous').attr('style','display:none;');
                $('#datatable-list-paket_next').attr('style','display:none;');
            },
            rowCallback:function(row,data,index){
                $('td', row).eq(1).addClass('nowraping');
                $('td', row).eq(2).addClass('nowraping');
            },
        });

        $('#list-search-paket').keyup(function(){
            var src = $(this).val().toLowerCase();
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (~data[0].toLowerCase().indexOf(src))
                    return true;
                if (~data[1].toLowerCase().indexOf(src))
                    return true;
                return false;
            })
            table_list_paket.draw(); 
            $.fn.dataTable.ext.search.pop();
        });

        var table_list_anggota = $("#datatable-list-anggota").DataTable({
            ajax: {
                url: "anggota/list_anggota",
                type: "GET",
            },
            order:[], ordering:false, bDestroy:true, processing:true, bAutoWidth:false, deferRender:true, buttons:[],
            pageLength: 10,
            columnDefs: [
                {
                    "targets": '_all',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        let style = 'padding-bottom: 7px !important; padding-top: 7px !important;';
                        $(td).attr('style', style);
                    }
                }
            ],
            dom: 'Brt'+"<'row'<'col-sm-12'p>>",
            language: { emptyTable: "Tidak ada daftar anggota", },
            columns: [
                { data: "kode_anggota" },
                { data: "nama_anggota" , render: function(data, type, row, meta) {
                    return data+' ['+row['gender_anggota']+']';
                }},
                { data: "status_member" , render : function ( data, type, row, meta ) {
                    return data == 1 ? 'AKTIF' : 'TIDAK';
                }},
            ],
            fnDrawCallback:function(){
                $('#datatable-list-anggota').attr('style','margin-top:0px; margin-bottom:0.5rem !important;');
                $('#datatable-list-anggota_previous').attr('style','display:none;');
                $('#datatable-list-anggota_next').attr('style','display:none;');
            },
            rowCallback:function(row,data,index){
                $('td', row).eq(1).addClass('nowraping');
                $('td', row).eq(2).addClass('nowraping');
            },
        });

        $('#list-search-anggota').keyup(function(){
            var src = $(this).val().toLowerCase();
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (~data[0].toLowerCase().indexOf(src))
                    return true;
                if (~data[1].toLowerCase().indexOf(src))
                    return true;
                return false;
            })
            table_list_anggota.draw(); 
            $.fn.dataTable.ext.search.pop();
        });
    }

    $('#datatable-list-anggota tbody').on( 'click', 'tr', function () {
        var list = $('#datatable-list-anggota').DataTable().row(this).data();
        if(list != undefined){
            $('#id_anggota').val(list['id_anggota']);
            $('#pilih-anggota').html(list['nama_anggota']);
            $('#tran-anggota').html('Anggota : '+list['nama_anggota']);
            $('#nt-tran-anggota').html(list['nama_anggota']);
            $("#modal-anggota").modal('hide');
            $.notify({
                icon: 'fa fa-check',
                title: 'Success',
                message: 'Anggota atas nama "'+list['nama_anggota']+'" berhasil dipilih.',
            },{
                type: 'success',
                placement: {
                    from: 'top',
                    align: 'right'
                },
                time: 500,
                delay: 2000,
            });
        }
    });

    let data_paket = [];
    $('#datatable-list-paket tbody').on( 'click', 'tr', function () {
        var list = $('#datatable-list-paket').DataTable().row(this).data();
        if(list != undefined){
            $('#id_paket_gym').val(list['id_paket_gym']);
            data_paket = [{
                nama_paket : list['nama_paket'],
                harga_paket : list['harga_paket'],
                durasi_paket : list['durasi_paket'],
                lama_durasi : list['lama_durasi'],
                status_member : list['status_member'],
            }];
            durasi_tanggal();
            countTransaksi();
            const durasi = [null, 'Menit', 'Hari', 'Minggu', 'Bulan', 'Tahun'];
            $('#pilih-paket').html(list['nama_paket']);
            $('#nt-tran-paket').html(list['nama_paket']);
            $('#nt-tran-harga').html(FormatCurrency(list['harga_paket'],true));
            $('#nt-tran-durasi').html('Durasi '+list['lama_durasi']+' '+durasi[list['durasi_paket']]);
            $('#tran-paket').html(list['nama_paket']);
            $('#tran-harga').html('<sup><font class="fw-bold">Rp </font></sup>'+FormatCurrency(list['harga_paket']));
            $('#tran-durasi').html('Durasi '+list['lama_durasi']+' '+durasi[list['durasi_paket']]);
            $('#tran-member').html(list['status_member'] == 1 ? 'AKTIF' : 'TIDAK');
            $('#tran-mtext').html('MEMBER');
            $("#modal-paket").modal('hide');
            $.notify({
                icon: 'fa fa-check',
                title: 'Success',
                message: 'Paket gym "'+list['nama_paket']+'" berhasil dipilih.',
            },{
                type: 'success',
                placement: {
                    from: 'top',
                    align: 'right'
                },
                time: 500,
                delay: 2000,
            });
        }
    });

    function durasi_tanggal(){
        let id_paket_gym = $('#id_paket_gym').val();
        let tgl_paket = $('#tgl_paket').val();
        let tanggal = null;
        if(tgl_paket.search('_') > 0){
            tanggal = null;
        }else if(tgl_paket == null || tgl_paket == ""){
            tanggal = null;
        }else{
            tanggal = tgl_paket;
        }

        if(tanggal != null && id_paket_gym != ""){
            $.ajax({
                url: "master/durasi_paket",
                method: "POST",
                dataType: "json",
                data: {
                    id_paket_gym: id_paket_gym,
                    tanggal: tanggal
                },
                success: function (data) {
                    if(data.result == 'success'){
                        $('#nt-tran-tanggal').html(data.tgl_paket);
                        $('#tran-tanggal').html(data.tgl_paket);
                        $('#tgl_mulai').val(data.tgl_mulai);
                        $('#tgl_akhir').val(data.tgl_akhir);
                    }
                },
            });
        }else{
            $('#tgl_mulai').val('');
            $('#tgl_akhir').val('');
            $('#nt-tran-tanggal').html('');
            $('#tran-tanggal').html('');
        }
    }

    $("body").on("click", "#dis1", function () {
        $("#dis1").addClass("choice");
        $("#dis2").removeClass("choice");
        $("#percent_diskon").removeClass("none");
        $("#nominal_diskon").addClass("none");
        $('input[name="jenis_diskon"]').val('1');
        $('#percent_diskon').val('');
        $('#nominal_diskon').val('0');
        countTransaksi();
    });
    $("body").on("click", "#dis2", function () {
        $("#dis1").removeClass("choice");
        $("#dis2").addClass("choice");
        $("#percent_diskon").addClass("none");
        $("#nominal_diskon").removeClass("none");
        $('input[name="jenis_diskon"]').val('2');
        $('#percent_diskon').val('0');
        $('#nominal_diskon').val('');
        countTransaksi();
    });
    $('#percent_diskon').inputmask({alias: 'percentage'}).keyup(function(){
        var val = parseInt($(this).val().split(" %").join(''));
        val = isNaN(val) ? 0 : val;
        val = val >= 100 ? 100 : val;
        val = val < 0 ? 0 : val;
        $(this).val(val);
        countTransaksi();
    });
    $('#nominal_diskon').keyup(function(){
        var val = $('#nominal_diskon').val().split(".").join('');
        var total_harga = $('#total_harga').html().split(".").join('').split("Rp ").join('');
        val = $(this).val() == '' ? 0 : val;
        var total = Number(val) >= Number(total_harga) ? total_harga : val;
        $(this).val(FormatCurrency(total));
        countTransaksi();
    });

    $("body").on("click", "#ppn1", function () {
        $("#ppn1").addClass("choice");
        $("#ppn2").removeClass("choice");
        $("#percent_ppn").removeClass("none");
        $("#nominal_ppn").addClass("none");
        $('input[name="jenis_ppn"]').val('1');
        $('#percent_ppn').val('');
        $('#nominal_ppn').val('0');
        countTransaksi();
    });
    $("body").on("click", "#ppn2", function () {
        $("#ppn1").removeClass("choice");
        $("#ppn2").addClass("choice");
        $("#percent_ppn").addClass("none");
        $("#nominal_ppn").removeClass("none");
        $('input[name="jenis_ppn"]').val('2');
        $('#percent_ppn').val('0');
        $('#nominal_ppn').val('');
        countTransaksi();
    });
    $('#percent_ppn').inputmask({alias: 'percentage'}).keyup(function(){
        var val = parseInt($(this).val().split(" %").join(''));
        val = isNaN(val) ? 0 : val;
        val = val >= 100 ? 100 : val;
        val = val < 0 ? 0 : val;
        $(this).val(val);
        countTransaksi();
    });
    $('#nominal_ppn').keyup(function(){
        countTransaksi();
    });
    
    $("body").on("click", "#jenbayar1", function () {
        $("#jenbayar1").addClass("choice");
        $("#jenbayar2").removeClass("choice");
        $("#jenbayar3").removeClass("choice");
        $("#payment_bank").addClass("none");
        $("#payment_walet").addClass("none");
        $(".non-tunai").addClass("none");
        $('#charge').val('');
        $('input[name="jenis_pembayaran"]').val('1');
        $('input[name="tipe_bayar"]').val('Tunai');
        countTransaksi();
    });
    $("body").on("click", "#jenbayar2", function () {
        $("#jenbayar1").removeClass("choice");
        $("#jenbayar2").addClass("choice");
        $("#jenbayar3").removeClass("choice");
        $("#payment_bank").addClass("none");
        $("#payment_walet").removeClass("none");
        $(".non-tunai").removeClass("none");
        $('#charge').val('');
        walet();
        $('select[name="payment_walet"]').change(function() {
            walet();
            countTransaksi();
        });
        function walet(){
            var jenbayar = $('select[name="payment_walet"]').val();
            $('input[name="jenis_pembayaran"]').val(jenbayar);
            $('#tipe_bayar').val($('#payment_walet option:selected').text());
        }
        countTransaksi();
    });
    $("body").on("click", "#jenbayar3", function () {
        $("#jenbayar1").removeClass("choice");
        $("#jenbayar2").removeClass("choice");
        $("#jenbayar3").addClass("choice");
        $("#payment_bank").removeClass("none");
        $("#payment_walet").addClass("none");
        $(".non-tunai").removeClass("none");
        $('#charge').val('');
        bank();
        $('select[name="payment_bank"]').change(function() {
            bank();
            countTransaksi();
        });
        function bank(){
            var jenbayar = $('select[name="payment_bank"]').val();
            $('input[name="jenis_pembayaran"]').val(jenbayar);
            $('#tipe_bayar').val($('#payment_bank option:selected').text());
        }
        countTransaksi();
    });
    $('#charge').inputmask({alias: 'percentage'}).keyup(function(){
        var val = parseInt($(this).val().split(" %").join(''));
        val = isNaN(val) ? 0 : val;
        val = val >= 100 ? 100 : val;
        val = val < 0 ? 0 : val;
        $(this).val(val);
        countTransaksi();
    });
    
    $('#nominal_dibayar').keyup(function(){
        countTransaksi();
    });
    
    function countTransaksi(){
        if(data_paket.length > 0){
            let total_transaksi = 0;
            let percent_diskon = 0;
            let nominal_diskon = 0;
            let percent_ppn = 0;
            let nominal_ppn = 0;
            let percent_charge = 0;
            let nominal_charge = 0;
            let dibayar = 0;
            let kembalian = 0;

            let nama_paket = data_paket[0].nama_paket;
            let total_harga = data_paket[0].harga_paket;
            let durasi_paket = data_paket[0].durasi_paket;
            let lama_durasi = data_paket[0].lama_durasi;
            let status_member = data_paket[0].status_member;

            const jenis_diskon = $('#jenis_diskon').val();
            if(jenis_diskon == 1){
                percent_diskon = $('#percent_diskon').val().split(" %").join('');
                percent_diskon = percent_diskon == '' ? 0 : percent_diskon;
                nominal_diskon = total_harga * percent_diskon / 100;
            }else{
                nominal_diskon = $('#nominal_diskon').val().split(".").join('');
                nominal_diskon = nominal_diskon == '' ? 0 : nominal_diskon;
                percent_diskon = parseFloat((nominal_diskon * 100 / total_harga).toFixed(2));
                percent_diskon = isNaN(percent_diskon) ? 0 : percent_diskon;
            }

            const jenis_ppn = $('#jenis_ppn').val();
            if(jenis_ppn == 1){
                percent_ppn = $('#percent_ppn').val().split(" %").join('');
                percent_ppn = percent_ppn == '' ? 0 : percent_ppn;
                nominal_ppn = total_harga * percent_ppn / 100;
            }else{
                nominal_ppn = $('#nominal_ppn').val().split(".").join('');
                nominal_ppn = nominal_ppn == '' ? 0 : nominal_ppn;
                percent_ppn = parseFloat((nominal_ppn * 100 / total_harga).toFixed(2));
                percent_ppn = isNaN(percent_ppn) ? 0 : percent_ppn;
            }

            percent_charge = $('#charge').val().split(" %").join('');
            percent_charge = percent_charge == '' ? 0 : percent_charge;
            nominal_charge = total_harga * percent_charge / 100;

            total_transaksi = total_harga - nominal_diskon + nominal_ppn + nominal_charge;
            dibayar = $('#nominal_dibayar').val().split(".").join('');
            dibayar = dibayar == '' ? 0 : dibayar;
            kembalian = dibayar - total_transaksi;
            kembalian = kembalian < 0 ? -1 : kembalian;

            $('#total_harga').html(FormatCurrency(total_harga,true));
            $('#prc-dis').html('('+percent_diskon+'%)');
            $('#total_diskon').html(FormatCurrency(nominal_diskon,true));
            $('#prc-ppn').html('('+percent_ppn+'%)');
            $('#total_ppn').html(FormatCurrency(nominal_ppn,true));
            $('#prc-chr').html('('+percent_charge+'%)');
            $('#total_charge').html(FormatCurrency(nominal_charge,true));
            $('#total_transaksi').html(FormatCurrency(total_transaksi,true));
            $('#jumlah_dibayar').html(FormatCurrency(dibayar,true));
            $('#jumlah_kembalian').html(FormatCurrency(kembalian < 0 ? 0 : kembalian,true));

            let nama_tipe_bayar = $('#tipe_bayar').val();
            let id_tipe_bayar = $('#jenis_pembayaran').val();
            let id_lokasi = $('#pilih-lokasi').val();
            let id_anggota = $('#id_anggota').val();
            let id_paket_gym = $('#id_paket_gym').val();
            let tgl_mulai = $('#tgl_mulai').val();
            let tgl_akhir =$('#tgl_akhir').val();

            $('#nt-tipe').html(nama_tipe_bayar);
            $('#nt-total').html(FormatCurrency(total_transaksi,true));
            $('#nt-dibayar').html(FormatCurrency(dibayar,true));
            $('#nt-kembalian').html(FormatCurrency(kembalian < 0 ? 0 : kembalian,true));
            $('#nt-harga').html(FormatCurrency(total_harga,true));
            $('#nt-dis').html('('+percent_diskon+'%)');
            $('#nt-diskon-nom').html(FormatCurrency(nominal_diskon,true));
            $('#nt-ppn').html('('+percent_ppn+'%)');
            $('#nt-ppn-nom').html(FormatCurrency(nominal_ppn,true));
            $('#nt-chr').html('('+percent_charge+'%)');
            $('#nt-charge-nom').html(FormatCurrency(nominal_charge,true));
            $('#nt-amount').html(FormatCurrency(total_transaksi,true));

            var data = {
                nama_paket : nama_paket,
                id_lokasi : id_lokasi,
                id_tipe_bayar : id_tipe_bayar,
                id_anggota : id_anggota,
                id_paket_gym : id_paket_gym,
                durasi_paket : durasi_paket,
                lama_durasi : lama_durasi,
                status_member : status_member,
                tgl_mulai : tgl_mulai,
                tgl_akhir : tgl_akhir,
                total_harga : total_harga,
                diskon_persen : percent_diskon,
                diskon_nominal : nominal_diskon,
                ppn_persen : percent_ppn,
                ppn_nominal : nominal_ppn,
                charge_persen : percent_charge,
                charge_nominal : nominal_charge,
                total_transaksi : total_transaksi,
                dibayar : dibayar,
                kembalian : kembalian,
            };
            
            return data;
        }else{
            return false;
        }
    }

    $('body').on('click','#reset_item',function(){
        swal({
            text: 'Yakin? Transaksi pembayaran akan direset?',
            type: 'warning',
            icon : "warning",
            buttons:{
                cancel: {
                    text : 'Batal',
                    visible: true,
                    className: 'btn btn-danger'
                },
                confirm: {
                    text : 'Ya, Reset!',
                    className : 'btn btn-success'
                },
            }
        }).then((Delete) => {
            if (Delete) {
                $('#id_anggota').val('');
                location.reload();
            } else {
                swal.close();
            }
        });
    });

    $("body").on("click", "#simpan_item", function (e) {
        e.preventDefault();
        let data_transaksi = countTransaksi();
        let validasi = document.getElementById("form-pembayaran").reportValidity();
        if(validasi){
            if(!data_transaksi){
                swal("Warning", 'Tentukan data paket yang ingin dipilih!', {
                    icon: "info",
                    buttons: {
                        confirm: {
                            className: "btn btn-info",
                        },
                    },
                });
            }else if(!data_transaksi['id_anggota']){
                swal("Warning", 'Pastikan data anggota sudah dipilih!', {
                    icon: "info",
                    buttons: {
                        confirm: {
                            className: "btn btn-info",
                        },
                    },
                });
            }else if(!data_transaksi['tgl_mulai'] && !data_transaksi['tgl_akhir']){
                swal("Warning", 'Pastikan format tanggal sudah sesuai!', {
                    icon: "info",
                    buttons: {
                        confirm: {
                            className: "btn btn-info",
                        },
                    },
                });
            }else if(data_transaksi['kembalian'] < 0){
                swal("Warning", 'Nominal dibayar tidak boleh kurang dari total transaksi!', {
                    icon: "warning",
                    buttons: {
                        confirm: {
                            className: "btn btn-warning",
                        },
                    },
                });
            }else{
                swal({
                    text: 'Apakah data pembayaran sudah yakin untuk disimpan?',
                    type: 'info',
                    icon : "info",
                    buttons:{
                        cancel: {
                            text : 'Batal',
                            visible: true,
                            className: 'btn btn-danger'
                        },
                        confirm: {
                            text : 'Ya, Simpan!',
                            className : 'btn btn-success'
                        },
                    }
                }).then((Delete) => {
                    if (Delete) {
                        $.ajax({
                            url: "transaksi/simpan_pembayaran",
                            method: "POST",
                            data: data_transaksi,
                            dataType: "json",
                            success: function (json) {
                                let result = json.result;
                                let message = json.message;
                                if(result == "success"){
                                    $("#proses-1").addClass("none");
                                    $("#proses-2").removeClass("none");
                                    let detail = json.detail;
                                    $('#nt-nota').html(detail.nonota);
                                    $('#nt-tanggal').html(detail.tanggal);
                                    $('#nt-operator').html(detail.operator);
                                    $("#print_trans").attr("data-id",detail.id_pembayaran);
                                }else{
                                    notif(result, message);
                                    if(result == 'success'){
                                        $('#datatable-pembayaran').DataTable().ajax.reload();
                                    }
                                }
                            },
                        });
                    } else {
                        swal.close();
                    }
                });
            }
        }
    });

    $('body').on('click','#new_trans',function(){
        $("#print_trans").removeAttr("data-id");
        location.reload(true);
    });

    $('body').on('click','#print_trans',function(){
        let id_pembayaran = $(this).data('id');
        $.ajax({
            url: "transaksi/list_pembayaran",
            method: "POST",
            dataType: "json",
            data: {
                id_pembayaran: id_pembayaran,
            },
            success: function(json) {
                PrintNota(json);
            },
        });
    });

    function HistoryPembayaran(){
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
            history();
        }

        $('select[name="filter-lokasi"]').change(function() {
            history();
        });
        
        $('select[name="filter-status"]').change(function() {
            history();
        });

        function history(){
            var start = $('input[name="start-date"]').val();
            var end = $('input[name="end-date"]').val();
            var status = $('select[name="filter-status"]').val();
            var lokasi = $('select[name="filter-lokasi"]').val();
            var id_lokasi = lokasi == "" ? null : lokasi;
            var table_pembayaran = $("#datatable-pembayaran").DataTable({
                ajax: {
                    url: "transaksi/read_pembayaran",
                    type: "POST",
                    data: { 
                        start_date: start,
                        end_date: end,
                        status: status,
                        id_lokasi: id_lokasi
                    },
                },
                order: [],
                ordering: false,
                bDestroy: true,
                processing: true,
                bAutoWidth: false,
                deferRender: true,
                aLengthMenu: [
                    [20, 40, 60, -1],
                    [20, 40, 60, "All"],
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
                    emptyTable: "Belum ada daftar pembayaran!",
                    infoEmpty: "Tidak ada data untuk ditampilkan!",
                    info: "_START_ to _END_ of _TOTAL_ entries",
                    infoFiltered: ""
                },
                dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [],
                columns: [
                    { data: "no" },
                    { data: "date_format" },
                    { data: "nonota" },
                    { data: "nama_anggota" },
                    { data: "nama_paket" },
                    { data: "total_harga" , render: function(data, type, row, meta) {
                        return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
                    }},
                    { data: "diskon" , render: function(data, type, row, meta) {
                        return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
                    }},
                    { data: "ppn" , render: function(data, type, row, meta) {
                        return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
                    }},
                    { data: "charge" , render: function(data, type, row, meta) {
                        return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
                    }},
                    { data: "total_transaksi" , render: function(data, type, row, meta) {
                        return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
                    }},
                    { data: "aksi" , render : function ( data, type, row, meta ) {
                        return '<span class="alasan_hapus gone">'+row['alasan_hapus']+'</span>'+
                        '<div style="white-space: nowrap;">'+
                            '<button data-id="'+data+'" type="button" id="pembayaran-print" class="pembayaran-print mx-1 btn btn-icon btn-round btn-success btn-sm" title="Print">'+
                                '<i class="fa fa-print"></i>'+
                            '</button>'+
                            '<button data-id="'+data+'" type="button" id="pembayaran-remove" class="pembayaran-remove mx-1 btn btn-icon btn-round btn-danger btn-sm" title="Remove">'+
                                '<i class="fa fa-trash-alt"></i>'+
                            '</button>'+
                        '</div>';
                    }},
                ],
                rowCallback:function(row,data,index){
                    $('td', row).eq(5).addClass('nowraping');
                    $('td', row).eq(6).addClass('nowraping');
                    $('td', row).eq(7).addClass('nowraping');
                    $('td', row).eq(8).addClass('nowraping');
                    $('td', row).eq(9).addClass('nowraping');
                    $('td', row).eq(10).addClass('nowraping');
                },
                fnDrawCallback:function(){
                    var sta = $('select[name="filter-status"]').val();
                    if(sta == '1'){
                        $('#text-aksi').html('Aksi');
                        $('.pembayaran-print').removeClass('gone');
                        $('.pembayaran-remove').removeClass('gone');
                        $('.alasan_hapus').addClass('gone');
                    }else if(sta == '0'){
                        $('#text-aksi').html('Alasan');
                        $('.pembayaran-print').addClass('gone');
                        $('.pembayaran-remove').addClass('gone');
                        $('.alasan_hapus').removeClass('gone');
                    }
                }
            });
    
            saveKey();
            $('#filter-search').keyup(function(){
                saveKey();
                var src = $('input[name="filter-search"]').val().toLowerCase();
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    if (~data[2].toLowerCase().indexOf(src))
                        return true;
                    if (~data[3].toLowerCase().indexOf(src))
                        return true;
                    if (~data[4].toLowerCase().indexOf(src))
                        return true;
                        
                    return false;
                })
                table_pembayaran.draw(); 
                $.fn.dataTable.ext.search.pop();
            });
    
            function saveKey(){
                var src = $('input[name="filter-search"]').val().toLowerCase();
                if(src != undefined){
                    $('#datatable-pembayaran').DataTable().search(src).draw();
                }
            }
        }
    }
    
    $("body").on("click", "#pembayaran-print", function (e) {
        e.preventDefault();
        let id_pembayaran = $(this).data('id');
        $.ajax({
            url: "transaksi/list_pembayaran",
            method: "POST",
            dataType: "json",
            data: {
                id_pembayaran: id_pembayaran,
            },
            success: function(json) {
                PrintNota(json);
            },
        });
    });
    
    $("body").on("click", "#pembayaran-remove", function (e) {
        e.preventDefault();
        let id_pembayaran = $(this).data('id');
        var data = $("#datatable-pembayaran").DataTable().row($(this).parents("tr")).data();
        var nota = data["nonota"];
        $('input[name="id_pembayaran"]').val(id_pembayaran);
        $('#alasan-hapus').val('');
        $("#modal-hapus").modal();
        document.getElementById("no-nota").innerHTML = nota;
        $('#hapus-nota').attr('disabled',false);
    });

    $("body").on("click", "#hapus", function(e){
        e.preventDefault();
        if($("#form-alasan-hapus").valid()){
            $('#hapus').attr('disabled',true);
            $("#modal-hapus").modal('hide');
            var id_pembayaran = $('input[name="id_pembayaran"]').val();
            var alasan_hapus = $('#alasan-hapus').val();
            $.ajax({
                url: 'transaksi/remove_pembayaran',
                method: "POST",
                dataType: "json",
                data: {
                    id_pembayaran: id_pembayaran,
                    alasan_hapus: alasan_hapus,
                },
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    if(result == 'success'){
                        $('#datatable-pembayaran').DataTable().ajax.reload();
                    }
                    $('#hapus').attr('disabled',false);
                },
            });
        }
    });

    $("#new_anggota").on("click", function(){
        $(this).prop('disabled', true);
        $(".anggota-show").addClass('none');
        $(".anggota-new").removeClass('none');
		$('#id_lokasi').val('');
		$('#nama_anggota').val('');
        $('#gender_anggota').val('');
		$('#telp_anggota').val('');
		$('#email_anggota').val('');
		$('#alamat_anggota').val('');
    });
    $("#back_anggota").on("click", function(){
        $("#new_anggota").prop('disabled', false);
        $(".anggota-show").removeClass('none');
        $(".anggota-new").addClass('none');
    });
    $("#save_anggota").on("click", function(){
        let validasi = document.getElementById("form-anggota").reportValidity();
        if (validasi) {
            $('#save_anggota').prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-anggota"));
            $.ajax({
                url: "anggota/add_anggota",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    if(result == 'success'){
                        $("#new_anggota").prop('disabled', false);
                        $(".anggota-show").removeClass('none');
                        $(".anggota-new").addClass('none');
                        $('#datatable-list-anggota').DataTable().ajax.reload();
                    }
                    $('#save_anggota').prop('disabled', false);
                },
            });
        }
    });

    $("#new_paket").on("click", function(){
        $(this).prop('disabled', true);
        $(".paket-show").addClass('none');
        $(".paket-new").removeClass('none');
		$('#nama_paket').val('');
		$('#harga_paket').val('');
		$('#durasi_paket').val('');
		$('#lama_durasi').val('');
		$('#status_member').val('');
    });
    $("#back_paket").on("click", function(){
        $("#new_paket").prop('disabled', false);
        $(".paket-show").removeClass('none');
        $(".paket-new").addClass('none');
    });
    $("#save_paket").on("click", function(){
        let validasi = document.getElementById("form-paket").reportValidity();
        if (validasi) {
            $('#save_paket').prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-paket"));
            formData.append("id_lokasi", $('#pilih-lokasi').val());
            $.ajax({
                url: "master/add_paket",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    if(result == 'success'){
                        $("#new_paket").prop('disabled', false);
                        $(".paket-show").removeClass('none');
                        $(".paket-new").addClass('none');
                        $('#datatable-list-paket').DataTable().ajax.reload();
                    }
                    $('#save_paket').prop('disabled', false);
                },
            });
        }
    });
        
    function PrintNota(transaksi){
        const pembayaran = transaksi.db_pembayaran;
        const durasi = [null, 'Menit', 'Hari', 'Minggu', 'Bulan', 'Tahun'];
        const base_url = $('input[name="base_url"]').val();
        var printContents = '<style type="text/css">'+
        '                    @page {'+
        '                        size: auto;'+
        '                        margin: 0mm;'+
        '                    }'+
        '                    @media print {'+
        '                        .p-table {'+
        '                            font-family: century-gothic, sans-serif;'+
        '                            font-style: normal;'+
        '                            font-size: 13px;'+
        '                            line-height: 1.3;'+
        '                        }'+
        '                    }'+
        '                </style>'+
        '                <table class="p-table" style="width:100%;">'+
        '                    <tr '+(!pembayaran.nota_logo ? 'style="display:none"' : '')+'>'+
        '                        <td colspan="3" style="text-align:center;"><img src="'+base_url+'assets/img/logo_nota/'+pembayaran.nota_logo+'" width="90" height="90"></td>'+
        '                    </tr>'+
        '                    <tr '+(!pembayaran.nota_header ? 'style="display:none"' : '')+'>'+
        '                        <td colspan="3" style="text-align:center; white-space:pre-wrap;">'+pembayaran.nota_header+'</td>'+
        '                    </tr>'+
        '                    <tr><td colspan="3"></td></tr>'+
        '                    <tr><td colspan="3"></td></tr>'+
        '                    <tr><td colspan="3"></td></tr>'+
        '                    <tr>'+
        '                        <td style="width:49%;"></td>'+
        '                        <td style="width:2%;"></td>'+
        '                        <td style="width:49%;"></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>No.Nota</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+pembayaran.nonota+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Tanggal</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+pembayaran.tanggal+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Waktu</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+pembayaran.waktu+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Operator</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+pembayaran.operator+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Tipe Pembayaran</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+pembayaran.tipe_bayar+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="border-bottom: 1.5px dotted #000 !important"></div></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="margin-top:5px;"></div></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3">'+
        '                           <p style="margin-bottom:2px;">'+pembayaran.nama_anggota+'</p>'+
        '                           <h4 style="margin:0;"><b>'+pembayaran.nama_paket+'</b></h4>'+
        '                           <div style="margin-bottom:3px;">'+FormatCurrency(pembayaran.total_harga,true)+'</div>'+
        '                           <div> Durasi '+pembayaran.lama_durasi+' '+durasi[pembayaran.durasi_paket]+'</div>'+
        '                           <div> Aktif '+(pembayaran.durasi_paket == 1 ? pembayaran.time_aktif : pembayaran.date_aktif)+'</div>'+
        '                       </td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="margin-top:5px;"></div></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Subtotal</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(pembayaran.total_harga,true)+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Diskon ('+pembayaran.diskon_persen+'%)</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(pembayaran.diskon_nominal,true)+'</td>'+
        '                    </tr>'+
        '                    <tr '+(pembayaran.ppn_nominal > 0 ? '' : 'style="display:none"')+'>'+
        '                        <td>PPN ('+pembayaran.ppn_persen+'%)</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(pembayaran.ppn_nominal,true)+'</td>'+
        '                    </tr>'+
        '                    <tr '+(pembayaran.charge_nominal > 0 ? '' : 'style="display:none"')+'>'+
        '                        <td>Charge ('+pembayaran.charge_persen+'%)</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(pembayaran.charge_nominal,true)+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="border-bottom: 1.5px dotted #000 !important"></div></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td><b>Total Transaksi</b></td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;"><b>'+FormatCurrency(pembayaran.total_transaksi,true)+'</b></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Uang Dibayar</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(pembayaran.dibayar,true)+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Uang Kembalian</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(pembayaran.kembalian,true)+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="border-bottom: 1.5px dotted #000 !important"></div></td>'+
        '                    </tr>'+
        '                    <tr '+(!pembayaran.nota_header ? 'style="display:none"' : '')+'>'+
        '                        <td colspan="3" style="text-align:center; white-space:pre-wrap;">'+pembayaran.nota_footer+'</td>'+
        '                    </tr>'+
        '                </table>';
    
        var originalContents = document.body.innerHTML;
        var winPrint = window.open('', '', 'left=0,top=0,width=600,height=600,toolbar=1,scrollbars=1,status=0');
        winPrint.document.body.innerHTML = printContents;
        winPrint.focus();
        winPrint.print();
        winPrint.document.body.innerHTML = originalContents;
        winPrint.close();
    }

    function FormatCurrency(angka,rp=false){
        var rev = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2 = '';
        for (var i = 0; i < rev.length; i++) {
            rev2 += rev[i];
            if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                rev2 += '.';
            }
        }
        return (rp?'Rp ':'') + rev2.split('').reverse().join('') + '';
    }

    function notif(result, message, reload = null) {
        if (result == "success") {
            swal("Success", message, {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
            if(reload == 1){
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } else {
            swal("Faild", message, {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                    },
                },
            });
        }
    }

})(jQuery);