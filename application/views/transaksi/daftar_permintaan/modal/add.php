<form id="form-tambah-permintaan" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class = "row-clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
            <div class="header">
                <h3> Tambah Permintaan </h3> 
            </div>
            <br>
            <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pemohon">Nama Pemohon</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" placeholder="Masukkan Nama Pemohon" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="password_2">Tanggal Surat Permintaan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <input type="date" id="tgl_permintaan" name="tgl_permintaan" placeholder="Please choose a date..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pt">PT</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="pt" id="pt">
                                    <option value="">Pilih PT</option>
                                    <?php foreach($pt as $l) { ?>
                                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>"><?php echo $l->Nama; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_divisi">Divisi</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="divisi" id="divisi">
                                    <option value="">Pilih Divisi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_supplier">Bagian</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="bagian" id="bagian">
                                    <option value="">Pilih Bagian</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_bagian">Keterangan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="4" class="form-control no-resize" placeholder="Masukkan Keterangan" id="keterangan" name="keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <td>Nama Barang</td>
                                <td>Qty</td>
                                <td>Satuan</td>
                                <td><button type="button" class="btn btn-primary btn-xs btnaddform">
                                    <i class="material-icons">add</i></td>
                            </tr>
                        </thead>

                        <tbody class = "formmany">
                            <tr>
                                <!-- <td><select class="selectpicker form-control" data-live-search="true" name="nama_barang[]" id="nama_barang">
                                    <option value=""></option>
                                    <?php foreach($barang as $l) { ?>
                                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>,<?php echo $l->NoBarang; ?>,<?php echo $l->Kategori; ?>"><?php echo $l->Nama; ?> - <?php echo $l->Kategori; ?></option>
                                    <?php } ?>
                                </select></td>
                                <td><input type="text" name="qty[]" class="form-control" placeholder="Enter Quantity" id="qty" required></td>
                                <td><select class="selectpicker form-control" data-live-search="true" name="uom[]" required>
                                    <option value=""></option>
                                    <?php foreach($uom as $l) { ?>
                                        <option value="<?php echo $l->Nama; ?>"><?php echo $l->Nama; ?></option>
                                    <?php } ?>
                                </select></td>
                                <td><button type="button" class="btn btn-primary btn-xs btnaddform">
                                    <i class="material-icons">add</i>
                                </button></td> -->
                            </tr>
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