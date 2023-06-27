(function ($) {
    var table_user = $("#datatable-user").DataTable({
        ajax: {
            url: "users/read_user",
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
                "targets": [0,1,2,3,4,5,6,7],
                "orderable": false,
                "visible": true
            },
            { 
                "targets": '_all', 
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
            emptyTable: "Belum ada daftar user!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah User',
                attr:  {
                    id: 'tambah_user'
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
                extend: "excel",
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6],
                },
                filename: 'Data User Gim '+$('#filter-cabang option:selected').text(),
                title: ''
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_user.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "nama_user" },
            { data: "gender_user" },
            { data: "telp_user" },
            { data: "email_user" },
            { data: "alamat_user" },
            { data: "status_member" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer user-edit" data-id="'+data+'" id="user-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer user-restore" data-id="'+data+'" id="user-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer user-remove" data-id="'+data+'" id="user-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer user-delete" data-id="'+data+'" id="user-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "status" },
            { data: "IDcabang" },
        ],
        fnDrawCallback:function(){
            $.ajax({
                url: 'users/level_user',
                type: 'GET',
                dataType: "json",
                success: function (json) {
                    if(json.tambah){
                        $("#tambah_user").removeClass("gone");
                    }else{
                        $("#tambah_user").addClass("gone");
                    }
                    
                    if(json.ubah){
                        $(".user-edit").removeClass("gone");
                    }else{
                        $(".user-edit").addClass("gone");
                    }
                    
                    if(json.hapus){
                        $(".user-remove").removeClass("gone");
                    }else{
                        $(".user-remove").addClass("gone");
                    }
                }
            });
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.user-edit').attr('style','');
                $('.user-restore').attr('style',style);
                $('.user-remove').attr('style','');
                $('.user-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.user-edit').attr('style',style);
                $('.user-restore').attr('style','');
                $('.user-remove').attr('style',style);
                $('.user-delete').attr('style',style);
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

    $('select[name="filter-cabang"]').change(function() {
        saveKey();
        filter();
    });

    function filter(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var cbg = $('select[name="filter-cabang"]').val().toLowerCase();
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (~data[1].toLowerCase().indexOf(src) && 
                ~data[9].toLowerCase().indexOf(cbg) &&
                ~data[8].toLowerCase().indexOf(sta))
                return true;
            if (~data[4].toLowerCase().indexOf(src) && 
                ~data[9].toLowerCase().indexOf(cbg) &&
                ~data[8].toLowerCase().indexOf(sta))
                return true;
            if (~data[5].toLowerCase().indexOf(src) && 
                ~data[9].toLowerCase().indexOf(cbg) &&
                ~data[8].toLowerCase().indexOf(sta))
                return true;
                
            return false;
        })
        table_user.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var cbg = $('select[name="filter-cabang"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-user').DataTable().search(src).draw();
        }
        if(cbg != undefined){
            $('#datatable-user').DataTable().search(cbg).draw();
        }
        if(sta != undefined){
            $('#datatable-user').DataTable().search(sta).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_user").on("click", function () {
        $("#modal-user").modal();
        document.getElementById("text-user").innerHTML = "Tambah User";
		$('#nama_user').val('');
        $('#gender_user').val('');
		$('#telp_user').val('');
		$('#email_user').val('');
		$('#alamat_user').val('');
        $('input[name="edit_user"]').attr("type", "hidden");
        $('input[name="add_user"]').attr("type", "submit");
    });
    
    $("input#add_user").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-user").reportValidity();
        if (validasi) {
            $("#add_user").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-user"));
            $.ajax({
                url: "users/add_user",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-user").modal('hide');
                    $("#add_user").prop('disabled', false);
                },
            });
        }
    });
    
    $('body').on('click','#user-edit', function(){
        $("#modal-user").modal();
        let id_user = $(this).data('id');
        document.getElementById("text-user").innerHTML = "Ubah User";
		var data = table_user.row($(this).parents("tr")).data();
		$('#nama_user').val(data["nama_user"]);
        $('#gender_user').val(data["gender_user"]);
		$('#telp_user').val(data["telp_user"]);
		$('#email_user').val(data["email_user"]);
		$('#alamat_user').val(data["alamat_user"]);
		$('input[name="id_user"]').val(id_user);
        $('input[name="edit_user"]').attr("type", "submit");
        $('input[name="add_user"]').attr("type", "hidden");
    });
    
    $("input#edit_user").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-user").reportValidity();
        if (validasi) {
            $("#edit_user").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-user"));
            $.ajax({
                url: "users/edit_user",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-user").modal('hide');
                    $("#edit_user").prop('disabled', false);
                },
            });
        }
    });

    $('body').on('click','#user-restore', function(){
        let id_user = $(this).data('id');
        action('restore_user',id_user,'User akan dikembalikan ke daftar data aktif!');
    });

    $('body').on('click','#user-remove', function(){
        let id_user = $(this).data('id');
        action('remove_user',id_user,'User akan dihapus dari daftar data aktif!');
    });

    $('body').on('click','#user-delete', function(){
        let id_user = $(this).data('id');
        action('delete_user',id_user,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function action(urlfunc,id_user,text){
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
                    url: "users/"+urlfunc,
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_user: id_user
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
            table_user.ajax.reload();
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
