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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mx-auto d-block">
                        <?php
                            if($account['photo'] == NULL || $account['photo'] == ''){ $photo = 'profile.jpg'; }
                            else{ $photo = $account['photo']; }
                        ?>
                        <img class="rounded-circle mx-auto d-block" src="<?= base_url() ?>assets/img/photo/<?= $photo; ?>" id="imgx" alt="Photo profile" width="180" height="180" style="object-fit: cover;">
                    </div>
                    <hr>
                    <div class="card-text">
                        <form id="form_photo" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="input-group">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="profile_image">Pilih foto...</label>
                                    <input type="file" accept=".jpg, .jpeg, .png" class="custom-file-input none" id="profile_image" name="profile_image" 
                                        onchange="imgx.src=window.URL.createObjectURL(this.files[0])" required>
                                </div>
                                <div class="input-group-append" style="margin-left:-75px">
                                    <button class="btn btn-secondary" id="ganti_foto" style="padding:0 8px 0 8px; height:calc(2.25rem + 2px)">Ubah Foto</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <form id="form_edit_password" class="<?= ($this->session->userdata('id_posisi') == 3 ? 'gone' : '') ?>" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card">
                    <div class="card-list p-3">
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Ubah Password</div>
                                <div class="card-category mt-0">Anda dapat mengubah password Anda</div>
                                <div class="box-bg-grey mt-3">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">Password Baru</td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td><input type="text" name="new_password1" class="form-control form-rm" placeholder="Password Baru"></td>
                                                </tr>
                                                <tr>
                                                    <td>Ulangi Password</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>
                                                        <input type="text" name="new_password2" class="form-control form-rm" placeholder="Ulangi Password">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="text-right mt-3">
                                    <button class="btn btn-secondary" id="simpan_password" style="padding:0 8px 0 8px; height:calc(2.25rem + 2px)">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <form id="form_edit_profil" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Ubah Profil</div>
                        <div class="card-category mt-0">Pastikan data yang anda lengkapi benar dan masih aktif</div>
                        <div class="box-bg-grey mt-3">
                            <div class="table-responsive">
                                <table class="mb-0" width="100%">
                                    <tbody class="nowraping">
                                        <tr>
                                            <td width="10%">Nama</td>
                                            <td width="2%">&nbsp;:&nbsp;</td>
                                            <td><input type="text" name="nama" value="<?= $account['nama']; ?>" class="form-control form-rm" placeholder="Nama" required></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><input type="text" name="email" value="<?= $account['email']; ?>" class="form-control form-rm" placeholder="Email"></td>
                                        </tr>
                                        <tr>
                                            <td>No.Hp</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><input type="text" name="telp" value="<?= $account['telp']; ?>" class="form-control form-rm" placeholder="No Hp" required></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><textarea class="form-control" name="alamat" placeholder="Alamat" style="padding: 0.25rem 0.5rem; min-height: 52px;" required><?= $account['alamat']; ?></textarea></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-right mt-3">
                            <button class="btn btn-secondary" id="simpan_profil" style="padding:0 8px 0 8px; height:calc(2.25rem + 2px)">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
