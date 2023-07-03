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
            <table id="datatable-katproduk" class="table-responsive display table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:60%;" class="nowraping">Nama Kategori</th>
                        <th style="width:30%;" class="nowraping">Lokasi Gym</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-katproduk" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-katproduk" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-katproduk">Kategori</h5>
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
                                                        <td width="10%">Nama Katgori <span class="text-danger">*</span></td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="nama_kat_produk" id="nama_kat_produk" placeholder="Kategori Produk" required></td>
                                                    </tr>
                                                    <tr class="lok-edit">
                                                        <td>Lokasi Gym <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <select class="form-control form-rm" name="id_lokasi" id="id_lokasi" required style="height: 29px !important; background-color: #fefefe !important; border-color: #dcdcdc !important;">
                                                                <option value="">Pilih Lokasi</option>
                                                                <?php foreach ($data_lokasi as $list){ ?>
                                                                    <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                                                                <?php } ?> 
                                                            </select>
                                                        </td>
                                                    </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_katproduk">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Kembali</button>
                        <input class="btn btn-success btn-sm" type="submit" name="add_katproduk" id="add_katproduk" value="Tambah" readonly>
                        <input class="btn btn-success btn-sm" type="hidden" name="edit_katproduk" id="edit_katproduk" value="Ubah" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>