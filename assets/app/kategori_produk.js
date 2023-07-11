(function ($) {
    var table_katproduk = $("#datatable-katproduk").DataTable({
        ajax: {
            url: "pos/read_katproduk",
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
                "targets": [4,5],
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
            emptyTable: "Belum ada daftar kategori produk!",
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
                    id: 'tambah_katproduk'
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
                    table_katproduk.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "no" },
            { data: "nama_kat_produk" },
            { data: "nama_lokasi" },
            { data: "aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer katproduk-edit" data-id="'+data+'" id="katproduk-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer katproduk-remove" data-id="'+data+'" id="katproduk-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer katproduk-restore" data-id="'+data+'" id="katproduk-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "status" },
            { data: "id_lokasi_filter" },
        ],
        fnDrawCallback:function(){
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            if(sta == 'aktif-'){
                $('.katproduk-edit').removeClass('gone');
                $('.katproduk-restore').addClass('gone');
                $('.katproduk-remove').removeClass('gone');
            }else if(sta == 'hapus-'){
                $('.katproduk-edit').addClass('gone');
                $('.katproduk-restore').removeClass('gone');
                $('.katproduk-remove').addClass('gone');
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

    $('select[name="filter-lokasi"]').change(function() {
        saveKey();
        filter();
    });

    function filter(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var lok = $('select[name="filter-lokasi"]').val().toLowerCase();
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (~data[1].toLowerCase().indexOf(src) && 
                ~data[4].toLowerCase().indexOf(sta) && 
                ~data[5].toLowerCase().indexOf(lok))
                return true;
            return false;
        })
        table_katproduk.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var lok = $('select[name="filter-lokasi"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-katproduk').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-katproduk').DataTable().search(sta).draw();
        }
        if(lok != undefined){
            $('#datatable-katproduk').DataTable().search(lok).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_katproduk").on("click", function () {
        $("#modal-katproduk").modal();
		const id_posisi = $('input[name="id_posisi"]').val();
        if(id_posisi == 3){
            $(".lok-edit").addClass('gone');
            $("#id_lokasi").removeAttr('required');
        }else{
            $(".lok-edit").removeClass('gone');
            $("#id_lokasi").attr('required', '');
        }
        document.getElementById("text-katproduk").innerHTML = "Tambah Kategori Produk";
		$('#nama_kat_produk').val('');
		$('#id_lokasi').val('');
        $('input[name="edit_katproduk"]').attr("type", "hidden");
        $('input[name="add_katproduk"]').attr("type", "submit");
    });

    $("input#add_katproduk").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-katproduk").reportValidity();
        if (validasi) {
            $("#add_katproduk").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-katproduk"));
            $.ajax({
                url: "pos/add_katproduk",
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
                        $("#modal-katproduk").modal('hide');
                    }
                    $("#add_katproduk").prop('disabled', false);
                },
            });
        }
    });
    
    $('body').on('click','#katproduk-edit', function(){
        $("#modal-katproduk").modal();
        let id_katproduk = $(this).data('id');
        $(".lok-edit").addClass('gone');
        $("#id_lokasi").removeAttr('required');
        document.getElementById("text-katproduk").innerHTML = "Ubah Kategori Produk";
		var data = table_katproduk.row($(this).parents("tr")).data();
		$('#nama_kat_produk').val(data["nama_kat_produk"]);
		$('#id_lokasi').val(data["id_lokasi"]);
		$('input[name="id_katproduk"]').val(id_katproduk);
        $('input[name="edit_katproduk"]').attr("type", "submit");
        $('input[name="add_katproduk"]').attr("type", "hidden");
    });
    
    $("input#edit_katproduk").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-katproduk").reportValidity();
        if (validasi) {
            $("#edit_katproduk").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-katproduk"));
            $.ajax({
                url: "pos/edit_katproduk",
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
                        $("#modal-katproduk").modal('hide');
                    }
                    $("#edit_katproduk").prop('disabled', false);
                },
            });
        }
    });

    $('body').on('click','#katproduk-restore', function(){
        let id_katproduk = $(this).data('id');
        action('restore_katproduk',id_katproduk,'Data kategori akan dikembalikan ke daftar kategori aktif!');
    });

    $('body').on('click','#katproduk-remove', function(){
        let id_katproduk = $(this).data('id');
        action('remove_katproduk',id_katproduk,'Data kategori akan dihapus dari daftar kategori aktif');
    });

    function action(urlfunc,id_katproduk,text){
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
                        id_katproduk: id_katproduk
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
            table_katproduk.ajax.reload();
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
