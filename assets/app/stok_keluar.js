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
        stok_keluar();
    }

    $('select[name="filter-lokasi"]').change(function() {
        stok_keluar();
    });
    
    $('select[name="filter-status"]').change(function() {
        stok_keluar();
    });

    function stok_keluar(){
        var start = $('input[name="start-date"]').val();
        var end = $('input[name="end-date"]').val();
        var status = $('select[name="filter-status"]').val();
        var lokasi = $('select[name="filter-lokasi"]').val();
        var id_lokasi = lokasi == "" ? null : lokasi;
        var table_stok_keluar = $("#datatable-stok-keluar").DataTable({
            ajax: {
                url: "pos/read_stok_keluar",
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
                emptyTable: "Belum ada daftar stok keluar!",
                infoEmpty: "Tidak ada data untuk ditampilkan!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: ""
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    className: "btn btn-warning wid-max-select text-white",
                    text: '<i class="fas fa-plus mr-2"></i> Tambah',
                    action: function (e, dt, node, config) {
                        document.getElementById("show-stok").style.display = "none";
                        document.getElementById("add-stok").style.display = "unset";
                        list_transaksi();
                    },
                },
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
                    className: "btn btn-secondary wid-max-select text-white",
                    text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                    action: function (e, dt, node, config) {
                        table_stok_keluar.ajax.reload();
                    },
                },
            ],
            columns: [
                { data: "no" },
                { data: "date_format" },
                { data: "nokeluar" },
                { data: "produk" },
                { data: "jumlah" },
                { data: "keterangan" },
                { data: "nama_lokasi" },
                { data: "aksi" , render : function ( data, type, row, meta ) {
                    return '<span class="alasan_hapus gone">'+row['alasan_hapus']+'</span>'+
                    '<div style="white-space: nowrap;">'+
                        '<button data-id="'+data+'" type="button" id="stok-print" data-row="'+row['no']+'" class="stok-print mx-1 btn btn-icon btn-round btn-success btn-sm" title="Print">'+
                            '<i class="fa fa-print"></i>'+
                        '</button>'+
                        '<button data-id="'+data+'" type="button" id="stok-remove" class="stok-remove mx-1 btn btn-icon btn-round btn-danger btn-sm" title="Remove">'+
                            '<i class="fa fa-trash-alt"></i>'+
                        '</button>'+
                    '</div>';
                }},
            ],
            rowCallback:function(row,data,index){
                $('td', row).eq(3).addClass('nowraping');
            },
            fnDrawCallback:function(){
                var sta = $('select[name="filter-status"]').val();
                if(sta == '1'){
                    $('#text-aksi').html('Aksi');
                    $('.stok-print').removeClass('gone');
                    $('.stok-remove').removeClass('gone');
                    $('.alasan_hapus').addClass('gone');
                }else if(sta == '0'){
                    $('#text-aksi').html('Alasan');
                    $('.stok-print').addClass('gone');
                    $('.stok-remove').addClass('gone');
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
                if (~data[5].toLowerCase().indexOf(src))
                    return true;
                    
                return false;
            })
            table_stok_keluar.draw(); 
            $.fn.dataTable.ext.search.pop();
        });

        function saveKey(){
            var src = $('input[name="filter-search"]').val().toLowerCase();
            if(src != undefined){
                $('#datatable-stok-keluar').DataTable().search(src).draw();
            }
        }
    }
    
    $('#pilih-lokasi').change(function() {
        list_transaksi();
    });

    function list_transaksi(){
		const id_posisi = $('input[name="id_posisi"]').val();
        const id_lokasi = $('#pilih-lokasi').val();

        $(".tgl").datepicker({
            format: "dd-mm-yyyy",
        }).on("changeDate", function (selected){
            $(this).datepicker("hide");
        });
        
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
                        let style = 'padding-bottom: 5px !important; padding-top: 5px !important;';
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
            ],
            fnDrawCallback:function(){
                $('#datatable-list-produk').attr('style','margin-top:0px;');
                $('#datatable-list-produk_previous').attr('style','display:none;');
                $('#datatable-list-produk_next').attr('style','display:none;');
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
        var cek = true;
        let x;
        for (var i = 0; i < arr.length; i++) {
            let id_produk = arr[i].id_produk;
            if(id_produk == list.id_produk){
                cek = false;
                x = i;
            }
        }
        if(cek){
            qty.push(1);
            arr.push(list);
        }else{
            qty[x]= qty[x]+1;
        }
        dataList();
    }

    $('body').on('click','#delItem',function(){
        let index = $(this).data('index');
        arr.splice(index,1);
        qty.splice(index,1);
        dataList();
    });

    $('body').on('change keyup','input#qty',function(){
        let index = $(this).data('index');
        qty[index] = Number($(this).val());
    });

    function dataList(){
        var html = "";
        for (var i = 0; i < arr.length; i++) {
            let id_produk = arr[i].id_produk;
            let nama_produk = arr[i].nama_produk;
            let satuan_produk = arr[i].satuan_produk;
            
            html += '<tr>' +
                        '<input type="hidden" name="id_'+i+'" id="idt" class="form-control" value="'+id_produk+'">'+
                        '<td>'+(i+1)+'.</td>' +
                        '<td>'+nama_produk+'</td>' +
                        '<td>'+satuan_produk+'</td>'+
                        '<td><input type="number" data-index="'+i+'" name="qty_'+i+'" id="qty" min="0" class="form-control sm-height px-1" placeholder="0" value="'+qty[i]+'" required></td>'+
                        '<td class="text-center"><a id="delItem" data-index="'+i+'" class="text-danger" style="cursor:pointer;"><i class="fa fa-trash"></i></a></td>'                        
                    '</tr>';
        }
        $("#produk-item tbody").html(html);
    }
    
    $("body").on("click", "#simpan_transaksi", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-item").reportValidity();
        if(validasi){
            var dataItem = []; 
            if(arr.length == 0){
                swal("Warning", 'Produk harus di pilih terlebih dahulu!', {
                    icon: "info",
                    buttons: {
                        confirm: {
                            className: "btn btn-info",
                        },
                    },
                });
            }else{
                $("#simpan_transaksi").prop('disabled', true);
                var tgl_keluar = $('input[name="tgl_keluar"]').val();
                var keterangan = $('#keterangan').val();
                var id_lokasi = $('#pilih-lokasi').val();

                for(var i=0; i<arr.length; i++) {
                    var itemValue = {
                        id_produk : $('input[name="id_'+i+'"]').val(),
                        jml_produk : $('input[name="qty_'+i+'"]').val(),
                        stok_produk : arr[i].stok_produk
                    };
                    dataItem.push(itemValue);
                }

                $.ajax({
                    url: "pos/add_stok_keluar",
                    method: "POST",
                    data: { 
                        id_lokasi: id_lokasi,
                        data_produk: dataItem,
                        keterangan: keterangan,
                        tgl_keluar: tgl_keluar,
                    },
                    dataType: "json",
                    success: function (json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message, 1);
                        if(result == "error"){
                            $("#simpan_transaksi").prop('disabled', false);
                        }
                    },
                });
            }
        }
    });
    
    $("body").on("click", "#stok-print", function () {
        $("#modal-nota").modal();
        let row = $(this).data('row') - 1;
        var data = $("#datatable-stok-keluar").DataTable().row(row).data();
        if(data != undefined){
            $("#tgl").text(data["tgl_keluar"]);
            $("#nota").text(data["nokeluar"]);
            $("#lokasi").text(data["nama_lokasi"]);
            var produk = data["produk"].split('<br>');
            var jumlah = data["jumlah"].split('<br>');
            var html = "";
            for(var i = 0; i<produk.length; i++){
                html += '<tr>'+
                            '<td class="left-text">'+ (i+1) +'.</td>'+
                            '<td class="left-text">'+ produk[i] +'</td>'+
                            '<td class="detail">'+ jumlah[i] +'</td>'+
                        '</tr>';
            }
            $("#data-list").html(html);
        }
    });
    
    $("body").on("click", "#stok-remove", function (e) {
        e.preventDefault();
        let id_stok_keluar = $(this).data('id');
        var data = $("#datatable-stok-keluar").DataTable().row($(this).parents("tr")).data();
        var nota = data["nokeluar"];
        $('input[name="id_stok_keluar"]').val(id_stok_keluar);
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
            var id_stok_keluar = $('input[name="id_stok_keluar"]').val();
            var alasan_hapus = $('#alasan-hapus').val();
            $.ajax({
                url: 'pos/remove_stok_keluar',
                method: "POST",
                dataType: "json",
                data: {
                    id_stok_keluar: id_stok_keluar,
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
            $('#datatable-stok-keluar').DataTable().ajax.reload();
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