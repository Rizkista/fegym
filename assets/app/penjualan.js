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

    detail_transaksi();
    function detail_transaksi(){
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

                const harga_item = qty[i]*harga_jual;
                const diskon_item = harga_item*dis[i]/100;
                const price_item = harga_item-diskon_item;
                var show_price = diskon_item > 0 ? '<s style="color:gray; font-size:12px;">'+FormatCurrency(harga_item)+'</s> <br>'+FormatCurrency(price_item) : FormatCurrency(harga_item);
                
                html += '<tr>' +
                            '<input type="hidden" name="id_'+i+'" id="idt" class="form-control" value="'+id_produk+'">'+
                            '<input type="hidden" name="hrj_'+i+'" id="idt" class="form-control" value="'+harga_jual+'">'+
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
            }
        }

        $('body').on('click','#reset_transaksi',function(){
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
                    qty.splice(0, qty.length);
                    dis.splice(0, dis.length);
                    arr.splice(0, arr.length);
                    dataList();
                } else {
                    swal.close();
                }
            });
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
})(jQuery);