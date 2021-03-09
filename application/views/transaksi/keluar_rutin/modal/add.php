<form id="form-tambah-barangkeluar" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class = "row-clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
            <div class="header">
                <h3> Tambah Barang Keluar </h3> 
            </div>
            <br>
            <div class="body">
                    <div class="row clearfix" id="nama">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_bagian">Nama</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pt">Divisi</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="divisi" id="divisi" required>
                                    <option value="">Pilih Divisi</option>
                                    <?php foreach($divisi as $l) { ?>
                                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>,<?php echo $l->IdPT; ?>"><?php echo $l->Nama; ?> - <?php echo $l->PT; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pt">Bagian</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="bagian" id="bagian" required>
                                    <option value="">Pilih Bagian</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="jumlah_barang" id="jumlah_barang" class="hidden">
                    <table class="table table-sm table-bordered ">
                        <thead>
                            <tr>
                                <td style="text-align: center;">Nama Barang</td>
                                <td>Qty</td>
                                <td>Satuan</td>
                                <td><button type="button" class="btn btn-primary btn-xs btnaddform"><i class="material-icons">add</i></button></td>
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