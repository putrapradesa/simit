<form id="form-update-kategori" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
        
            <div class="header">
                <h3> Update Kategori </h3> 
            </div>
            <br>
            <div class="body">
               
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td>Nama Kategori</td>
                        </tr>
                    </thead>

                    <tbody class = "formmany">
                        <tr>
                        <td><input type="text" name="nama_kategori" class="form-control" placeholder="Enter Category Name" required value="<?php echo $datakategori->Nama;?>"></td>
                        </tr>
                    </tbody>
                </table>

                <input type="hidden" id="id" name="Id" value = "<?=$datakategori->Id;?>">
            </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-blue waves-effect">SAVE</button>
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>