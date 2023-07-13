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
            HistoryPenjualan();
        }
    }
    
    $('#pilih-lokasi').change(function() {
        list_transaksi();
    });

    function list_transaksi(){
		const id_posisi = $('input[name="id_posisi"]').val();
        const id_lokasi = $('#pilih-lokasi').val();
        if(id_posisi == 3){
            $('#info-lokasi').html($('#nama_lokasi').val());
        }else{
            $('#info-lokasi').html($('#pilih-lokasi option:selected').text());
        }

        var table_list_produk = $("#datatable-list-produk").DataTable({
            ajax: {
                url: "pos/list_produk",
                type: "POST",
                data: { 
                    id_lokasi: id_lokasi,
                },
            },
            order:[], ordering:false, bDestroy:true, processing:true, bAutoWidth:false, deferRender:true, buttons:[],
            pageLength: 15,
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
            language: { emptyTable: id_posisi != 3 && id_lokasi == 0 ? "Pilih lokasi terlebih dahulu" : "Tidak ada daftar produk", },
            columns: [
                { data: "barcode_produk" },
                { data: "nama_produk" },
                { data: "stok_produk" },
                { data: "harga_jual" , render: function(data, type, row, meta) {
                    return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
                }},
            ],
            fnDrawCallback:function(){
                $('#datatable-list-produk').attr('style','margin-top:0px;');
                $('#datatable-list-produk_previous').attr('style','display:none;');
                $('#datatable-list-produk_next').attr('style','display:none;');
            },
            rowCallback:function(row,data,index){
                $('td', row).eq(3).addClass('nowraping');
            },
        });

        $('#list-search').keyup(function(){
            filter();
        });

        function filter(){
            var src = $('input[name="list-search"]').val().toLowerCase();
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (~data[0].toLowerCase().indexOf(src))
                    return true;
                if (~data[1].toLowerCase().indexOf(src))
                    return true;
                return false;
            })
            table_list_produk.draw(); 
            $.fn.dataTable.ext.search.pop();
        }
    }

    const qty = [];
    const dis = [];
    const arr = [];
    $('#datatable-list-produk tbody').on( 'click', 'tr', function () {
        var list = $('#datatable-list-produk').DataTable().row(this).data();
        itemBuySelected(list);
    });
    
    on_scanner();
    function on_scanner() {
        let input = document.getElementById("list-search");
        if(input != undefined){
            input.addEventListener("focus", function () {
                input.addEventListener("keypress", function (e) {
                    if (e.key === "Enter") {
                        const tab = $("#datatable-list-produk").DataTable().page.info().recordsDisplay;
                        const val = input.value;
                        if(val == '' || tab != 1){
                            return;
                        }else{
                            var list = $("#datatable-list-produk").DataTable().row({search:'applied'}).data();
                            itemBuySelected(list);
                            input.value = '';
                        }
                    }
                })
            })
        }
    }

    function itemBuySelected(list){
        var cek = false;
        let x;
        for (var i = 0; i < arr.length; i++) {
            let id_produk = arr[i].id_produk;
            if(id_produk == list.id_produk){
                cek = true;
                x = i;
            }
        }
        if(!cek){
            qty.push(1);
            dis.push(0);
            arr.push(list);
        }else{
            qty[x]= qty[x]+1;
            dis[x]= dis[x];
        }
        dataList();
    }

    $('body').on('click','#delItem',function(){
        let index = $(this).data('index');
        arr.splice(index,1);
        qty.splice(index,1);
        dis.splice(index,1);
        dataList();
    });

    function dataList(){
        var html = "";
        for (var i=0; i<arr.length; i++) {
            let id_produk = arr[i].id_produk;
            let nama_produk = arr[i].nama_produk;
            let harga_jual = arr[i].harga_jual;
            let harga_beli = arr[i].harga_beli;

            const harga_item = qty[i]*harga_jual;
            const diskon_item = harga_item*dis[i]/100;
            const price_item = harga_item-diskon_item;
            var show_price = diskon_item > 0 ? '<s style="color:gray; font-size:12px;">'+FormatCurrency(harga_item)+'</s> <br>'+FormatCurrency(price_item) : FormatCurrency(harga_item);
            
            html += '<tr>' +
                        '<input type="hidden" name="id_'+i+'" id="idt" class="form-control" value="'+id_produk+'">'+
                        '<input type="hidden" name="hrj_'+i+'" id="idt" class="form-control" value="'+harga_jual+'">'+
                        '<input type="hidden" name="hrb_'+i+'" id="idt" class="form-control" value="'+harga_beli+'">'+
                        '<input type="hidden" name="hit_'+i+'" id="idt" class="form-control" value="'+harga_item+'">'+
                        '<input type="hidden" name="pit_'+i+'" id="idt" class="form-control" value="'+price_item+'">'+
                        '<td>'+(i+1)+'.</td>' +
                        '<td>'+nama_produk+'</td>' +
                        '<td><input type="number" data-index="'+i+'" name="qty_'+i+'" id="qty" min="0" class="form-control sm-height px-1" placeholder="0" value="'+qty[i]+'" style="min-width:60px" required></td>'+
                        '<td><input type="number" data-index="'+i+'" name="dis_'+i+'" id="dis" min="0" max="100" class="form-control sm-height px-1" placeholder="0" value="'+dis[i]+'" style="min-width:60px" required></td>'+
                        '<td class="text-right text-danger" id="show-price-'+i+'">'+show_price+'</td>'+        
                        '<td class="text-center"><a id="delItem" data-index="'+i+'" class="text-danger" style="cursor:pointer;"><i class="fa fa-trash"></i></a></td>'+               
                    '</tr>';
        }
        $("#produk-item tbody").html(html);
        countTransaksi();
    }
    
    $('body').on('change keyup','input#qty',function(){
        let index = $(this).data('index');
        countPrice(index);
    });

    $('body').on('change keyup','input#dis',function(){
        let index = $(this).data('index');
        countPrice(index);
    });

    function countPrice(i){
        qty[i] = Number($('input[name="qty_'+i+'"]').val());
        dis[i] = Number($('input[name="dis_'+i+'"]').val());
        const harga_jual = $('input[name="hrj_'+i+'"]').val();
        
        const harga_item = qty[i]*harga_jual;
        const diskon_item = harga_item*dis[i]/100;
        const price_item = harga_item-diskon_item;
        var show_price = diskon_item > 0 ? '<s style="color:gray; font-size:12px;">'+FormatCurrency(harga_item)+'</s> <br>'+FormatCurrency(price_item) : FormatCurrency(harga_item);
        $('#show-price-'+i).html(show_price);

        $('input[name="hit_'+i+'"]').val(harga_item);
        $('input[name="pit_'+i+'"]').val(price_item);
        countTransaksi();
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
        let data_item = [];
        let total_transaksi = 0;
        let total_harga = 0;
        let percent_diskon = 0;
        let nominal_diskon = 0;
        let percent_ppn = 0;
        let nominal_ppn = 0;
        let percent_charge = 0;
        let nominal_charge = 0;
        let dibayar = 0;
        let kembalian = 0;

        var view = '';
        for(var i=0; i<arr.length; i++) {
            var list_item = {
                id_produk : Number($('input[name="id_'+i+'"]').val()),
                harga_beli_item : Number($('input[name="hrb_'+i+'"]').val()),
                harga_jual_item : Number($('input[name="hrj_'+i+'"]').val()),
                jml_produk_item : Number($('input[name="qty_'+i+'"]').val()),
                diskon_persen_item : Number($('input[name="dis_'+i+'"]').val()),
                diskon_nominal_item : Number($('input[name="hit_'+i+'"]').val() - $('input[name="pit_'+i+'"]').val()),
                subtotal_harga_item : Number($('input[name="pit_'+i+'"]').val()),
            };
            data_item.push(list_item);
            total_harga += Number($('input[name="pit_'+i+'"]').val());

            let qty = Number($('input[name="qty_'+i+'"]').val());
            let dis = Number($('input[name="dis_'+i+'"]').val());
            let hju = Number($('input[name="hrj_'+i+'"]').val());
            let hit = Number($('input[name="hit_'+i+'"]').val());
            let pit = Number($('input[name="pit_'+i+'"]').val());
            let sub = dis > 0 ? '<s style="color:gray; font-size:11px;">'+FormatCurrency(hit,true)+'</s><br><b>'+FormatCurrency(pit,true)+'</b>' : '<b>'+FormatCurrency(pit,true)+'</b>';
            let dsk = dis > 0 ? ' ('+dis+'%)' : '';
            view += '<tr>'+
                        '<td valign="top" style="padding:5px;">'+(i+1)+'.</td>'+
                        '<td style="padding:5px;"><b>'+arr[i].nama_produk+'</b><br>'+qty+' x '+FormatCurrency(hju,true)+dsk+'</td>'+
                        '<td style="padding:5px; text-align:right;">'+sub+'</td>'+
                    '</tr>';
        }
        $("#detail-item tbody").html(view);

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
            data_item : data_item,
            id_lokasi : id_lokasi,
            id_tipe_bayar : id_tipe_bayar,
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
    }

    $('body').on('click','#reset_item',function(){
        swal({
            text: 'Yakin? Semua item produk akan dihapus?',
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
                location.reload();
            } else {
                swal.close();
            }
        });
    });

    $("body").on("click", "#simpan_item", function (e) {
        e.preventDefault();
        const data_transaksi = countTransaksi();
        let validasi = document.getElementById("form-penjualan").reportValidity();
        if(validasi){
            if(arr.length == 0){
                swal("Warning", 'Produk harus di pilih terlebih dahulu!', {
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
                    text: 'Apakah data penjualan sudah yakin untuk disimpan?',
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
                            url: "transaksi/simpan_penjualan",
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
                                    $("#print_trans").attr("data-id",detail.id_penjualan);
                                }else{
                                    notif(result, message);
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
        let id_penjualan = $(this).data('id');
        $.ajax({
            url: "transaksi/list_penjualan",
            method: "POST",
            dataType: "json",
            data: {
                id_penjualan: id_penjualan,
            },
            success: function(json) {
                PrintNota(json);
            },
        });
    });

    function HistoryPenjualan(){
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
            var table_penjualan = $("#datatable-penjualan").DataTable({
                ajax: {
                    url: "transaksi/read_penjualan",
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
                    emptyTable: "Belum ada daftar penjualan!",
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
                    { data: "nama_item" },
                    { data: "jml_item" },
                    { data: "diskon_item" , render: function(data, type, row, meta) {
                        return data.split('Rp ').join('<sup><font color="#FF0000">Rp</font></sup> ');
                    }},
                    { data: "harga_item" , render: function(data, type, row, meta) {
                        return data.split('Rp ').join('<sup><font color="#FF0000">Rp</font></sup> ');
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
                            '<button data-id="'+data+'" type="button" id="penjualan-print" class="penjualan-print mx-1 btn btn-icon btn-round btn-success btn-sm" title="Print">'+
                                '<i class="fa fa-print"></i>'+
                            '</button>'+
                            '<button data-id="'+data+'" type="button" id="penjualan-remove" class="penjualan-remove mx-1 btn btn-icon btn-round btn-danger btn-sm" title="Remove">'+
                                '<i class="fa fa-trash-alt"></i>'+
                            '</button>'+
                        '</div>';
                    }},
                ],
                rowCallback:function(row,data,index){
                    $('td', row).eq(3).addClass('nowraping');
                    $('td', row).eq(4).addClass('nowraping');
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
                        $('.penjualan-print').removeClass('gone');
                        $('.penjualan-remove').removeClass('gone');
                        $('.alasan_hapus').addClass('gone');
                    }else if(sta == '0'){
                        $('#text-aksi').html('Alasan');
                        $('.penjualan-print').addClass('gone');
                        $('.penjualan-remove').addClass('gone');
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
                        
                    return false;
                })
                table_penjualan.draw(); 
                $.fn.dataTable.ext.search.pop();
            });
    
            function saveKey(){
                var src = $('input[name="filter-search"]').val().toLowerCase();
                if(src != undefined){
                    $('#datatable-penjualan').DataTable().search(src).draw();
                }
            }
        }
    }
    
    $("body").on("click", "#penjualan-print", function (e) {
        e.preventDefault();
        let id_penjualan = $(this).data('id');
        $.ajax({
            url: "transaksi/list_penjualan",
            method: "POST",
            dataType: "json",
            data: {
                id_penjualan: id_penjualan,
            },
            success: function(json) {
                PrintNota(json);
            },
        });
    });
    
    $("body").on("click", "#penjualan-remove", function (e) {
        e.preventDefault();
        let id_penjualan = $(this).data('id');
        var data = $("#datatable-penjualan").DataTable().row($(this).parents("tr")).data();
        var nota = data["nonota"];
        $('input[name="id_penjualan"]').val(id_penjualan);
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
            var id_penjualan = $('input[name="id_penjualan"]').val();
            var alasan_hapus = $('#alasan-hapus').val();
            $.ajax({
                url: 'transaksi/remove_penjualan',
                method: "POST",
                dataType: "json",
                data: {
                    id_penjualan: id_penjualan,
                    alasan_hapus: alasan_hapus,
                },
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $('#hapus').attr('disabled',false);
                },
            });
        }
    });
        
    function PrintNota(transaksi){
        var detail_list_item = "";
        const penjualan = transaksi.db_penjualan;
        const penjualan_item = transaksi.db_penjualan_item;
        const base_url = $('input[name="base_url"]').val();
        for (var i = 0; i < penjualan_item.length; i++) {
            let diskon = '';
            if(penjualan_item[i].diskon_nominal_item > 0){
                diskon = '('+penjualan_item[i].diskon_persen_item+'%)';
            }
            detail_list_item += '<tr>'+
                        '<td colspan="3"><b>'+penjualan_item[i].nama_produk+'</b></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td colspan="2">'+FormatCurrency(penjualan_item[i].harga_jual_item,true)+' x '+penjualan_item[i].jml_produk_item+' '+diskon+'</td>'+
                        '<td style="text-align:right;">'+FormatCurrency(penjualan_item[i].subtotal_harga_item,true)+'</td>'+
                    '</tr>';
        }
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
        '                    <tr '+(!penjualan.nota_logo ? 'style="display:none"' : '')+'>'+
        '                        <td colspan="3" style="text-align:center;"><img src="'+base_url+'assets/img/logo_nota/'+penjualan.nota_logo+'" width="90" height="90"></td>'+
        '                    </tr>'+
        '                    <tr '+(!penjualan.nota_header ? 'style="display:none"' : '')+'>'+
        '                        <td colspan="3" style="text-align:center; white-space:pre-wrap;">'+penjualan.nota_header+'</td>'+
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
        '                        <td style="text-align:right;">'+penjualan.nonota+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Tanggal</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+penjualan.tanggal+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Waktu</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+penjualan.waktu+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Operator</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+penjualan.operator+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Tipe Pembayaran</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+penjualan.tipe_bayar+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="border-bottom: 1.5px dotted #000 !important"></div></td>'+
        '                    </tr>'+
                                    detail_list_item+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="margin-top:5px;"></div></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Subtotal</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(penjualan.total_harga,true)+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Diskon ('+penjualan.diskon_persen+'%)</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(penjualan.diskon_nominal,true)+'</td>'+
        '                    </tr>'+
        '                    <tr '+(penjualan.ppn_nominal > 0 ? '' : 'style="display:none"')+'>'+
        '                        <td>PPN ('+penjualan.ppn_persen+'%)</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(penjualan.ppn_nominal,true)+'</td>'+
        '                    </tr>'+
        '                    <tr '+(penjualan.charge_nominal > 0 ? '' : 'style="display:none"')+'>'+
        '                        <td>Charge ('+penjualan.charge_persen+'%)</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(penjualan.charge_nominal,true)+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="border-bottom: 1.5px dotted #000 !important"></div></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td><b>Total Transaksi</b></td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;"><b>'+FormatCurrency(penjualan.total_transaksi,true)+'</b></td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Uang Dibayar</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(penjualan.dibayar,true)+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td>Uang Kembalian</td>'+
        '                        <td style="text-align:center;">:</td>'+
        '                        <td style="text-align:right;">'+FormatCurrency(penjualan.kembalian,true)+'</td>'+
        '                    </tr>'+
        '                    <tr>'+
        '                        <td colspan="3" style="text-align:center;"><div style="border-bottom: 1.5px dotted #000 !important"></div></td>'+
        '                    </tr>'+
        '                    <tr '+(!penjualan.nota_header ? 'style="display:none"' : '')+'>'+
        '                        <td colspan="3" style="text-align:center; white-space:pre-wrap;">'+penjualan.nota_footer+'</td>'+
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
            $('#datatable-penjualan').DataTable().ajax.reload();
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