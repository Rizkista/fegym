(function ($) {
    var table_produk = $("#datatable-produk").DataTable({
        ajax: {
            url: "pos/read_produk",
            type: "GET",
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
                "targets": [9,10],
                "orderable": false,
                "visible": false
            },
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
            emptyTable: "Belum ada daftar produk!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah',
                attr:  {
                    id: 'tambah_produk'
                }
            },
            {
                extend: 'pageLength',
                className: "btn btn-primary btn-icon-text wid-max-select",
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
                    table_produk.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "no" },
            { data: "barcode_produk" },
            { data: "nama_produk" },
            { data: "harga_beli" , render: function(data, type, row, meta) {
                return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
            }},
            { data: "harga_jual" , render: function(data, type, row, meta) {
                return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
            }},
            { data: "qty_produk" },
            { data: "satuan_produk" },
            { data: "nama_kat_produk" },
            { data: "aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer produk-edit" data-id="'+data+'" id="produk-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer produk-remove" data-id="'+data+'" id="produk-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer produk-restore" data-id="'+data+'" id="produk-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "status" },
            { data: "id_kat_produk" },
        ],
        fnDrawCallback:function(){
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.produk-edit').attr('style','');
                $('.produk-restore').attr('style',style);
                $('.produk-remove').attr('style','');
            }else if(sta == 'hapus-'){
                $('.produk-edit').attr('style',style);
                $('.produk-restore').attr('style','');
                $('.produk-remove').attr('style',style);
            }
        },
    });

    saveKey();
    $('#filter-search').keyup(function(){
        saveKey();
        filter();
    });

    $('select[name="filter-status"]').change(function() {
        saveKey();
        filter();
    });

    $('select[name="filter-kategori"]').change(function() {
        saveKey();
        filter();
    });

    function filter(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var kat = $('select[name="filter-kategori"]').val().toLowerCase();
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (~data[1].toLowerCase().indexOf(src) && 
                ~data[9].toLowerCase().indexOf(sta) && 
                ~data[10].toLowerCase().indexOf(kat))
                return true;
            if (~data[2].toLowerCase().indexOf(src) && 
                ~data[9].toLowerCase().indexOf(sta) && 
                ~data[10].toLowerCase().indexOf(kat))
                return true;
            if (~data[6].toLowerCase().indexOf(src) && 
                ~data[9].toLowerCase().indexOf(sta) && 
                ~data[10].toLowerCase().indexOf(kat))
                return true;
            return false;
        })
        table_produk.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var kat = $('select[name="filter-kategori"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-produk').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-produk').DataTable().search(sta).draw();
        }
        if(kat != undefined){
            $('#datatable-produk').DataTable().search(kat).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_produk").on("click", function () {
        $("#modal-produk").modal();
        document.getElementById("text-produk").innerHTML = "Tambah Produk";
		$('#barcode_produk').val('');
		$('#nama_produk').val('');
		$('#qty_produk').val('');
		$('#harga_beli').val('');
		$('#harga_jual').val('');
		$('#satuan_produk').val('');
		$('#nama_kat_produk').val('');
        $('input[name="edit_produk"]').attr("type", "hidden");
        $('input[name="add_produk"]').attr("type", "submit");
    });

    $("input#add_produk").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-produk").reportValidity();
        if (validasi) {
            $("#add_produk").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-produk"));
            $.ajax({
                url: "pos/add_produk",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-produk").modal('hide');
                    $("#add_produk").prop('disabled', false);
                },
            });
        }
    });
    
    $('body').on('click','#produk-edit', function(){
        $("#modal-produk").modal();
        let id_produk = $(this).data('id');
        document.getElementById("text-produk").innerHTML = "Ubah Produk";
		var data = table_produk.row($(this).parents("tr")).data();
		$('#barcode_produk').val(data["barcode_produk"]);
		$('#nama_produk').val(data["nama_produk"]);
		$('#qty_produk').val(data["qty_produk"]);
		$('#harga_beli').val(FormatCurrency(data["harga_beli"]));
		$('#harga_jual').val(FormatCurrency(data["harga_jual"]));
		$('#satuan_produk').val(data["satuan_produk"]);
		$('#nama_kat_produk').val(data["nama_kat_produk"]);
		$('input[name="id_produk"]').val(id_produk);
        $('input[name="edit_produk"]').attr("type", "submit");
        $('input[name="add_produk"]').attr("type", "hidden");
    });
    
    $("input#edit_produk").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-produk").reportValidity();
        if (validasi) {
            $("#edit_produk").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-produk"));
            $.ajax({
                url: "pos/edit_produk",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-produk").modal('hide');
                    $("#edit_produk").prop('disabled', false);
                },
            });
        }
    });

    $('body').on('click','#produk-restore', function(){
        let id_produk = $(this).data('id');
        action('restore_produk',id_produk,'Data produk akan dikembalikan ke daftar produk aktif!');
    });

    $('body').on('click','#produk-remove', function(){
        let id_produk = $(this).data('id');
        action('remove_produk',id_produk,'Data produk akan dihapus dari daftar produk aktif');
    });

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

    function action(urlfunc,id_produk,text){
        swal({
            title: "Apakah anda yakin?",
            text: text,
            icon: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Kembali",
                    className: "btn btn-danger btn-sm",
                },
                confirm: {
                    text: "Lanjut",
                    className: "btn btn-success btn-sm",
                },
            },
        }).then((Delete) => {
            if (Delete) {
                $.ajax({
                    url: "pos/"+urlfunc,
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_produk: id_produk
                    },
                    success: function (json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message);
                    },
                });
            } else {
                swal.close();
            }
        });
    }

    function notif(result, message, reload = null) {
        if (result == "success") {
            swal("Success", message, {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success btn-sm",
                    },
                },
            });
            table_produk.ajax.reload();
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
                        className: "btn btn-danger btn-sm",
                    },
                },
            });
        }
    }
})(jQuery);
