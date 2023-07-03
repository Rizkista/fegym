(function ($) {
    var table_lokasi = $("#datatable-lokasi").DataTable({
        ajax: {
            url: "master/read_lokasi",
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
                "targets": [5],
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
            emptyTable: "Belum ada daftar lokasi!",
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
                    id: 'tambah_lokasi'
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
                    table_lokasi.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "no" },
            { data: "nama_lokasi" },
            { data: "alamat_lokasi" },
            { data: "admin" , render : function ( data, type, row, meta ) {
                var view = '\n\
                <i>\n\
                    <span class="nowraping">Nama: <sup><font color="#FF0000"><i>'+row['nama']+'</i></font></sup> , </span>\n\
                    <span class="nowraping">Email: <sup><font color="#FF0000"><i>'+row['email']+'</i></font></sup> , </span>\n\
                    <span class="nowraping">Password: <sup><font color="#FF0000"><i>'+row['password']+'</i></font></sup></span>\n\
                </i>';
                return view;
            }},
            { data: "aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer lokasi-edit" data-id_account="'+row['id_account']+'" data-id_lokasi="'+row['id_lokasi']+'" id="lokasi-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer lokasi-remove" data-id_account="'+row['id_account']+'" data-id_lokasi="'+row['id_lokasi']+'" id="lokasi-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer lokasi-restore" data-id_account="'+row['id_account']+'" data-id_lokasi="'+row['id_lokasi']+'" id="lokasi-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "status" },
        ],
        fnDrawCallback:function(){
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.lokasi-edit').attr('style','');
                $('.lokasi-restore').attr('style',style);
                $('.lokasi-remove').attr('style','');
            }else if(sta == 'hapus-'){
                $('.lokasi-edit').attr('style',style);
                $('.lokasi-restore').attr('style','');
                $('.lokasi-remove').attr('style',style);
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

    function filter(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (~data[1].toLowerCase().indexOf(src) && 
                ~data[5].toLowerCase().indexOf(sta))
                return true;
            if (~data[2].toLowerCase().indexOf(src) && 
                ~data[5].toLowerCase().indexOf(sta))
                return true;
            if (~data[3].toLowerCase().indexOf(src) && 
                ~data[5].toLowerCase().indexOf(sta))
                return true;
            return false;
        })
        table_lokasi.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-lokasi').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-lokasi').DataTable().search(sta).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_lokasi").on("click", function () {
        $("#modal-lokasi").modal();
        document.getElementById("text-lokasi").innerHTML = "Tambah";
		$('#nama_lokasi').val('');
		$('#alamat_lokasi').val('');
		$('#nama').val('');
		$('#email').val('');
		$('#telp').val('');
		$('#password').val('');
        $("#password").attr('required', '');
        $('input[name="edit_lokasi"]').attr("type", "hidden");
        $('input[name="add_lokasi"]').attr("type", "submit");
    });

    $("input#add_lokasi").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-lokasi").reportValidity();
        if (validasi) {
            $("#add_lokasi").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-lokasi"));
            $.ajax({
                url: "master/add_lokasi",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-lokasi").modal('hide');
                    $("#add_lokasi").prop('disabled', false);
                },
            });
        }
    });
    
    $('body').on('click','#lokasi-edit', function(){
        $("#modal-lokasi").modal();
        let id_lokasi = $(this).data('id_lokasi');
        let id_account = $(this).data('id_account');
        document.getElementById("text-lokasi").innerHTML = "Ubah";
		var data = table_lokasi.row($(this).parents("tr")).data();
		$('#nama_lokasi').val(data["nama_lokasi"]);
		$('#alamat_lokasi').val(data["alamat_lokasi"]);
		$('#nama').val(data["nama"]);
		$('#email').val(data["email"]);
		$('#telp').val(data["telp"]);
		$('#password').val('');
        $("#password").removeAttr('required');
		$('input[name="id_lokasi"]').val(id_lokasi);
		$('input[name="id_account"]').val(id_account);
        $('input[name="edit_lokasi"]').attr("type", "submit");
        $('input[name="add_lokasi"]').attr("type", "hidden");
    });
    
    $("input#edit_lokasi").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-lokasi").reportValidity();
        if (validasi) {
            $("#edit_lokasi").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-lokasi"));
            $.ajax({
                url: "master/edit_lokasi",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-lokasi").modal('hide');
                    $("#edit_lokasi").prop('disabled', false);
                },
            });
        }
    });

    $('body').on('click','#lokasi-restore', function(){
        let id_lokasi = $(this).data('id_lokasi');
        let id_account = $(this).data('id_account');
        action('restore_lokasi',id_lokasi,id_account,'Data lokasi akan dikembalikan ke daftar lokasi aktif!');
    });

    $('body').on('click','#lokasi-remove', function(){
        let id_lokasi = $(this).data('id_lokasi');
        let id_account = $(this).data('id_account');
        action('remove_lokasi',id_lokasi,id_account,'Data lokasi akan dihapus dari daftar lokasi aktif');
    });

    function action(urlfunc,id_lokasi,id_account,text){
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
                    url: "master/"+urlfunc,
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_lokasi: id_lokasi,
                        id_account: id_account
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
            table_lokasi.ajax.reload();
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
