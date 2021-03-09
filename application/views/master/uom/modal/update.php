<form method="POST" id="form-update-uom">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
            <div class="header">
                <h2> Edit Satuan </h2> 
            </div>
            <div class="body">
                <!-- <form class = "form-horizontal"> -->
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pt">Nama Satuan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="nama_uom" class="form-control" value="<?=$datauom->Nama;?>" name = "nama_uom" placeholder="Enter PT Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id" name="Id" value = "<?=$datauom->Id;?>">
                <!-- </form> -->
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="submit" class="btn bg-blue waves-effect">SAVE</button>
            <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
        </div>

    </div>
</form>