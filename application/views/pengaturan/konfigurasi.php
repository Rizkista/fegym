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
        <div class="col-md-7">
            <form id="form_edit_office" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card">
                    <div class="card-body">
                        <div class="item-list pb-2">
                            <div class="info-user">
                                <div class="card-title">Ubah Perusahaan</div>
                                <div class="card-category mt-0">Pastikan data yang anda lengkapi benar dan masih aktif</div>
                                <div class="box-bg-grey mt-3">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">Nama Office</td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td><input type="text" name="nama_office" value="<?= $office['nama_office']; ?>" class="form-control form-rm" placeholder="Nama Office" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Email Office</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="text" name="email_office" value="<?= $office['email_office']; ?>" class="form-control form-rm" placeholder="Email Office"></td>
                                                </tr>
                                                <tr>
                                                    <td>No.Hp Office</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="text" name="telp_office" value="<?= $office['telp_office']; ?>" class="form-control form-rm" placeholder="No.Hp Office" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat Office</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><textarea class="form-control" name="alamat_office" placeholder="Alamat Office" style="padding: 0.25rem 0.5rem; min-height: 52px;" required><?= $office['alamat_office']; ?></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Ubah Data Nota</div>
                                <div class="card-category mt-0">Setting header, footer dan logo pada nota yang akan di cetak</div>
                                <div class="box-bg-grey mt-3">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">Logo</td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td>
                                                        <?php 
                                                            $src = "";
                                                            if($office['nota_logo'] != NULL || $office['nota_logo'] != ''){
                                                                $src = base_url().'/assets/img/logo_nota/'.$office['nota_logo'];
                                                            }
                                                        ?>
                                                        <label class="btn card-box ans-box full-width py-2" style="white-space: normal;">
                                                            <span>Pilih Image</span><br><br>
                                                            <img id="pic" style="max-width:120px; max-height:120px; border:none;" src="<?= $src ?>"><br><br> 
                                                            <i style="font-size:11px!important;">Pastikan extension image adalah .png</i>
                                                            <input type="file" accept=".png" style="display: none;" id="logo_nota" name="logo_nota" onchange="pic.src=window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Nota Header</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><textarea class="form-control" name="nota_header" placeholder="Header" style="padding: 0.25rem 0.5rem; min-height: 88px;" required><?= $office['nota_header']; ?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>Nota Footer</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><textarea class="form-control" name="nota_footer" placeholder="Footer" style="padding: 0.25rem 0.5rem; min-height: 88px;" required><?= $office['nota_footer']; ?></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-3">
                            <button class="btn btn-secondary" id="simpan_office" style="padding:0 8px 0 8px; height:calc(2.25rem + 2px)">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title fw-bold">Online Account</div>
                    <p class="card-category" style="line-height: 1.5;">Menampilkan seluruh daftar account yang sedang aktif.</p>
                </div>
                <div class="tableBodyScroll mb-3">
                    <div class="card-body py-0">
                        <div class="card-list">
                            <?php foreach ($account_online as $list) { ?>
                                <div class="item-list py-2">
                                    <div class="avatar avatar-online">
                                        <img src="<?= base_url().'assets/img/photo/profile.jpg' ?>" alt="..." style="width: 45px;height: 45px;" class="avatar-img rounded-circle">
                                    </div>
                                    <div class="info-user mx-3">
                                        <div class="fw-bold mb-1"><?= $list->nama ?></div>
                                        <div class="status"><?= $list->email ?></div>
                                    </div>
                                    <div class="d-flex ml-auto align-items-center">
                                        <p class="text-info fw-bold"><?= $list->kode_lokasi ?></p>
                                    </div>
                                </div>
                                <div class="separator-dashed m-0"></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
