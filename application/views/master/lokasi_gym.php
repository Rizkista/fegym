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
            <table id="datatable-lokasi" class="table-responsive display table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:5%;">Kode</th>
                        <th style="width:20%;" class="nowraping">Nama Lokasi</th>
                        <th style="width:25%;">Alamat</th>
                        <th style="width:45%;">Admin</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-lokasi" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-lokasi" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-lokasi">Lokasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <div class="box-bg-grey">
                                        <span><b>- Data Lokasi -</b></span>
                                        <div class="mt-2">
                                            <table class="mb-0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td class="nowraping" width="10%">Kode <span class="text-danger">*</span></td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <div class="mytooltip">
                                                                <span class="tooltiptext">Digunakan untuk membuat kode nota setiap lokasi</span>
                                                                <input type="text" class="form-control form-rm" name="kode_lokasi" id="kode_lokasi" placeholder="3 Character" oninput="this.value = this.value.slice(0, 3).toUpperCase()" required>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="nowraping">Lokasi <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="nama_lokasi" id="nama_lokasi" placeholder="Nama Lokasi" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="nowraping">Alamat <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><textarea class="form-control" name="alamat_lokasi" id="alamat_lokasi" style="padding: 0.25rem 0.5rem; min-height: 92px;" placeholder="Alamat Lokasi" required></textarea></td>
                                                    </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-bg-grey mt-2">
                                        <span><b>- Data Admin -</b></span>
                                        <div class="mt-2">
                                            <table class="mb-0" width="100%">
                                                <tbody class="nowraping">
                                                    <tr>
                                                        <td width="10%">Nama <span class="text-danger">*</span></td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="nama" id="nama" placeholder="Nama Admin" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="email" class="form-control form-rm" name="email" id="email" placeholder="Email"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>No.Hp <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" id="telp" name="telp" placeholder="No. Hp" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Password </td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" id="password" name="password" placeholder="Password"></td>
                                                    </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_lokasi">
                        <input type="hidden" name="id_account">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Kembali</button>
                        <input class="btn btn-success btn-sm" type="submit" name="add_lokasi" id="add_lokasi" value="Tambah" readonly>
                        <input class="btn btn-success btn-sm" type="hidden" name="edit_lokasi" id="edit_lokasi" value="Ubah" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>