<form id="form-tambah-bagian" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
        
            <div class="header">
                <h3> Tambah Bagian </h3> 
            </div>
            <br>
            <div class="body">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                    <label for="nama_pt">PT</label>
                </div>
                <div class="col-lg-10 col-md-5 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <select class="selectpicker form-control" name="pt" id="pt" required>
                            <option value="">Pilih PT</option>
                            <?php foreach($pt as $l) { ?>
                                <option value="<?php echo $l->Nama; ?>,<?php echo $l->Id; ?>"><?php echo $l->Nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                    <label for="nama_divisi">Divisi</label>
                </div>
                <div class="col-lg-10 col-md-5 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <select class="selectpicker form-control" name="divisi" id="divisi" required>

                            <option value="">Pilih Divisi</option>
                        </select>
                    </div>
                </div>
               
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td>Nama Bagian</td>
                            <td>#</td>
                        </tr>
                    </thead>

                    <tbody class = "formmany">
                        <tr>
                            <td><input type="text" name="nama_bagian[]" class="form-control" placeholder="Enter Units Name" required></td>
                            <td><button type="button" class="btn btn-primary btn-xs btnaddform">
                                <i class="material-icons">add</i>
                            </button></td>
                        </tr>
                    </tbody>
                </table>
                <!-- <form class = "form-horizontal"> -->
                    <!-- <div class="row clearfix"> -->
                        <!-- <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_divisi">Nama Divisi</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="nama_divisi" name="nama_divisi" class="form-control" placeholder="Enter Division Name" required>
                                </div>
                            </div>
                        </div> -->
                    <!-- </div> -->
                    <!-- <div class="row clearfix"> -->
                        
                    <!-- </div> -->
                <!-- </form> -->
            </div>
        
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-blue waves-effect">SAVE</button>
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>