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
                <li class="nav-item <?= !$cekmenu['users'] ? 'gone' : '' ?><?= $uri_path == 'users' ? 'active' : '' ?>">
                    <a href="<?= base_url('users') ?>">
                        <i class="fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>