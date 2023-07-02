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
                
                $transaksi = array(
                    'pembayaran',
                    'point-of-sale',
                );
                $pos = array(
                    'produk',
                    'kategori-produk',
                    'stok-masuk',
                    'stok-keluar',
                    'opname-stok',
                );
                $master = array(
                    'paket-gym',
                    'cabang-gym',
                );
                $laporan = array(
                    'laporan-pembayaran-gym',
                    'laporan-penjualan-produk',
                );
                $pengaturan = array(
                    'konfigurasi',
                    'akun-saya',
                );
            ?> 
            <ul class="nav">
                <li <?= $uri_path == 'dashboard' ? 'class="nav-item active"' : 'class="nav-item" ' ?>>
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item <?= !$cekmenu['anggota'] ? 'gone' : '' ?><?= $uri_path == 'anggota' ? 'active' : '' ?>">
                    <a href="<?= base_url('anggota') ?>">
                        <i class="fas fa-users"></i>
                        <p>Anggota</p>
                    </a>
                </li>
                <li class="nav-item <?= in_array($uri_path, $transaksi) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#transaksi">
                        <i class="fas fa-money-check-alt"></i>
                        <p>Transaksi</p>
                        <span class="caret"></span>
                    </a>
                    <div id="transaksi" <?= in_array($uri_path, $transaksi) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= $uri_path == "pembayaran"? 'active' : '' ?>">
                                <a href="<?= base_url('pembayaran') ?>">
                                    <span class="sub-item">Pembayaran</span>
                                </a>
                            </li>
                            <li class="<?= $uri_path == "point-of-sale"? 'active' : '' ?>">
                                <a href="<?= base_url('point-of-sale') ?>">
                                    <span class="sub-item">Point Of Sale</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?= in_array($uri_path, $pos) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#pos">
                        <i class="fas fa-shopping-cart"></i>
                        <p>POS</p>
                        <span class="caret"></span>
                    </a>
                    <div id="pos" <?= in_array($uri_path, $pos) ? 'class="collapse show"' : 'class="collapse"' ?>>
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
                            <li class="<?= $uri_path == "opname-stok"? 'active' : '' ?>">
                                <a href="<?= base_url('opname-stok') ?>">
                                    <span class="sub-item">Opname Stok</span>
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
                    <div id="master" <?= in_array($uri_path, $master) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= $uri_path == "paket-gym"? 'active' : '' ?>">
                                <a href="<?= base_url('paket-gym') ?>">
                                    <span class="sub-item">Paket Gym</span>
                                </a>
                            </li>
                            <li class="<?= $uri_path == "cabang-gym"? 'active' : '' ?>">
                                <a href="<?= base_url('cabang-gym') ?>">
                                    <span class="sub-item">Cabang Gym</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?= in_array($uri_path, $laporan) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#laporan">
                        <i class="fas fa-chart-bar"></i>
                        <p>Laporan</p>
                        <span class="caret"></span>
                    </a>
                    <div id="laporan" <?= in_array($uri_path, $laporan) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= $uri_path == "laporan-pembayaran-gym"? 'active' : '' ?>">
                                <a href="<?= base_url('laporan-pembayaran-gym') ?>">
                                    <span class="sub-item">Laporan Pembayaran Gym</span>
                                </a>
                            </li>
                            <li class="<?= $uri_path == "laporan-penjualan-produk"? 'active' : '' ?>">
                                <a href="<?= base_url('laporan-penjualan-produk') ?>">
                                    <span class="sub-item">Laporan Penjualan Produk</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?= in_array($uri_path, $pengaturan) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#pengaturan">
                        <i class="fas fa-cog"></i>
                        <p>Pengaturan</p>
                        <span class="caret"></span>
                    </a>
                    <div id="pengaturan" <?= in_array($uri_path, $pengaturan) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= $uri_path == "konfigurasi"? 'active' : '' ?>">
                                <a href="<?= base_url('konfigurasi') ?>">
                                    <span class="sub-item">Konfigurasi</span>
                                </a>
                            </li>
                            <li class="<?= $uri_path == "akun-saya"? 'active' : '' ?>">
                                <a href="<?= base_url('akun-saya') ?>">
                                    <span class="sub-item">Akun Saya</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Developer</h4>
                </li>
                <li class="nav-item <?= $uri_path == 'account' ? 'active' : '' ?>">
                    <a href="<?= base_url('account') ?>">
                        <i class="fas fa-users-cog"></i>
                        <p>Account</p>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>