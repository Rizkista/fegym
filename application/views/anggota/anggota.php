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
                        <label class="label-filter">Status: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-status" id="filter-status">
                            <option value="aktif-" selected>Aktif</option>
                            <option value="hapus-">Terhapus</option>
                        </select>
                    </div>
                </div>
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
                        <label class="label-filter">Cari: </label>&nbsp;&nbsp;
                        <input type="text" class="form-control" name="filter-search" id="filter-search" placeholder="Cari">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="datatable-anggota" class="table-responsive display table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:2%;">No</th>
                        <th style="width:5%;">Kode</th>
                        <th style="width:20%;">Nama</th>
                        <th style="width:5%;">JK</th>
                        <th style="width:10%;">No.Hp</th>
                        <th style="width:15%;">Email</th>
                        <th style="width:25%;">Alamat</th>
                        <th style="width:30%;">Member</th>
                        <th style="width:10%;">Lokasi</th>
                        <th style="width:5%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-anggota" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-anggota" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="text-anggota">Anggota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="box-bg-grey mb-3">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td style="width:10%;">Nama <span class="text-danger">*</span></td>
                                                    <td style="width:2%;">&nbsp;:&nbsp;</td>
                                                    <td><input type="text" class="form-control form-rm" id="nama_anggota" name="nama_anggota" placeholder="Nama" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Gender <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>
                                                        <select class="form-control form-rm" name="gender_anggota" id="gender_anggota" style="padding: 0.4rem 0.5rem !important;" required>
                                                            <option value="">Pilih Gender</option>
                                                            <option value="L">L</option>
                                                            <option value="P">P</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>No. Hp <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="text" class="form-control form-rm" id="telp_anggota" name="telp_anggota" placeholder="No. Hp" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="email" class="form-control form-rm" id="email_anggota" name="email_anggota" placeholder="Email"></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><textarea class="form-control" name="alamat_anggota" id="alamat_anggota" placeholder="Alamat" style="padding: 0.25rem 0.5rem; min-height: 92px;"></textarea></td>
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
                        <input type="hidden" name="id_anggota">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Kembali</button>
                        <input class="btn btn-success btn-sm" type="submit" name="add_anggota" id="add_anggota" value="Tambah" readonly>
                        <input class="btn btn-success btn-sm" type="hidden" name="edit_anggota" id="edit_anggota" value="Ubah" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>