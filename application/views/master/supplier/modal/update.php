<form id="form-update-supplier" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
        
            <div class="header">
                <h3> Update Supplier </h3> 
            </div>
            <br>
            <div class="body">
               
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td>Nama Supplier</td>
                            <td>Alamat Supplier</td>
                            <td>No Telp</td>
                            <td>#</td>
                        </tr>
                    </thead>

                    <tbody class = "formmany">
                        <tr>
                            <td><input type="text" name="nama_supplier" class="form-control" placeholder="Enter Units Name" value="<?php echo $datasupplier->Nama;?>" required></td>
                            <td><input type="text" name="alamat_supplier" class="form-control" placeholder="Enter Units Name" value="<?php echo $datasupplier->Alamat;?>" required></td>
                            <td><input type="text" name="no_telp" class="form-control" placeholder="Enter Units Name" value="<?php echo $datasupplier->NoTelp;?>" required></td>
                            <td><button type="button" class="btn btn-primary btn-xs btnaddform">
                                <i class="material-icons">add</i>
                            </button></td>
                        </tr>
                    </tbody>
                </table>

                <input type="hidden" id="id" name="Id" value = "<?=$datasupplier->Id;?>">
            </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-blue waves-effect">SAVE</button>
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>