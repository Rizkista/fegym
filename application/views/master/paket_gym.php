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
                <div class="col-sm <?= ($this->session->userdata('id_posisi') == 3 ? 'gone' : '') ?>">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Lokasi: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-lokasi" id="filter-lokasi">
                            <option value="">Semua Lokasi</option>
                            <?php foreach ($data_lokasi as $list){ ?>
                                <option value="-<?= $list->id_lokasi ?>-"><?= $list->nama_lokasi ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Status: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-status" id="filter-status">
                            <option value="aktif-" selected>Aktif</option>
                            <option value="hapus-">Terhapus</option>
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
            <table id="datatable-paket" class="table-responsive display table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:35%;">Nama</th>
                        <th style="width:10%;">Harga</th>
                        <th style="width:10%;" class="nowraping">Lama Durasi</th>
                        <th style="width:5%;" class="nowraping">Status Member</th>
                        <th style="width:15%;">Lokasi</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-paket" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-paket" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-paket">Paket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <div class="box-bg-grey">
                                        <div class="table-responsive">
                                            <table class="mb-0" width="100%">
                                                <tbody class="nowraping">
                                                    <tr>
                                                        <td width="10%">Nama Paket <span class="text-danger">*</span></td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="nama_paket" id="nama_paket" placeholder="Nama Paket" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Harga (IDR) <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="harga_paket" id="harga_paket" placeholder="0" data-type="currency" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Durasi Paket <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <select class="form-control form-rm" name="durasi_paket" id="durasi_paket" required style="padding: 0.4rem 0.5rem !important;">
                                                                <option value="">Pilih Durasi</option>
                                                                <option value="1">MINUTE</option>
                                                                <option value="2">DAY</option>
                                                                <option value="3">WEEK</option>
                                                                <option value="4">MONTH</option>
                                                                <option value="5">YEAR</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Lama Durasi <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="number" class="form-control form-rm" name="lama_durasi" id="lama_durasi" min="0" placeholder="0" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status Member <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <select class="form-control form-rm" name="status_member" id="status_member" required style="padding: 0.4rem 0.5rem !important;">
                                                                <option value="">Pilih Status</option>
                                                                <option value="1">AKTIF</option>
                                                                <option value="0">TIDAK</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr class="lok-edit">
                                                        <td>Lokasi Gym <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <select class="form-control form-rm" name="id_lokasi" id="id_lokasi" required style="padding: 0.4rem 0.5rem !important;">
                                                                <option value="">Pilih Lokasi</option>
                                                                <?php foreach ($data_lokasi as $list){ ?>
                                                                    <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                                                                <?php } ?> 
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_paket">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Kembali</button>
                        <input class="btn btn-success btn-sm" type="submit" name="add_paket" id="add_paket" value="Tambah" readonly>
                        <input class="btn btn-success btn-sm" type="hidden" name="edit_paket" id="edit_paket" value="Ubah" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>