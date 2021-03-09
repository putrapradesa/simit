<form id="form-tambah-barang" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
        
            <div class="header">
                <h3> Tambah Barang </h3> 
            </div>
            <br>
            <div class="body">
                <!-- <div class="col-lg-1 col-md-2 col-sm-4 col-xs-5 form-control-label">
                    <label for="nama_divisi">PT</label>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <select class="form-control show-tick" name="pt">
                            <option value="">Pilih PT</option>
                            <?php foreach($pt as $l) { ?>
                                <option value="<?php echo $l->Nama; ?>,<?php echo $l->Id; ?>"><?php echo $l->Nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div> -->
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td>Kategori</td>
                            <td>Nama Barang</td>
                            <td>Satuan</td>
                            <td>#</td>
                        </tr>
                    </thead>

                    <tbody class = "formmany">
                        <tr>
                            <td>
                                <select class="selectpicker form-control" name="kategori[]" id="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                        <?php foreach($kategori as $l) { ?>
                                            <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>"><?php echo $l->Nama; ?></option>
                                        <?php } ?>
                                </select>
                            </td>
                            <td><input type="text" name="nama_barang[]" class="form-control" placeholder="Enter Barang Name" required></td>
                            <!-- <td><input type="text" name="id_pt[]" class="form-control" placeholder="Enter ID Name" required></td> -->
                            <!-- <td><input type="text" name="id_it[]" class="form-control" placeholder="Enter ID Name" required></td> -->
                            <td>
                                <select class="selectpicker form-control" name="uom[]" id="uom" required>
                                    <option value="">Pilih Satuan</option>
                                        <?php foreach($uom as $l) { ?>
                                            <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>"><?php echo $l->Nama; ?></option>
                                        <?php } ?>
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-primary btn-xs btnaddform">
                                <i class="material-icons">add</i>
                            </button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-blue waves-effect">SAVE</button>
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>