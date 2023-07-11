(function ($) {
    var table_anggota = $("#datatable-anggota").DataTable({
        ajax: {
            url: "anggota/read_anggota",
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
                "targets": [0,1,2,3,5,6,7,8],
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
            emptyTable: "Belum ada daftar anggota!",
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
                    id: 'tambah_anggota'
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
                    columns: [0,1,2,3,4,5,6,7],
                },
                filename: 'Data Anggota Gim '+$('#filter-lokasi option:selected').text(),
                title: ''
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_anggota.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "nama_anggota" },
            { data: "gender_anggota" },
            { data: "telp_anggota" },
            { data: "email_anggota" },
            { data: "alamat_anggota" },
            { data: "status_member" },
            { data: "nama_lokasi" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer anggota-edit" data-id="'+data+'" id="anggota-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer anggota-restore" data-id="'+data+'" id="anggota-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer anggota-remove" data-id="'+data+'" id="anggota-remove"> <i class="fas fa-trash"></i> Remove</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "status" },
            { data: "IDlokasi" },
        ],
        fnDrawCallback:function(){
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            if(sta == 'aktif-'){
                $('.anggota-edit').removeClass('gone');
                $('.anggota-restore').addClass('gone');
                $('.anggota-remove').removeClass('gone');
            }else if(sta == 'hapus-'){
                $('.anggota-edit').addClass('gone');
                $('.anggota-restore').removeClass('gone');
                $('.anggota-remove').addClass('gone');
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
        var cbg = $('select[name="filter-lokasi"]').val().toLowerCase();
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (~data[1].toLowerCase().indexOf(src) && 
                ~data[10].toLowerCase().indexOf(cbg) &&
                ~data[9].toLowerCase().indexOf(sta))
                return true;
            if (~data[4].toLowerCase().indexOf(src) && 
                ~data[10].toLowerCase().indexOf(cbg) &&
                ~data[9].toLowerCase().indexOf(sta))
                return true;
            if (~data[5].toLowerCase().indexOf(src) && 
                ~data[10].toLowerCase().indexOf(cbg) &&
                ~data[9].toLowerCase().indexOf(sta))
                return true;
                
            return false;
        })
        table_anggota.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var cbg = $('select[name="filter-lokasi"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-anggota').DataTable().search(src).draw();
        }
        if(cbg != undefined){
            $('#datatable-anggota').DataTable().search(cbg).draw();
        }
        if(sta != undefined){
            $('#datatable-anggota').DataTable().search(sta).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_anggota").on("click", function () {
        $("#modal-anggota").modal();
		const id_posisi = $('input[name="id_posisi"]').val();
        if(id_posisi == 3){
            $(".lok-edit").addClass('gone');
            $("#id_lokasi").removeAttr('required');
        }else{
            $(".lok-edit").removeClass('gone');
            $("#id_lokasi").attr('required', '');
        }
        document.getElementById("text-anggota").innerHTML = "Tambah Anggota";
		$('#nama_anggota').val('');
        $('#gender_anggota').val('');
		$('#telp_anggota').val('');
		$('#email_anggota').val('');
		$('#alamat_anggota').val('');
        $('input[name="edit_anggota"]').attr("type", "hidden");
        $('input[name="add_anggota"]').attr("type", "submit");
    });
    
    $("input#add_anggota").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-anggota").reportValidity();
        if (validasi) {
            $("#add_anggota").prop('disabled', true);
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
                        $("#modal-anggota").modal('hide');
                    }
                    $("#add_anggota").prop('disabled', false);
                },
            });
        }
    });
    
    $('body').on('click','#anggota-edit', function(){
        $("#modal-anggota").modal();
        let id_anggota = $(this).data('id');
        $(".lok-edit").addClass('gone');
        $("#id_lokasi").removeAttr('required');
        document.getElementById("text-anggota").innerHTML = "Ubah Anggota";
		var data = table_anggota.row($(this).parents("tr")).data();
		$('#nama_anggota').val(data["nama_anggota"]);
        $('#gender_anggota').val(data["gender_anggota"]);
		$('#telp_anggota').val(data["telp_anggota"]);
		$('#email_anggota').val(data["email_anggota"]);
		$('#alamat_anggota').val(data["alamat_anggota"]);
		$('input[name="id_anggota"]').val(id_anggota);
        $('input[name="edit_anggota"]').attr("type", "submit");
        $('input[name="add_anggota"]').attr("type", "hidden");
    });
    
    $("input#edit_anggota").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-anggota").reportValidity();
        if (validasi) {
            $("#edit_anggota").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-anggota"));
            $.ajax({
                url: "anggota/edit_anggota",
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
                        $("#modal-anggota").modal('hide');
                    }
                    $("#edit_anggota").prop('disabled', false);
                },
            });
        }
    });

    $('body').on('click','#anggota-restore', function(){
        let id_anggota = $(this).data('id');
        action('restore_anggota',id_anggota,'Anggota akan dikembalikan ke daftar data aktif!');
    });

    $('body').on('click','#anggota-remove', function(){
        let id_anggota = $(this).data('id');
        action('remove_anggota',id_anggota,'Anggota akan dihapus dari daftar data aktif!');
    });

    function action(urlfunc,id_anggota,text){
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
                    url: "anggota/"+urlfunc,
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_anggota: id_anggota
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
            table_anggota.ajax.reload();
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
