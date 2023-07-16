<div class="sidebar">
    <div class="sidebar-background"></div>
    <div class="user">
        <a onClick="window.location.href=window.location.href" class="pointer">
            <img src="<?= base_url() ?>assets/img/logo-white.svg">
        </a>
    </div>
    <div class="sidebar-wrapper scrollbar-inner">
        <div class="sidebar-content">
            <?php
                //Data URI  
                $uri_path = $this->uri->segment(1);
                $posisi = $this->session->userdata('id_posisi');
                
                $pos = array(
                    'produk',
                    'kategori-produk',
                    'stok-masuk',
                    'stok-keluar',
                    'stok-opname',
                );
                $master = array(
                    'paket-gym',
                    'lokasi-gym',
                );
                $pengaturan = array(
                    'akun-saya',
                    'konfigurasi',
                );
                $laporan = array(
                    'pendapatan-paket',
                    'rekap-total-paket',
                    'rekap-kasir-paket',
                    'pendapatan-produk',
                    'rekap-total-produk',
                    'rekap-kasir-produk',
                );
                $bayar = array(
                    'pendapatan-paket',
                    'rekap-total-paket',
                    'laporan-kasir-paket',
                    'rekap-kasir-paket',
                );
                $jual = array(
                    'pendapatan-produk',
                    'rekap-total-produk',
                    'laporan-kasir-produk',
                    'rekap-kasir-produk',
                );
            ?> 
            <ul class="nav">
                <li class="nav-item <?= $uri_path == 'dashboard' ? 'active' : '' ?>">
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php $posisi = $this->session->userdata('id_posisi');
                if($posisi == 2 || $posisi == 3){ ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Menu</h4>
                    </li>
                    <li class="nav-item <?= $uri_path == 'anggota' ? 'active' : '' ?>">
                        <a href="<?= base_url('anggota') ?>">
                            <i class="fas fa-users"></i>
                            <p>Anggota</p>
                        </a>
                    </li>
                    <li class="nav-item <?= $uri_path == 'pembayaran' ? 'active' : '' ?>">
                        <a href="<?= base_url('pembayaran') ?>">
                            <i class="fas fa-credit-card"></i>
                            <p>Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item <?= $uri_path == 'penjualan' ? 'active' : '' ?>">
                        <a href="<?= base_url('penjualan') ?>">
                            <i class="fas fa-money-check-alt"></i>
                            <p>Penjualan</p>
                        </a>
                    </li>
                    <li class="nav-item <?= in_array($uri_path, $pos) ? 'active submenu' : '' ?>">
                        <a data-toggle="collapse" href="#pos">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Point Of Sale</p>
                            <span class="caret"></span>
                        </a>
                        <div id="pos" class="collapse <?= in_array($uri_path, $pos) ? 'show' : ''?>">
                            <ul class="nav nav-collapse">
                                <li class="<?= $uri_path == "produk"? 'active' : '' ?>">
                                    <a href="<?= base_url('produk') ?>">
                                        <span class="sub-item">Produk</span>
                                    </a>
                                </li>
                                <li class="<?= $uri_path == "kategori-produk"? 'active' : '' ?>">
                                    <a href="<?= base_url('kategori-produk') ?>">
                                        <span class="sub-item">Kategori Produk</span>
                                    </a>
                                </li>
                                <li class="<?= $uri_path == "stok-masuk"? 'active' : '' ?>">
                                    <a href="<?= base_url('stok-masuk') ?>">
                                        <span class="sub-item">Stok Masuk</span>
                                    </a>
                                </li>
                                <li class="<?= $uri_path == "stok-keluar"? 'active' : '' ?>">
                                    <a href="<?= base_url('stok-keluar') ?>">
                                        <span class="sub-item">Stok Keluar</span>
                                    </a>
                                </li>
                                <li class="<?= $uri_path == "stok-opname"? 'active' : '' ?>">
                                    <a href="<?= base_url('stok-opname') ?>">
                                        <span class="sub-item">Stok Opname</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item <?= in_array($uri_path, $master) ? 'active submenu' : '' ?>">
                        <a data-toggle="collapse" href="#master">
                            <i class="fas fa-sitemap"></i>
                            <p>Master</p>
                            <span class="caret"></span>
                        </a>
                        <div id="master" class="collapse <?= in_array($uri_path, $master) ? 'show' : '' ?>">
                            <ul class="nav nav-collapse">
                                <li class="<?= $uri_path == "paket-gym"? 'active' : '' ?>">
                                    <a href="<?= base_url('paket-gym') ?>">
                                        <span class="sub-item">Paket Gym</span>
                                    </a>
                                </li>
                                <li class="<?= $uri_path == "lokasi-gym"? 'active' : '' ?> <?= $posisi == 3 ? 'gone' : '' ?>">
                                    <a href="<?= base_url('lokasi-gym') ?>">
                                        <span class="sub-item">Lokasi Gym</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item <?= $posisi == 3 ? 'gone' : '' ?> <?= in_array($uri_path, $laporan) ? 'active submenu' : '' ?>">
                        <a data-toggle="collapse" href="#laporan">
                            <i class="fas fa-chart-bar"></i>
                            <p>Laporan</p>
                            <span class="caret"></span>
                        </a>
                        <div id="laporan" class="collapse <?= in_array($uri_path, $laporan) ? 'show' : '' ?>">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a data-toggle="collapse" href="#bayar" class="collapsed" aria-expanded="false">
                                        <span class="sub-item">Pembayaran</span>
                                        <span class="caret"></span>
                                    </a>
                                    <div id="bayar" class="collapse <?= in_array($uri_path, $bayar) ? 'show' : '' ?>">
                                        <ul class="nav nav-collapse subnav">
                                            <li class="<?= $uri_path == "pendapatan-paket"? 'active' : '' ?>">
                                                <a href="<?= base_url('pendapatan-paket') ?>">
                                                    <span class="sub-item">Pendapatan Paket</span>
                                                </a>
                                            </li>
                                            <li class="<?= $uri_path == "rekap-total-paket"? 'active' : '' ?>">
                                                <a href="<?= base_url('rekap-total-paket') ?>">
                                                    <span class="sub-item">Rekap Total Paket</span>
                                                </a>
                                            </li>
                                            <li class="<?= $uri_path == "rekap-kasir-paket"? 'active' : '' ?>">
                                                <a href="<?= base_url('rekap-kasir-paket') ?>">
                                                    <span class="sub-item">Rekap Kasir Paket</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a data-toggle="collapse" href="#jual" class="collapsed" aria-expanded="false">
                                        <span class="sub-item">Penjualan</span>
                                        <span class="caret"></span>
                                    </a>
                                    <div id="jual" class="collapse <?= in_array($uri_path, $jual) ? 'show' : '' ?>">
                                        <ul class="nav nav-collapse subnav">
                                            <li class="<?= $uri_path == "pendapatan-produk"? 'active' : '' ?>">
                                                <a href="<?= base_url('pendapatan-produk') ?>">
                                                    <span class="sub-item">Pendapatan Produk</span>
                                                </a>
                                            </li>
                                            <li class="<?= $uri_path == "rekap-total-produk"? 'active' : '' ?>">
                                                <a href="<?= base_url('rekap-total-produk') ?>">
                                                    <span class="sub-item">Rekap Total Produk</span>
                                                </a>
                                            </li>
                                            <li class="<?= $uri_path == "rekap-kasir-produk"? 'active' : '' ?>">
                                                <a href="<?= base_url('rekap-kasir-produk') ?>">
                                                    <span class="sub-item">Rekap Kasir Produk</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item <?= $posisi == 3 ? 'gone' : '' ?> <?= in_array($uri_path, $pengaturan) ? 'active submenu' : '' ?>">
                        <a data-toggle="collapse" href="#pengaturan">
                            <i class="fas fa-cog"></i>
                            <p>Pengaturan</p>
                            <span class="caret"></span>
                        </a>
                        <div id="pengaturan" class="collapse <?= in_array($uri_path, $pengaturan) ? 'show' : '' ?>">
                            <ul class="nav nav-collapse">
                                <li class="<?= $uri_path == "akun-saya"? 'active' : '' ?>">
                                    <a href="<?= base_url('akun-saya') ?>">
                                        <span class="sub-item">Akun Saya</span>
                                    </a>
                                </li>
                                <li class="<?= $uri_path == "konfigurasi"? 'active' : '' ?>">
                                    <a href="<?= base_url('konfigurasi') ?>">
                                        <span class="sub-item">Konfigurasi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item pointer">
                        <a id="log_out_click">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Log Out</p>
                        </a>
                    </li>
                <?php }else if($posisi == 1){ ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Developer</h4>
                    </li>
                    <!-- <li class="nav-item <?= $uri_path == 'account' ? 'active' : '' ?>">
                        <a href="<?= base_url('account') ?>">
                            <i class="fas fa-users-cog"></i>
                            <p>Account</p>
                        </a>
                    </li> -->
                <?php } ?>
            </ul>

        </div>
    </div>
</div>