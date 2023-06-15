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
        <div class="col-md">
            <form id="form-konfigurasi" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card">
                    <div class="card-list p-3">
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Info Personalia</div>
                                <div class="card-category mt-0">Bagian personalia untuk melakukan konfirmasi atau mengubah data.</div>
                                <div class="box-bg-grey mt-2">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">No Whatsapp <span class="text-danger">*</span></td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td><input type="text" name="telp_personalia" class="form-control form-rm" placeholder="62" required></td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Setting Absensi</div>
                                <div class="card-category mt-0">Menyesuaikan pembulatan dari keterlambatan dan pulang awal (menit).</div>
                                <div class="box-bg-grey mt-2">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">Keterlambatan <span class="text-danger">*</span></td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="keterlambatan" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Pulang Awal <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="pulang_awal" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Perhitungan BPJS</div>
                                <div class="card-category mt-0">Hanya bersifat sebagai keterangan dan tidak digunakan untuk perhitungan (%).</div>
                                <div class="box-bg-grey mt-2">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">BPJS</td>
                                                    <td width="2%"></td>
                                                    <td>Klinik</td>
                                                    <td>Karyawan</td>
                                                </tr>
                                                <tr>
                                                    <td>Kesehatan</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="bpjs_dtnik_kesehatan" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                    <td><input type="number" name="bpjs_dtwan_kesehatan" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>TK</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="bpjs_dtnik_tk" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                    <td><input type="number" name="bpjs_dtwan_tk" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Perhitungan PPh 21</div>
                                <div class="card-category mt-0">Menentukan nominal PPh 21 dengan ketentuan wajib memiliki NPWP.</div>
                                <div class="box-bg-grey mt-2">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">% Dari Gaji <span class="text-danger">*</span></td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="pph21_persen_gaji" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Gaji <b>></b> Dari<span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>
                                                        <input type="text" name="pph21_ketentuan_gaji" data-type="currency" class="form-control form-rm" placeholder="0" required>
                                                    </td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Setting Ijin/Cuti</div>
                                <div class="card-category mt-0">Menyesuaikan potongan cuti dari masing-masing ijin/cuti (shift).</div>
                                <div class="box-bg-grey mt-2">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">Cuti Tahunan <span class="text-danger">*</span></td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="cuti_tahunan" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Cuti Menikah <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="cuti_menikah" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Cuti Melahirkan <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="cuti_melahirkan" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Ijin Pribadi <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="ijin_pribadi" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Ijin Duka <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="ijin_duka" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Ijin Sakit <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="number" name="ijin_sakit" step="0.1" min="0" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Transfer Default</div>
                                <div class="card-category mt-0">Menentukan default bank unutuk penggajian dan biaya transfer beda bank.</div>
                                <div class="box-bg-grey mt-2">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">Default Bank <span class="text-danger">*</span></td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td><input type="text" name="default_bank" class="form-control form-rm" placeholder="Nama Bank" required oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"></td>
                                                </tr>
                                                <tr>
                                                    <td>Biaya TF Beda Bank <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="text" name="biaya_transfer" data-type="currency" class="form-control form-rm" placeholder="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Gaji <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td>
                                                        <input type="text" name="tanggal_gaji" class="form-control form-rm" placeholder="__" required>
                                                    </td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Email Lupa Password</div>
                                <div class="card-category mt-0">Konfigurasi email admin untuk mengirim pesan lupa password.</div>
                                <div class="box-bg-grey mt-2">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">smtp_host <span class="text-danger">*</span></td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td><input type="text" class="form-control form-rm" name="smtp_host" placeholder="smtp.domain.com" required></td>
                                                </tr>
                                                <tr>
                                                    <td>smtp_port <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="text" class="form-control form-rm" name="smtp_port" placeholder="465" required></td>
                                                </tr>
                                                <tr>
                                                    <td>smtp_user <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="text" class="form-control form-rm" name="smtp_user" placeholder="user@email" required></td>
                                                </tr>
                                                <tr>
                                                    <td>smtp_pass <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="text" class="form-control form-rm" name="smtp_pass" placeholder="password" required></td>
                                                </tr>
                                                <tr>
                                                    <td>initial_name <span class="text-danger">*</span></td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td><input type="text" class="form-control form-rm" name="initial_name" placeholder="username" required></td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-right p-3">
                        <button class="btn btn-secondary btn-sm px-3" type="submit" id="simpan_konfigurasi">
                            <span class="btn-label mr-2"><i class="fa fa-plus"></i></span>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title fw-bold">Online Account</div>
                    <p class="card-category" style="line-height: 1.5;">Menampilkan seluruh daftar account yang sedang aktif.</p>
                    <a id="logout_all_account" class="btn btn-danger btn-sm mt-3 px-4 text-white">Keluarkan semua akun</a>
                </div>
                <div class="tableBodyScroll mb-3">
                    <div class="card-body py-0">
                        <div class="card-list">
                            <?php foreach ($account_online as $list) { ?>
                                <div class="item-list py-2">
                                    <div class="avatar avatar-online">
                                        <img src="<?= base_url().'assets/img/photo/'.$list->foto ?>" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                    <div class="info-user mx-3">
                                        <div class="fw-bold mb-1"><?= $list->nama ?></div>
                                        <div class="status"><?= $list->email ?></div>
                                    </div>
                                    <div class="d-flex ml-auto align-items-center">
                                        <p class="text-info fw-bold"><?= $list->kode_cabang ?></p>
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