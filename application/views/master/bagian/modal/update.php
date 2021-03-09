<form id="form-update-bagian" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
        
            <div class="header">
                <h3> Update Bagian </h3> 
            </div>
            <br>
            <div class="body">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                    <label for="nama_pt">PT</label>
                </div>
                <div class="col-lg-10 col-md-5 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <select class="form-control" name="pt" id="pt" disabled>
                            <option value="">Pilih PT</option>
                            <?php foreach($pt as $l) { ?>
                                <option value="<?php echo $l->Nama; ?>,<?php echo $l->Id; ?>"<?php if($l->Id == $databagian->IdPT){echo "selected='selected'";} ?>><?php echo $l->Nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                    <label for="nama_divisi">Divisi</label>
                </div>
                <div class="col-lg-10 col-md-5 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <select class="form-control" name="divisi" id="divisi" disabled>
                            <option value="">Pilih PT</option>
                            <?php foreach($divisi as $l) { ?>
                                <option value="<?php echo $l->Nama; ?>,<?php echo $l->Id; ?>"<?php if($l->Id == $databagian->IdDivisi){echo "selected='selected'";} ?>><?php echo $l->Nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
               <br>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td>Nama Bagian</td>
                            <td>#</td>
                        </tr>
                    </thead>

                    <tbody class = "formmany">
                        <tr>
                            <td><input type="text" name="nama_bagian" class="form-control" value="<?php echo $databagian->Nama; ?>" placeholder="Enter Units Name" required></td>
                            <!-- <td><button type="button" class="btn btn-primary btn-xs btnaddform">
                                <i class="material-icons">add</i>
                            </button></td> -->
                        </tr>
                    </tbody>
                </table>

                <input type="hidden" id="id" name="Id" value = "<?=$databagian->Id;?>">
            </div>
        
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-blue waves-effect">SAVE</button>
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>