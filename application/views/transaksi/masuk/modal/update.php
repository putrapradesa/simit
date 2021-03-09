<form id="form-update-barang-masuk" method="POST">
    <div class="form-msg" style="display:none;">
        <?php echo @$this->session->flashdata('msg'); ?>
    </div>
    <div class = "row-clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
            <div class="header">
                <h3> Update Barang Masuk </h3> 
            </div>
            <br>
            <div class="body">
                    <div class="row clearfix" style="display: none;" id="prnoupdate">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_bagian">No PR</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="no_pr" name="no_prupdate" class="form-control" value="<?php echo $datamasuk->NoPR; ?>" placeholder="Enter PurchaseRequest No" required disabled>
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
                                    <input type="text" id="no_sj" name="no_sjupdate" value="<?php echo $datamasuk->NoSJ; ?>" class="form-control" placeholder="Masukkan No Surat Jalan" required>
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
                                <input type="date" id="tgl_sj" name="tgl_sjupdate" value="<?php echo $datamasuk->TglSJ; ?>" placeholder="Please choose a date..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pt">Supplier</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="supplierupdate" id="supplier" required>
                                    <option value="">Pilih Supplier</option>
                                    <?php foreach($supplier as $l) { ?>
                                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>"<?php if($l->Id == $datamasuk->IdSupplier){echo "selected='selected'";} ?>><?php echo $l->Nama; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix" >
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_pt">Tipe Pemasukan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="tipeupdate" id="tipeupdate" required>
                                    <option value="">Pilih Pemasukan</option>
                                    <option value="RUTIN" <?php if($datamasuk->TipeTransaksi == "RUTIN" ){echo "selected='selected'";} ?>>Barang Rutin</option>
                                    <option value="INVENTARIS" <?php if($datamasuk->TipeTransaksi == "INVENTARIS"){echo "selected='selected'";} ?>>Inventaris</option>
                                    <option value="RETUR" <?php if($datamasuk->TipeTransaksi == "RETUR"){echo "selected='selected'";} ?>>Barang Retur</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix" style="display: none;" id="suratpermintaanupdate">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="nama_supplier">Surat Permintaan</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <select class="selectpicker form-control" name="spupdate" id="spupdate" required disabled>
                                    <option value="">Pilih Surat Permintaan</option>
                                    <?php foreach($permintaan as $l) { ?>
                                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>,<?php echo $l->IdPT; ?>,<?php echo $l->IdBagian; ?>,<?php echo $l->IdDivisi; ?>,<?php echo $l->Keterangan; ?>"<?php if($l->Id == $datamasuk->IdSP){echo "selected='selected'";} ?>><?php echo $l->Nama; ?> - <?php echo $l->Keterangan; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="jumlah_barang" id="jumlah_barang" class="hidden">
                    <table class="table table-sm table-bordered" id="tablespupdate">
                        <thead>
                            <tr>
                                <td class="hidden"></td>
                                <td>Nama Barang</td>
                                <td>Qty</td>
                                <td>Satuan</td>
                            </tr>
                        </thead>

                        <tbody class = "formmanyupdate">
                            <tr>
                                <td class="hidden"><input type="checkbox" class="hidden" id="ig_checkbox" name="save" value="isSave'.$index.'" checked>
                                    <label for="ig_checkbox"></label>
                                </td>
                                <td>
                                    <select class="selectpicker form-control" data-live-search="true" name="nama_barang" id="nama_barang" required disabled>
                                        <option value=""></option>
                                        <?php foreach($barang as $l) { ?>
                                            <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>,<?php echo $l->NoBarang; ?>,<?php echo $l->Kategori; ?>"<?php if($l->Id == $datamasuk->IdBarang){echo "selected='selected'";} ?>><?php echo $l->Nama; ?> - <?php echo $l->Kategori; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><input type="text" name="qty" class="form-control" value = "<?php echo $datamasuk->Quantity; ?>" placeholder="Enter Quantity" required></td>
                                <td><select class="selectpicker form-control" data-live-search="true" name="uom" required disabled>
                                    <option value=""></option>
                                    <?php foreach($uom as $l) { ?>
                                        <option value="<?php echo $l->Nama; ?>"<?php if($l->Nama == $datamasuk->Uom){echo "selected='selected'";} ?>><?php echo $l->Nama; ?></option>
                                    <?php } ?>
                                </select>
                                </td>
                                <td class="hidden"><input type="hidden" name="IdSP" class="form-control" placeholder="Enter Quantity" value='' required></td>
                                <td class="hidden"><input type="hidden" name="qtybefore" class="form-control hidden" value="<?php echo $datamasuk->Quantity; ?>"" placeholder="Enter Quantity" required ></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" id="id" name="Id" value = "<?=$datamasuk->Id;?>">
            </div>
            
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn bg-blue waves-effect">SAVE</button>
        <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>