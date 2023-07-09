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

    <div class="card">
        <div class="card-body p-2">
            <input type="hidden" id="tab-menu" value="1">
            <ul class="nav-tabx m-0">
                <li class="w-2 active" id="li-1">
                    <a id="tab-1" href="#">Transaksi</a>
                </li>
                <li class="w-2" id="li-2" >
                    <a id="tab-2" href="#">Histori</a>
                </li>
            </ul>
        </div>
    </div>

    <div id="transaksi">
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
                                <input type="hidden" id="nama_lokasi" value="<?= $nama_lokasi ? $nama_lokasi['nama_lokasi'] : '' ?>">
                                <table class="mb-0 full-width">
                                    <tbody class="nowraping">
                                        <tr>
                                            <th width="10%"><i class="fas fa-map-marker-alt mr-2"></i><span id="info-lokasi"></span></th>
                                            <th width="2%" class="text-right"><?= date("d-m-Y") ?></th>
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
                                        <th style="width:40%; color:white;">Produk</th>
                                        <th style="width:15%; color:white; text-align:center;">Qty</th>
                                        <th style="width:15%; color:white; text-align:center; white-space:nowrap;">Diskon %</th>
                                        <th style="width:20%; color:white; text-align:right;">Price</th>
                                        <th style="width:10%; color:white; text-align:center; min-width:40px;">*</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right p-2">
                            <button class="btn btn-danger btn-sm fw-bold" type="button" id="reset_transaksi">Reset</button>
                            <button class="btn btn-success btn-sm fw-bold" type="submit" id="simpan_transaksi">Lanjutkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="histori" class="none">
        <div class="card">
            <div class="card-body p-2">
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
            <div class="card-body p-2">
                <table id="datatable-stok-masuk" class="table-responsive display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:15%;">Tanggal</th>
                            <th style="width:10%;">No.Faktur</th>
                            <th style="width:25%;">Produk</th>
                            <th style="width:5%;">Jumlah</th>
                            <th style="width:15%;">Supplier</th>
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
</div>