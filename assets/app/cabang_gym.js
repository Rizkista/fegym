(function ($) {
    var table_cabang = $("#datatable-cabang").DataTable({
        ajax: {
            url: "master/read_cabang",
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
            emptyTable: "Belum ada daftar cabang!",
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
                    id: 'tambah_cabang'
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
                    table_cabang.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "no" },
            { data: "nama_cabang" },
            { data: "alamat_cabang" },
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
                    +'<a class="dropdown-item pointer cabang-edit" data-id_account="'+row['id_account']+'" data-id_cabang="'+row['id_cabang']+'" id="cabang-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer cabang-remove" data-id_account="'+row['id_account']+'" data-id_cabang="'+row['id_cabang']+'" id="cabang-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer cabang-restore" data-id_account="'+row['id_account']+'" data-id_cabang="'+row['id_cabang']+'" id="cabang-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
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
                $('.cabang-edit').attr('style','');
                $('.cabang-restore').attr('style',style);
                $('.cabang-remove').attr('style','');
            }else if(sta == 'hapus-'){
                $('.cabang-edit').attr('style',style);
                $('.cabang-restore').attr('style','');
                $('.cabang-remove').attr('style',style);
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
        table_cabang.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-cabang').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-cabang').DataTable().search(sta).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_cabang").on("click", function () {
        $("#modal-cabang").modal();
        document.getElementById("text-cabang").innerHTML = "Tambah";
		$('#nama_cabang').val('');
		$('#alamat_cabang').val('');
		$('#nama').val('');
		$('#email').val('');
		$('#telp').val('');
		$('#password').val('');
        $("#password").attr('required', '');
        $('input[name="edit_cabang"]').attr("type", "hidden");
        $('input[name="add_cabang"]').attr("type", "submit");
    });

    $("input#add_cabang").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-cabang").reportValidity();
        if (validasi) {
            $("#add_cabang").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-cabang"));
            $.ajax({
                url: "master/add_cabang",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-cabang").modal('hide');
                    $("#add_cabang").prop('disabled', false);
                },
            });
        }
    });
    
    $('body').on('click','#cabang-edit', function(){
        $("#modal-cabang").modal();
        let id_cabang = $(this).data('id_cabang');
        let id_account = $(this).data('id_account');
        document.getElementById("text-cabang").innerHTML = "Ubah";
		var data = table_cabang.row($(this).parents("tr")).data();
		$('#nama_cabang').val(data["nama_cabang"]);
		$('#alamat_cabang').val(data["alamat_cabang"]);
		$('#nama').val(data["nama"]);
		$('#email').val(data["email"]);
		$('#telp').val(data["telp"]);
		$('#password').val('');
        $("#password").removeAttr('required');
		$('input[name="id_cabang"]').val(id_cabang);
		$('input[name="id_account"]').val(id_account);
        $('input[name="edit_cabang"]').attr("type", "submit");
        $('input[name="add_cabang"]').attr("type", "hidden");
    });
    
    $("input#edit_cabang").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-cabang").reportValidity();
        if (validasi) {
            $("#edit_cabang").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-cabang"));
            $.ajax({
                url: "master/edit_cabang",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-cabang").modal('hide');
                    $("#edit_cabang").prop('disabled', false);
                },
            });
        }
    });

    $('body').on('click','#cabang-restore', function(){
        let id_cabang = $(this).data('id_cabang');
        let id_account = $(this).data('id_account');
        action('restore_cabang',id_cabang,id_account,'Data cabang akan dikembalikan ke daftar cabang aktif!');
    });

    $('body').on('click','#cabang-remove', function(){
        let id_cabang = $(this).data('id_cabang');
        let id_account = $(this).data('id_account');
        action('remove_cabang',id_cabang,id_account,'Data cabang akan dihapus dari daftar cabang aktif');
    });

    function action(urlfunc,id_cabang,id_account,text){
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
                        id_cabang: id_cabang,
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
            table_cabang.ajax.reload();
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
