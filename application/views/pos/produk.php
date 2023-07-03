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
            <table id="datatable-produk" class="table-responsive display table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:10%;" class="nowraping">ID Barcode</th>
                        <th style="width:30%;">Produk</th>
                        <th style="width:10%;" class="nowraping">Harga Beli</th>
                        <th style="width:10%;" class="nowraping">Harga Jual</th>
                        <th style="width:5%;">Qty</th>
                        <th style="width:5%;">Satuan</th>
                        <th style="width:10%;">Kategori</th>
                        <th style="width:15%;">Lokasi</th>
                        <th style="width:5%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-produk" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-produk">Produk</h5>
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
                                                        <td width="10%">Nama Produk <span class="text-danger">*</span></td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td colspan="2"><input type="text" class="form-control form-rm" name="nama_produk" id="nama_produk" placeholder="Nama Produk" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ID Barcode </td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td colspan="2"><input type="text" class="form-control form-rm" name="barcode_produk" id="barcode_produk" placeholder="ID Barcode"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Satuan <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td colspan="2"><input type="text" class="form-control form-rm" name="satuan_produk" id="satuan_produk" placeholder="Satuan pcs/lainya" required></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Harga Beli <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td colspan="2"><input type="text" class="form-control form-rm" name="harga_beli" id="harga_beli" placeholder="0" data-type="currency" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Harga Jual <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td colspan="2"><input type="text" class="form-control form-rm" name="harga_jual" id="harga_jual" placeholder="0" data-type="currency" required></td>
                                                    </tr>
                                                    <tr class="lok-edit">
                                                        <td>Lokasi Gym <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td colspan="2">
                                                            <select class="form-control form-rm" name="id_lokasi" id="id_lokasi" style="height: 29px !important; background-color: #fefefe !important; border-color: #dcdcdc !important;">
                                                                <option value="">Pilih Lokasi</option>
                                                                <?php foreach ($data_lokasi as $list){ ?>
                                                                    <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                                                                <?php } ?> 
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kategori Produk <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <select class="form-control form-rm select-katpro kat-select" name="id_kat_produk" id="id_kat_produk" required disabled style="height: 29px !important; background-color: #fefefe !important; border-color: #dcdcdc !important;">
                                                                <option value="">Pilih Kategori</option>
                                                            </select>
                                                            <input type="text" class="form-control form-rm kat-new gone" name="new_id_kat_produk" id="new_id_kat_produk" placeholder="Tambah Kategori Baru">
                                                        </td>
                                                        <td width="2%">
                                                            <input class="btn form-rm select-katpro" type="button" id="new_kat" value="new" disabled style="background: #72a6d9;color: #fff;" readonly>
                                                            <input class="btn form-rm select-katpro gone" type="button" id="select_kat" value="select" disabled style="background: #72a6d9;color: #fff;" readonly>
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
                        <input type="hidden" name="id_produk">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Kembali</button>
                        <input class="btn btn-success btn-sm" type="submit" name="add_produk" id="add_produk" value="Tambah" readonly>
                        <input class="btn btn-success btn-sm" type="hidden" name="edit_produk" id="edit_produk" value="Ubah" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>