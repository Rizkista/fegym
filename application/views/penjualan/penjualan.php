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
                            <input type="text" class="form-control" name="list-search" id="list-search" placeholder="Barcode / Produk">
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <table id="datatable-list-produk" class="table-responsive display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width:20%;">Barcode</th>
                                    <th style="width:75%;">Produk</th>
                                    <th style="width:10%;">Stok</th>
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
                    <form id="form-penjualan" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="card-header p-2">
                            <div class="box-bg-grey">
                                <input type="hidden" id="nama_lokasi" value="<?= $nama_lokasi ? $nama_lokasi['nama_lokasi'] : '' ?>">
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
                            <table id="produk-item" class="table-responsive display table table-striped table-hover table-mini">
                                <thead>
                                    <tr class="bg-blue-smooth3">
                                        <th style="width:5%; color:white;">No</th>
                                        <th style="width:40%; color:white;">Produk</th>
                                        <th style="width:15%; color:white; text-align:center;">Qty</th>
                                        <th style="width:15%; color:white; text-align:center; white-space:nowrap;">Diskon %</th>
                                        <th style="width:20%; color:white; text-align:right;">Price</th>
                                        <th style="width:10%; color:white; text-align:center; min-width:40px;">*</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-header py-2 px-5" style="background:#f4f4f4">
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
                <div class="card">
                    NOTA TRANSAKSI
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
                <table id="datatable-stok-masuk" class="table-responsive display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:15%;">Tanggal</th>
                            <th style="width:10%;">No.Faktur</th>
                            <th style="width:25%;">Produk</th>
                            <th style="width:5%;">Jumlah</th>
                            <th style="width:15%;">Supplier</th>
                            <th style="width:15%;">Lokasi</th>
                            <th style="width:15%;" id="text-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>