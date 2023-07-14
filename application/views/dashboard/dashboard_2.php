<!-- Dashboard Owner -->
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

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success-2 card-round">
                        <div class="card-body p-3">
                            <span class="stamp stamp-md bg-success">
                                <i class="fas fa-save"></i>
                            </span>
                            <div class="h2 mt-3 mb-2 fw-bold" id="total-anggota">0</div>
                            <h4 class="mb-1">Total Anggota</h4>
                            <h6 class="text-primary m-0"><span id="persen-total-anggota">0</span>% dari kemarin</h6>
                        </div>
                    </div>
                    <div class="card card-secondary-2 card-round">
                        <div class="card-body p-3">
                            <span class="stamp stamp-md bg-secondary">
                                <i class="fas fa-user-plus"></i>
                            </span>
                            <div class="h2 mt-3 mb-2 fw-bold" id="member-baru">0</div>
                            <h4 class="mb-1">Member Baru</h4>
                            <h6 class="text-primary m-0"><span id="persen-member-baru">0</span>% dari kemarin</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-warning-2 card-round">
                        <div class="card-body p-3">
                            <span class="stamp stamp-md bg-warning">
                                <i class="fa fa-book"></i>
                            </span>
                            <div class="h2 mt-3 mb-2 fw-bold" id="total-member">0</div>
                            <h4 class="mb-1">Total Member</h4>
                            <h6 class="text-primary m-0"><span id="persen-total-member">0</span>% dari kemarin</h6>
                        </div>
                    </div>
                    <div class="card card-danger-2 card-round">
                        <div class="card-body p-3">
                            <span class="stamp stamp-md bg-danger">
                                <i class="fas fa-tag"></i>
                            </span>
                            <div class="h2 mt-3 mb-2 fw-bold" id="member-expired">0</div>
                            <h4 class="mb-1">Member Expired</h4>
                            <h6 class="text-primary m-0"><span id="persen-member-expired">0</span>% dari kemarin</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <a class="pointer mr-1" id="cc">
                            <i class="far fa-calendar-alt"></i>
                        </a>
                        <input type="text" class="input-date-hide" id="date-grafik-statistik-pendaftaran" readonly>
                        <b>Statistik Pendaftaran</b>
                    </div>
                    <div id="grafik-statistik-pendaftaran" style="width:100%; height:273px;"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-3">
            <h4 class="page-title">Pembayaran</h4>
        </div>
        <div class="col-sm" style="margin-bottom:15px;">
            <div class="btn-group border-option form-filter">
                <label class="label-filter">Range: </label>&nbsp;&nbsp;
                <input type="hidden" name="start-date1">
                <input type="hidden" name="end-date1">
                <div id="bulanan1" class="btn-block">
                    <div style="width:100%">
                        <input type="text" class="form-control input-full pointer" id="bulan1" name="bulan1" style="background: white !important; opacity: 1 !important" readonly>
                    </div>
                </div>
                <div id="tahunan1" class="btn-group none">
                    <div style="width:100%">
                        <input type="text" class="form-control input-full pointer" id="tahun1" name="tahun1" style="background: white !important; opacity: 1 !important" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm" style="margin-bottom:15px;">
            <div class="btn-group border-option form-filter">
                <label class="label-filter">Lokasi: </label>&nbsp;&nbsp;
                <select class="form-control" name="filter-lokasi1" id="filter-lokasi1">
                    <option value="">Semua Lokasi</option>
                    <?php foreach ($data_lokasi as $list) { ?>
                        <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm" style="margin-bottom:15px;">
            <div class="btn-group border-option form-filter">
                <label class="label-filter">Filter: </label>&nbsp;&nbsp;
                <select class="form-control input-full" name="filter-tipe1" id="filter-tipe1">
                    <option value="1">Data Bulanan</option>
                    <option value="2">Data Tahunan</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="numbers width-full min-hight-1">
                        <p class="card-category">Total Transaksi</p>
                        <h4 class="card-title text-red loading" id="total_transaksi1">...</h4>
                    </div>
                </div>
            </div>
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="numbers width-full min-hight-1">
                        <p class="card-category">Total Pembayaran</p>
                        <h4 class="card-title text-red loading" id="total_pembayaran1">...</h4>
                    </div>
                </div>
            </div>
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="numbers width-full min-hight-1">
                        <p class="card-category" id="avrg1">Rata-Rata</p>
                        <h4 class="card-title text-red loading" id="rata_rata1">...</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card full-height">
                <div class="card-body">
                    <div id="morrisLine1" style="width:100%; height:80%; min-height:267px; max-height:267px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <h4 class="page-title">Penjualan</h4>
        </div>
        <div class="col-sm" style="margin-bottom:15px;">
            <div class="btn-group border-option form-filter">
                <label class="label-filter">Range: </label>&nbsp;&nbsp;
                <input type="hidden" name="start-date2">
                <input type="hidden" name="end-date2">
                <div id="bulanan2" class="btn-block">
                    <div style="width:100%">
                        <input type="text" class="form-control input-full pointer" id="bulan2" name="bulan2" style="background: white !important; opacity: 1 !important" readonly>
                    </div>
                </div>
                <div id="tahunan2" class="btn-group none">
                    <div style="width:100%">
                        <input type="text" class="form-control input-full pointer" id="tahun2" name="tahun2" style="background: white !important; opacity: 1 !important" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm" style="margin-bottom:15px;">
            <div class="btn-group border-option form-filter">
                <label class="label-filter">Lokasi: </label>&nbsp;&nbsp;
                <select class="form-control" name="filter-lokasi2" id="filter-lokasi2">
                    <option value="">Semua Lokasi</option>
                    <?php foreach ($data_lokasi as $list) { ?>
                        <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm" style="margin-bottom:15px;">
            <div class="btn-group border-option form-filter">
                <label class="label-filter">Filter: </label>&nbsp;&nbsp;
                <select class="form-control input-full" name="filter-tipe2" id="filter-tipe2">
                    <option value="1">Data Bulanan</option>
                    <option value="2">Data Tahunan</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="numbers width-full min-hight-1">
                        <p class="card-category">Total Transaksi</p>
                        <h4 class="card-title text-red loading" id="total_transaksi2">...</h4>
                    </div>
                </div>
            </div>
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="numbers width-full min-hight-1">
                        <p class="card-category">Total Penjualan</p>
                        <h4 class="card-title text-red loading" id="total_penjualan2">...</h4>
                    </div>
                </div>
            </div>
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="numbers width-full min-hight-1">
                        <p class="card-category" id="avrg2">Rata-Rata</p>
                        <h4 class="card-title text-red loading" id="rata_rata2">...</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card full-height">
                <div class="card-body">
                    <div id="morrisLine2" style="width:100%; height:80%; min-height:267px; max-height:267px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>