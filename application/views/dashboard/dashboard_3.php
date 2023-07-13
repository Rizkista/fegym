<!-- Dashboard Admin -->
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
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success-2 card-round">
                        <div class="card-body p-3">
                            <span class="stamp stamp-md bg-success">
                                <i class="fas fa-save"></i>
                            </span>
                            <div class="h2 mt-3 mb-2 fw-bold" id="total-anggota">0</div>
                            <h4 class="mb-1">Total Anggota</h4>
                            <h6 class="text-primary m-0"><span id="persen-total-anggota">0</span>% dari kemarin</h6>
                        </div>
                    </div>
                    <div class="card card-secondary-2 card-round">
                        <div class="card-body p-3">
                            <span class="stamp stamp-md bg-secondary">
                                <i class="fas fa-user-plus"></i>
                            </span>
                            <div class="h2 mt-3 mb-2 fw-bold" id="member-baru">0</div>
                            <h4 class="mb-1">Member Baru</h4>
                            <h6 class="text-primary m-0"><span id="persen-member-baru">0</span>% dari kemarin</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-warning-2 card-round">
                        <div class="card-body p-3">
                            <span class="stamp stamp-md bg-warning">
                                <i class="fa fa-book"></i>
                            </span>
                            <div class="h2 mt-3 mb-2 fw-bold" id="total-member">0</div>
                            <h4 class="mb-1">Total Member</h4>
                            <h6 class="text-primary m-0"><span id="persen-total-member">0</span>% dari kemarin</h6>
                        </div>
                    </div>
                    <div class="card card-danger-2 card-round">
                        <div class="card-body p-3">
                            <span class="stamp stamp-md bg-danger">
                                <i class="fas fa-tag"></i>
                            </span>
                            <div class="h2 mt-3 mb-2 fw-bold" id="member-expired">0</div>
                            <h4 class="mb-1">Member Expired</h4>
                            <h6 class="text-primary m-0"><span id="persen-member-expired">0</span>% dari kemarin</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <a class="pointer mr-1" id="cc">
                            <i class="far fa-calendar-alt"></i>
                        </a>
                        <b>Statistik Pendaftaran</b>
                    </div>
                    <div id="grafik-statistik-pendaftaran" style="width:100%; height:273px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>