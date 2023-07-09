<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= $title ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= base_url('dashboard') ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href=""><?= $title ?></a>
            </li>
        </ul>
    </div>

    <div id="show-stok">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Tanggal: </label>&nbsp;&nbsp;
                            <div style="width:100%" id="reportrange">
                                <input type="text" class="form-control input-full pointer" id="daterange" name="daterange" style="background: white !important;" readonly>
                                <input type="hidden" name="start-date">
                                <input type="hidden" name="end-date">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm <?= ($this->session->userdata('id_posisi') == 3 ? 'gone' : '') ?>">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Lokasi: </label>&nbsp;&nbsp;
                            <select class="form-control" name="filter-lokasi" id="filter-lokasi">
                                <option value="">Semua Lokasi</option>
                                <?php foreach ($data_lokasi as $list){ ?>
                                    <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Status: </label>&nbsp;&nbsp;
                            <select class="form-control" name="filter-status" id="filter-status">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Terhapus</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Cari: </label>&nbsp;&nbsp;
                            <input type="text" class="form-control" name="filter-search" id="filter-search" placeholder="Cari">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="datatable-stok-keluar" class="table-responsive display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:15%;">Tanggal</th>
                            <th style="width:10%;">No.Keluar</th>
                            <th style="width:25%;">Produk</th>
                            <th style="width:5%;">Jumlah</th>
                            <th style="width:15%;">Keterangan</th>
                            <th style="width:15%;">Lokasi</th>
                            <th style="width:15%;" id="text-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="add-stok" class="none">
        <div class="row">
            <div class="col-md-6">
                <div class="card <?= ($this->session->userdata('id_posisi') == 3 ? 'gone' : '') ?>">
                    <div class="card-header p-2">
                        <div>
                            <div class="btn-group border-option m-0">
                                <label class="label-filter">Lokasi: </label>&nbsp;&nbsp;
                                <select class="form-control" name="pilih-lokasi" id="pilih-lokasi">
                                    <option value="0">Pilih Lokasi</option>
                                    <?php foreach ($data_lokasi as $list){ ?>
                                        <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2">
                        <div class="btn-group p-1 bg-grey3 btn-full">
                            <input type="text" class="form-control" name="list-search" id="list-search" placeholder="Barcode / Produk">
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <table id="datatable-list-produk" class="table-responsive display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width:20%;">Barcode</th>
                                    <th style="width:75%;">Produk</th>
                                    <th style="width:10%;">Stok</th>
                                </tr>
                            </thead>
                            <tbody class="cursor-cell">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <form id="form-item" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="card-header p-2">
                            <div class="box-bg-grey">
                                <table class="mb-0 full-width">
                                    <tbody class="nowraping">
                                        <tr>
                                            <td width="25%">Tanggal <span class="text-danger">*</span></td>
                                            <td width="2%">&nbsp;:&nbsp;</td>
                                            <td width="75%"><input type="text" class="form-control input-full pointer sm-height tgl" id="tgl_keluar" name="tgl_keluar" style="background: white !important; opacity: 1 !important;" value="<?= date("d-m-Y") ?>" readonly required></td>
                                        </tr>
                                        <tr valign="top">
                                            <td>Keterangan <span class="text-danger">*</span></td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><textarea class="form-control" name="keterangan" id="keterangan" style="padding: 0.25rem 0.5rem; min-height: 52px;" placeholder="Keterangan" required></textarea></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body p-2" style="min-height:150px">
                            <table id="produk-item" class="table-responsive display table table-striped table-hover table-mini">
                                <thead>
                                    <tr class="bg-blue-smooth3">
                                        <th style="width:5%; color:white;">No</th>
                                        <th style="width:50%; color:white;">Produk</th>
                                        <th style="width:15%; color:white;">Satuan</th>
                                        <th style="width:20%; color:white; text-align:center;">Jumlah</th>
                                        <th style="width:10%; color:white; text-align:center;">*</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right p-2">
                            <button class="btn btn-success btn-sm" type="submit" id="simpan_transaksi">
                                <span class="btn-label mr-2"><i class="fas fa-save"></i></span>Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-alasan-hapus" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-body text-center">
                    <h5 class="modal-title py-3" style="color:rgba(0,0,0,.65);font-weight:600;font-size:27px;line-height:normal;">Hapus Stok Keluar</h5>
                    <div class="" style="width:100% !important; padding:15px; border-radius:4px; font-size:13px; background-color:#f7d9d9;">
                        <span>Apakah anda yakin ingin menghapus data stok keluar dengan nota</span><br>
                        <b><span id="no-nota">...</span></b>
                        <textarea id="alasan-hapus" style="min-height:100px;" class="form-control mt-2" placeholder="Alasan di Hapus . . ." required></textarea>
                    </div>
                    <div class="py-3">
                        <input type="hidden" name="id_stok_keluar">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="hapus">Lanjutkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-nota" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="cetak-nota">
                    <style type="text/css">
                        .nota {
                            width: 100%; 
                            line-height: normal; 
                            font-size: 12px; 
                            color: #000 !important; 
                            padding: 0 2px; 
                            font-family: 'Open Sans', sans-serif;
                        }
                        .nota table {
                            font-size: 12px !important;
                        }
                        .mb5 {
                            margin-bottom: 5px;
                        }
                        .w100 {
                            width: 100%;
                        }
                        .right-text {
                            text-align: right;
                        }
                        .left-text {
                            text-align: left;
                        }
                        .under-line {
                            border-bottom: 1px solid #000;
                        }
                        .detail {
                            width: 20%; 
                            min-width: 60px; 
                            text-align: right;
                            white-space: nowrap;
                        }
                    </style>
                    <div class="nota">
                        <table class="w100 mb5">
                            <tr>
                                <th class="left-text">Stok Keluar</th>
                                <th class="right-text" id="lokasi">...</th>
                            </tr>
                            <tr>
                                <td id="tgl">...</td>
                                <td class="right-text">Nota: <span id="nota">...</span></td>
                            </tr>
                        </table>
                        <table class="w100">
                            <tr>
                                <th width="10%" class="left-text under-line">No</th>
                                <th class="left-text under-line">Produk</th>
                                <th width="10%" class="detail under-line">Jumlah</th>
                            </tr>
                            <tbody id="data-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-danger btn-xs" data-dismiss="modal" aria-label="Close">Batal</button>
                <button class="btn btn-success btn-xs" onclick="printNota('cetak-nota')">Cetak</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function printNota(idName) {
        var printContents = document.getElementById(idName).innerHTML;
        var originalContents = document.body.innerHTML;
        var winPrint = window.open('', '', 'left=0,top=0,width=600,height=600,toolbar=1,scrollbars=1,status=0');
        winPrint.document.body.innerHTML = printContents;
        winPrint.focus();
        winPrint.print();
        winPrint.document.body.innerHTML = originalContents;
        winPrint.close();
    }
</script>