<form id="form-tambah-barangmasuk" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class = "row-clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
            <div class="header">
                <h3> Tambah Barang Masuk </h3> 
            </div>
            <br>
            <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pt">Tipe Pemasukan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="tipe" id="tipe" required>
                                    <option value="">Pilih Pemasukan</option>
                                    <option value="RUTIN">Barang Rutin</option>
                                    <option value="INVENTARIS">Inventaris</option>
                                    <!-- <option value="RETUR">Barang Retur</option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix" style="display: none;" id="prno">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_bagian">No PR</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="no_pr" name="no_pr" class="form-control" placeholder="Enter PurchaseRequest No" required disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pemohon">No Surat Jalan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="no_sj" name="no_sj" class="form-control" placeholder="Masukkan No Surat Jalan" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="password_2">Tanggal Surat Jalan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <input type="date" id="tgl_sj" name="tgl_sj" placeholder="Please choose a date..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pt">Supplier</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="supplier" id="supplier" required>
                                    <option value="">Pilih Supplier</option>
                                    <?php foreach($supplier as $l) { ?>
                                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>"><?php echo $l->Nama; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix" style="display: none;" id="suratpermintaan">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_supplier">Surat Permintaan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="sp" id="sp" required disabled>
                                    <option value="">Pilih Surat Permintaan</option>
                                    <?php foreach($permintaan as $l) { ?>
                                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>,<?php echo $l->IdPT; ?>,<?php echo $l->IdBagian; ?>,<?php echo $l->IdDivisi; ?>,<?php echo $l->Keterangan; ?>"><?php echo $l->Nama; ?> - <?php echo $l->Keterangan; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="jumlah_barang" id="jumlah_barang" class="hidden">
                    <table class="table table-sm table-bordered" style="display: none;" id="tablesp">
                        <thead>
                            <tr>
                                <td></td>
                                <td>Nama Barang</td>
                                <td>Qty</td>
                                <td>Satuan</td>
                            </tr>
                        </thead>

                        <tbody class = "formmanysp">
                        </tbody>
                    </table>

                    <table class="table table-sm table-bordered" style="display: none;" id="tableconsumable">
                    <thead>
                        <tr>
                            <td>Nama Barang</td>
                            <td>Qty</td>
                            <td>Satuan</td>
                            <td><button type="button" class="btn btn-primary btn-xs btnaddform">
                             <i class="material-icons">add</i>
                         </button></td>
                        </tr>
                    </thead>

                    <tbody class = "formmany">
                        
                    </tbody>
                    </table>
            </div>
            
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-blue waves-effect">SAVE</button>
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>