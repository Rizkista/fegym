<div class="page-inner">
    <div class="card">
        <div class="card-body p-2">
            <input type="hidden" id="tab-menu" value="1">
            <ul class="nav-tabx m-0">
                <li class="w-2 active" id="li-1">
                    <a id="tab-1" href="#">Transaksi</a>
                </li>
                <li class="w-2" id="li-2" >
                    <a id="tab-2" href="#">Histori</a>
                </li>
            </ul>
        </div>
    </div>

    <div id="transaksi">
        <div id="proses-1" class="row">
            <div class="col-md-6">
                <div class="card <?= ($this->session->userdata('id_posisi') == 3 ? 'gone' : '') ?>">
                    <div class="card-header p-2">
                        <div>
                            <div class="btn-group border-option m-0">
                                <label class="label-filter">Lokasi: </label>&nbsp;&nbsp;
                                <select class="form-control" name="pilih-lokasi" id="pilih-lokasi">
                                    <option value="0">Pilih Lokasi</option>
                                    <?php foreach ($data_lokasi as $list){ ?>
                                        <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2">
                        <div class="btn-group p-1 bg-grey3 btn-full">
                            <input type="text" class="form-control" name="list-search" id="list-search" placeholder="Cari">
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <table id="datatable-list-paket" class="table-responsive display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width:60%;">Paket</th>
                                    <th style="width:15%;">Harga</th>
                                    <th style="width:15%;">Durasi</th>
                                    <th style="width:15%;">Member</th>
                                </tr>
                            </thead>
                            <tbody class="cursor-cell">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <form id="form-pembayaran" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="card-header p-2">
                            <div class="box-bg-grey">
                                <input type="hidden" id="nama_lokasi" value="<?= $lokasi ? $lokasi['nama_lokasi'] : '' ?>">
                                <table class="mb-0 full-width">
                                    <tbody class="nowraping">
                                        <tr>
                                            <th width="10%"><i class="fas fa-map-marker-alt mr-2"></i><span id="info-lokasi"></span></th>
                                            <th width="2%" class="text-right"><?= date("d-m-Y") ?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-header p-2" style="min-height:150px">
                            //Detail Paket Gym
                        </div>
                        <div class="card-header py-2 px-5" style="background:#f4fff7">
                            <div class="row px-3">
                                <div class="col-md-6 form-group pb-0">
                                    <label class="col-form-label p-0">Diskon :</label>
                                    <table class="full-width mb-2">
                                        <tbody>
                                            <tr>
                                                <td><input type="text" id="dis1" class="form-rm form-nota btn-choice choice" value="Percent" readonly></td>
                                                <td><input type="text" id="dis2" class="form-rm form-nota btn-choice" value="Nominal" readonly></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="jenis_diskon" name="jenis_diskon" value="1">
                                    <div class="box-numb">
                                        <table class="full-width" class="pt-1">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="percent_diskon" name="percent_diskon" class="form-control form-rm form-nota text-right" placeholder="0 %">
                                                        <input type="text" id="nominal_diskon" name="nominal_diskon" data-type="currency" class="form-control form-rm form-nota text-right none" placeholder="0">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group pb-0">
                                    <label class="col-form-label p-0">PPN :</label>
                                    <table class="full-width mb-2">
                                        <tbody>
                                            <tr>
                                                <td><input type="text" id="ppn1" class="form-rm form-nota btn-choice choice" value="Percent" readonly></td>
                                                <td><input type="text" id="ppn2" class="form-rm form-nota btn-choice" value="Nominal" readonly></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="jenis_ppn" name="jenis_ppn" value="1">
                                    <div class="box-numb">
                                        <table class="full-width" class="pt-1">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" id="percent_ppn" name="percent_ppn" class="form-control form-rm form-nota text-right" placeholder="0 %">
                                                        <input type="text" id="nominal_ppn" name="nominal_ppn" data-type="currency" class="form-control form-rm form-nota text-right none" placeholder="0">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pb-0">
                                <label class="col-form-label p-0">Jenis Pembayaran :</label>
                                <table class="full-width mb-2">
                                    <tbody>
                                        <tr>
                                            <td><input type="text" id="jenbayar1" class="form-rm form-nota btn-choice choice" value="Tunai" readonly></td>
                                            <td><input type="text" id="jenbayar2" class="form-rm form-nota btn-choice" value="E-Walet" readonly></td>
                                            <td><input type="text" id="jenbayar3" class="form-rm form-nota btn-choice" value="Card" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="jenis_pembayaran" name="jenis_pembayaran" value="1">
                                <input type="hidden" id="tipe_bayar" name="tipe_bayar" value="Tunai">
                                <div class="box-numb non-tunai none">
                                    <table class="full-width" class="pt-1">
                                        <tbody>
                                            <tr>
                                                <td width="50%">
                                                    <select class="form-control form-rm form-nota none" id="payment_bank" name="payment_bank">
                                                        <?php foreach ($data_payment as $list){ if($list->jenis === "bank") {?>
                                                            <option value="<?= $list->id_tipe_bayar ?>"><?= $list->tipe_bayar ?></option>
                                                        <?php } } ?>
                                                    </select>
                                                    <select class="form-control form-rm form-nota none" id="payment_walet" name="payment_walet">
                                                        <?php foreach ($data_payment as $list){ if($list->jenis === "walet") {?>
                                                            <option value="<?= $list->id_tipe_bayar ?>"><?= $list->tipe_bayar ?></option>
                                                        <?php } } ?> 
                                                    </select>
                                                </td>
                                                <td width="50%">
                                                    <input type="text" id="charge" name="charge" class="form-control form-rm form-nota text-right" placeholder="Charge  0 %">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group pb-0">
                                <label class="col-form-label p-0">Nominal Dibayar :</label>
                                <table class="full-width">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="box-numb text-right">
                                                    <input type="text" id="nominal_dibayar" name="nominal_dibayar" data-type="currency" class="form-control form-rm form-nota text-right" placeholder="0" required>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body py-2 px-5">
                            <div class="form-group pb-0">
                                <label class="col-form-label p-0">Ringkasan Pembayaran :</label>
                                <table class="tabsum table-responsive mb-0 px-4 nowraping">
                                    <tbody>
                                        <tr>
                                            <td><b>Total Harga</b></td>
                                            <td class="text-right" id="total_harga">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Diskon <sup id="prc-dis">(0%)</sup></b></td>
                                            <td class="text-right" id="total_diskon">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td><b>Total PPN <sup id="prc-ppn">(0%)</sup></b></td>
                                            <td class="text-right" id="total_ppn">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Charge <sup id="prc-chr">(0%)</sup></b></td>
                                            <td class="text-right" id="total_charge">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="text-right text-11-gray">----------------------------</td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Transaksi</b></td>
                                            <td class="text-danger text-right fw-bold" id="total_transaksi">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td><b>Dibayar</b></td>
                                            <td class="text-right fw-bold" id="jumlah_dibayar">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td><b>Kembalian</b></td>
                                            <td class="text-right fw-bold" id="jumlah_kembalian">Rp 0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right p-2">
                            <button class="btn btn-danger btn-sm fw-bold" type="button" id="reset_item">Reset</button>
                            <button class="btn btn-success btn-sm fw-bold" type="submit" id="simpan_item">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="proses-2" class="row none">
            <div class="col-md-5 ml-auto mr-auto">
                <div class="card" style="font-size:13px;">
                    <div class="card-header" style="background:#25B1E6;">
                        <div style="font-size:16px; display:block; padding:10px; background:#31C7FF; text-align:center; margin-top:15px; margin-bottom:10px; color:white; border-radius:5px;">
                            <b>Transaksi Berhasil</b>
                        </div>
                        <table style="width:100%; color:white;">
                            <tbody>
                                <tr>
                                    <td>Tipe Pembayaran</td>
                                    <td id="nt-tipe" style="text-align:right;">Tunai</td>
                                </tr>
                                <tr>
                                    <td>Total Transaksi</td>
                                    <td id="nt-total" style="text-align:right; font-weight:bolder;">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Uang Dibayar</td>
                                    <td id="nt-dibayar" style="text-align:right;">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Uang Kembalian</td>
                                    <td id="nt-kembalian" style="text-align:right;">Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header">
                        <label class="control-label mb-1" style="color: #686868;">Detail Pembayaran</label>
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>No.Nota</td>
                                    <td id="nt-nota" style="text-align:right;">A000-1</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td id="nt-tanggal" style="text-align:right;">0000-00-00 00:00:00</td>
                                </tr>
                                <tr>
                                    <td>Operator</td>
                                    <td id="nt-operator" style="text-align:right;">Demo</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header">
                        <label class="control-label mb-1" style="color: #686868;">Detail Item</label>
                        <table id="detail-item" class="table-mini" style="width:100%; padding:4px; background:#f4f4f4; font-size:12px;">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header">
                        <label class="control-label mb-1" style="color: #686868;">Detail Transaksi</label>
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>Total Harga</td>
                                    <td id="nt-harga" style="text-align:right;">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Diskon <span id="nt-dis">(0%)</span></td>
                                    <td id="nt-diskon-nom" style="text-align:right;">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>PPN <span id="nt-ppn">(0%)</span></td>
                                    <td id="nt-ppn-nom" style="text-align:right;">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Charge <span id="nt-chr">(0%)</span></td>
                                    <td id="nt-charge-nom" style="text-align:right;">Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header">
                        <table style="width:100%; font-weight:bolder;">
                            <tbody>
                                <tr>
                                    <td>Total Transaksi</td>
                                    <td id="nt-amount" style="text-align:right;">Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="width:50%;"><button class="btn btn-secondary fw-bold full-width" type="button" id="new_trans">Transaksi Baru</button></td>
                                    <td style="width:50%;"><button class="btn btn-default fw-bold full-width" type="button" id="print_trans">Print Nota</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="histori" class="none">
        <div class="card">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-sm">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Tanggal: </label>&nbsp;&nbsp;
                            <div style="width:100%" id="reportrange">
                                <input type="text" class="form-control input-full pointer" id="daterange" name="daterange" style="background: white !important;" readonly>
                                <input type="hidden" name="start-date">
                                <input type="hidden" name="end-date">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm <?= ($this->session->userdata('id_posisi') == 3 ? 'gone' : '') ?>">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Lokasi: </label>&nbsp;&nbsp;
                            <select class="form-control" name="filter-lokasi" id="filter-lokasi">
                                <option value="">Semua Lokasi</option>
                                <?php foreach ($data_lokasi as $list){ ?>
                                    <option value="<?= $list->id_lokasi ?>"><?= $list->nama_lokasi ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Status: </label>&nbsp;&nbsp;
                            <select class="form-control" name="filter-status" id="filter-status">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Terhapus</option>
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
            <div class="card-body p-2">
                <table id="datatable-pembayaran" class="table-responsive display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:10%;">Tanggal</th>
                            <th style="width:10%;">Nota</th>
                            <th style="width:15%;" class="nowraping">Nama Item</th>
                            <th style="width:10%;" class="nowraping">Jml Item</th>
                            <th style="width:10%;" class="nowraping">Diskon Item</th>
                            <th style="width:10%;" class="nowraping">Harga Item</th>
                            <th style="width:10%;">Diskon</th>
                            <th style="width:10%;">PPN</th>
                            <th style="width:10%;">Charge</th>
                            <th style="width:10%;" class="nowraping">Total Transaksi</th>
                            <th style="width:10%;" id="text-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-alasan-hapus" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-body text-center">
                    <h5 class="modal-title py-3" style="color:rgba(0,0,0,.65);font-weight:600;font-size:27px;line-height:normal;">Hapus Transaksi</h5>
                    <div class="" style="width:100% !important; padding:15px; border-radius:4px; font-size:13px; background-color:#f7d9d9;">
                        <span>Apakah anda yakin ingin menghapus data pembayaran dengan nota</span><br>
                        <b><span id="no-nota">...</span></b>
                        <textarea id="alasan-hapus" style="min-height:100px;" class="form-control mt-2" placeholder="Alasan di Hapus . . ." required></textarea>
                    </div>
                    <div class="py-3">
                        <input type="hidden" name="id_pembayaran">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="hapus">Lanjutkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>