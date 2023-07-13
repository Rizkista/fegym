(function ($) {
    var table_paket = $("#datatable-paket").DataTable({
        ajax: {
            url: "master/read_paket",
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
                "targets": [7,8],
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
            emptyTable: "Belum ada daftar paket gym!",
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
                    id: 'tambah_paket'
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
                    table_paket.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "no" },
            { data: "nama_paket" },
            { data: "harga_paket" , render: function(data, type, row, meta) {
                return '<sup><font color="#FF0000">Rp</font></sup> '+FormatCurrency(data);
            }},
            { data: "durasi" , render : function ( data, type, row, meta ) {
                const durasi = [null, 'MINUTE', 'DAY', 'WEEK', 'MONTH', 'YEAR'];
                return row['lama_durasi']+' '+'<sup><font color="#FF0000">'+durasi[row['durasi_paket']]+'</font></sup>';
            }},
            { data: "status_member" , render : function ( data, type, row, meta ) {
                return data == 1 ? 'AKTIF' : 'TIDAK';
            }},
            { data: "nama_lokasi" },
            { data: "aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer paket-edit" data-id="'+data+'" id="paket-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer paket-remove" data-id="'+data+'" id="paket-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer paket-restore" data-id="'+data+'" id="paket-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
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
                $('.paket-edit').removeClass('gone');;
                $('.paket-restore').addClass('gone');
                $('.paket-remove').removeClass('gone');;
            }else if(sta == 'hapus-'){
                $('.paket-edit').addClass('gone');
                $('.paket-restore').removeClass('gone');;
                $('.paket-remove').addClass('gone');
            }
        },
        rowCallback:function(row,data,index){
            $('td', row).eq(2).addClass('nowraping');
            $('td', row).eq(3).addClass('nowraping');
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
                ~data[7].toLowerCase().indexOf(sta) && 
                ~data[8].toLowerCase().indexOf(lok))
                return true;
            if (~data[2].toLowerCase().indexOf(src) && 
                ~data[7].toLowerCase().indexOf(sta) && 
                ~data[8].toLowerCase().indexOf(lok))
                return true;
            if (~data[3].toLowerCase().indexOf(src) && 
                ~data[7].toLowerCase().indexOf(sta) && 
                ~data[8].toLowerCase().indexOf(lok))
                return true;
            return false;
        })
        table_paket.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var lok = $('select[name="filter-lokasi"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-paket').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-paket').DataTable().search(sta).draw();
        }
        if(lok != undefined){
            $('#datatable-paket').DataTable().search(lok).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_paket").on("click", function () {
        $("#modal-paket").modal();
		const id_posisi = $('input[name="id_posisi"]').val();
        if(id_posisi == 3){
            $(".lok-edit").addClass('gone');
            $("#id_lokasi").removeAttr('required');
        }else{
            $(".lok-edit").removeClass('gone');
            $("#id_lokasi").attr('required', '');
        }
        document.getElementById("text-paket").innerHTML = "Tambah Paket Gym";
		$('#nama_paket').val('');
		$('#harga_paket').val('');
		$('#durasi_paket').val('');
		$('#lama_durasi').val('');
		$('#status_member').val('');
        $('input[name="edit_paket"]').attr("type", "hidden");
        $('input[name="add_paket"]').attr("type", "submit");
    });

    $("input#add_paket").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-paket").reportValidity();
        if (validasi) {
            $("#add_paket").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-paket"));
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
                        $("#modal-paket").modal('hide');
                    }
                    $("#add_paket").prop('disabled', false);
                },
            });
        }
    });
    
    $('body').on('click','#paket-edit', function(){
        $("#modal-paket").modal();
        let id_paket = $(this).data('id');
        $(".lok-edit").addClass('gone');
        $("#id_lokasi").removeAttr('required');
        document.getElementById("text-paket").innerHTML = "Ubah Paket Gym";
		var data = table_paket.row($(this).parents("tr")).data();
		$('#nama_paket').val(data["nama_paket"]);
		$('#harga_paket').val(FormatCurrency(data["harga_paket"]));
		$('#durasi_paket').val(data["durasi_paket"]);
		$('#lama_durasi').val(data["lama_durasi"]);
		$('#status_member').val(data["status_member"]);
		$('input[name="id_paket"]').val(id_paket);
        $('input[name="edit_paket"]').attr("type", "submit");
        $('input[name="add_paket"]').attr("type", "hidden");
    });
    
    $("input#edit_paket").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-paket").reportValidity();
        if (validasi) {
            $("#edit_paket").prop('disabled', true);
            var formData = new FormData(document.querySelector("#form-paket"));
            $.ajax({
                url: "master/edit_paket",
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
                        $("#modal-paket").modal('hide');
                    }
                    $("#edit_paket").prop('disabled', false);
                },
            });
        }
    });

    $('body').on('click','#paket-restore', function(){
        let id_paket = $(this).data('id');
        action('restore_paket',id_paket,'Data paket akan dikembalikan ke daftar paket aktif!');
    });

    $('body').on('click','#paket-remove', function(){
        let id_paket = $(this).data('id');
        action('remove_paket',id_paket,'Data paket akan dihapus dari daftar paket aktif');
    });

    function action(urlfunc,id_paket,text){
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
                        id_paket: id_paket
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
                        className: "btn btn-success btn-sm",
                    },
                },
            });
            table_paket.ajax.reload();
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
