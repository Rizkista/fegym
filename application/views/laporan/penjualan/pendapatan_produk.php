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
                <div class="col-sm">
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
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table-responsive display table table-striped table-hover" id="tabel-pendapatan-produk">
                <thead>
                    <tr>
                        <th class="nowraping" width="5%">No</th>
                        <th class="nowraping" width="15%">Lokasi</th>
                        <th class="nowraping" width="10%">Nota</th>
                        <th class="nowraping" width="10%">Tanggal</th>
                        <th class="nowraping text-right" width="5%">Jenis</th>
                        <th class="nowraping text-right" width="10%">Harga</th>
                        <th class="nowraping text-right" width="10%">Diskon Produk</th>
                        <th class="nowraping text-right" width="10%">Diskon Transaksi</th>
                        <th class="nowraping text-right" width="10%">PPN</th>
                        <th class="nowraping text-right" width="10%">Charge</th>
                        <th class="nowraping text-right" width="10%">Total Transaksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-sub text-center p-2">
                <span id="tgl-show">-</span>
            </div>
            <table class="table-responsive table display table-striped table-hover no-footer dataTable" id="summary-pendapatan-produk">
                <thead>
                    <tr>
                        <th width="35%" class="nowraping">Nama Lokasi</th>
                        <th width="12%" class="border-left-0 border-right-0 text-right nowraping">Total Nota</th>
                        <th width="12%" class="border-left-0 border-right-0 text-right nowraping">Total Harga</th>
                        <th width="12%" class="border-left-0 border-right-0 text-right nowraping">Total Diskon Produk</th>
                        <th width="12%" class="border-left-0 border-right-0 text-right nowraping">Total Diskon Transaksi</th>
                        <th width="12%" class="border-left-0 border-right-0 text-right nowraping">Total PPN</th>
                        <th width="12%" class="border-left-0 border-right-0 text-right nowraping">Total Charge</th>
                        <th width="12%" class="border-left-0 border-right-0 text-right nowraping">Total Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
</div>