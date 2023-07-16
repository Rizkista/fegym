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
        <div class="card-header">
            <div class="card-head-row">
                <div class="card-title">
                    <span class="fw-bold">Lokasi : <span id="info-lokasi"></span></span>
                    <p class="mb-0 text-grey normal-line" id="tgl-show">16 July 2023 - 16 July 2023</p>
                </div>
                <div class="card-tools">
                    <button class="dt-button btn btn-secondary wid-max-select text-white m-0" type="button" id="export-excel">
                        <span><i id="icon" class="fas fa-file-excel mr-2"></i> Excel</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-hover table-kasir" id="tabel-rekap-kasir-paket">
                    <thead>
                        <tr>
                            <th class="text-left">DESKRIPSI</th>
                            <th class="text-right">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>