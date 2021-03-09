<section class="content">
<div class="row clearfix ">
        <div class="msg" style="display:none;">
            <?php echo @$this->session->flashdata('msg'); ?>
        </div>
        <div class="col-lg-12 col-md-11 col-sm-11 col-xs-12">
            <div class = "card col-lg-12 col-md-11 col-sm-11 col-xs-12 align-self-center">
                <div class = "header">
                    <h1><?php echo($Judul)?></h1>
                </div>

                <div class = "header">
                    <button type="button" class="btn bg-blue waves-effect " data-toggle="modal" data-target="#tambah-barangmasuk"><i class="material-icons">add_box</i> <span>Tambah</span></button>
                    <!-- <a href="<?php echo base_url();?>transaksi/permintaan/Excel" class = "btn bg-blue waves-effect" ><i class="material-icons">file_download</i><span>Excel</span></a> -->
                    <!-- <a href="<?php echo base_url();?>master/pt/PDF" class = "btn bg-blue waves-effect" ><i class="material-icons">file_download</i><span>PDF</span></a> -->
                    <!-- <button type="button" class="btn bg-blue waves-effect " data-toggle="modal" data-target="#UploadModal"><i class="material-icons">file_upload</i> <span>Upload CSV</span></button> -->
                </div>
                <div class = "body">
                    <div class="table-responsive">
                        <table id="list-data" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat Jalan</th>
                                    <th>Tanggal Surat Jalan</th>
                                    <th>Supplier</th>
                                    <th>Surat Permintaan</th>
                                    <th>Nama Barang</th>
                                    <th>Quantity</th>
                                    <th>Satuan</th>
                                    <th>Penerima</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody id="data-masuk">
                                 
                             </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php echo $modal_tambah_barang_masuk; ?>

    <div id="tempat-modal"></div>

    <?php show_my_confirm('konfirmasiHapus', 'hapus-datamasuk', 'Hapus Data Ini?', 'Ya, Hapus Data Ini'); ?>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script> 
    <script text="javascript">
       window.onload = function() {
            tampilMasuk();
            <?php
                if ($this->session->flashdata('msg') != '') {
                    echo "effect_msg();";
                }
            ?>
        }
        var MyTable = $('#list-data').dataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
        });
        function refresh() {
            MyTable = $('#list-data').dataTable();
        }
        function tampilMasuk() {
            $.get('<?php echo base_url('transaksi/barang_masuk/tampil'); ?>', function(data) {
                MyTable.fnDestroy();
                // console.log(data);
                $('#data-masuk').html(data);
                refresh();
            });
        }

    $(document).on('click','.btndeleteform', function(e){
        e.preventDefault();

        $(this).parents('tr').remove();
    })
    $('.btnaddform').click(function(e){
        e.preventDefault();
        var jumlah = parseInt($("#jumlah-form").val())

            var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya
            
            $('.formmany').append(`
            <tr id="inputmany">
            <td><select class="selectpicker form-control" data-live-search="true" name="nama_barang[]" id="nama_barang" required>
                    <option value=""></option>
                    <?php foreach($barang as $l) { ?>
                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>,<?php echo $l->NoBarang; ?>,<?php echo $l->Kategori; ?>" data-info="<?php echo $l->Kategori; ?>"><?php echo $l->Nama; ?> - <?php echo $l->Kategori; ?></option>
                    <?php } ?>
                </select></td>
                <td><input type="text" name="qty[]" class="form-control" placeholder="Enter Quantity" required></td>
                <td><select class="selectpicker form-control" data-live-search="true" name="uom[]" required>
                    <option value=""></option>
                    <?php foreach($uom as $l) { ?>
                        <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>"><?php echo $l->Nama; ?></option>
                    <?php } ?>
                </select></td>
                <td><button type="button" class="btn btn-danger btn-xs btndeleteform">
                    <i class="material-icons">close</i>
                </button></td>
            </tr>
            `);

            $("#jumlah-form").val(nextform)
            $('.selectpicker').selectpicker('refresh');
    })
    $('#form-tambah-barangmasuk').submit(function(e) {
        var jumlah = $('#jumlah_barang').val();
        console.log(jumlah)
        for (var i = 0; i < jumlah; i++) {
            $('#nama_barang'+i).prop('disabled',false);
            $('#uom'+i).prop('disabled',false);
        }
        
        var data = $(this).serialize();

        $.ajax({
            method: 'POST',
            url: '<?php echo base_url('transaksi/barang_masuk/add'); ?>',
            data: data
        })
        .done(function(data) {
            var out = jQuery.parseJSON(data);
            
            if (out.status == 'form') {
                document.getElementById("form-tambah-barangmasuk").reset();
                $('#pt').prop('selectedIndex', -1);
                $('#nama_barang').prop('selectedIndex', -1);
                $('#qty').prop('selectedIndex', -1);
                if(document.getElementById('inputmany') != null){
                    document.getElementById('inputmany').remove();
                }
                $('.selectpicker').selectpicker('refresh');
                tampilMasuk();
                $('.form-msg').html(out.msg);
                effect_msg_form();
            } else {
                document.getElementById("form-tambah-barangmasuk").reset();
                $('#pt').prop('selectedIndex', -1);
                $('#nama_barang').prop('selectedIndex', -1);
                $('#qty').prop('selectedIndex', -1);
                if(document.getElementById('inputmany') != null){
                    document.getElementById('inputmany').remove();
                }
                tampilMasuk();
                $('.msg').html(out.msg);
                $('.selectpicker').selectpicker('refresh');
                effect_msg();
            }
        })
        
        e.preventDefault();
    });

    function effect_msg_form() {
        // $('.form-msg').hide();
        $('.form-msg').show(1000);
        setTimeout(function() { $('.form-msg').fadeOut(1000); }, 3000);
    }

    function effect_msg() {
        // $('.msg').hide();
        $('.msg').show(1000);
        setTimeout(function() { $('.msg').fadeOut(1000); }, 3000);
    }

    $(document).on("click", ".konfirmasiHapus-daftarmasuk", function() {
        id_pegawai = $(this).attr("data-id");
    })
    $(document).on("click", ".hapus-datamasuk", function() {
        var id = id_pegawai;
        
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('transaksi/barang_masuk/delete'); ?>",
            data: "id=" +id
        })
        .done(function(data) {
            $('#konfirmasiHapus').modal('hide');
            tampilMasuk();
            $('.msg').html(data);
            effect_msg();
        })
    })
    $(document).ready(function(){
        $('#sp').change(function(){ 
            var id=$(this).val();
            $.ajax ({
                url : "<?php echo site_url('transaksi/barang_masuk/get_detail_permintaan');?>",
                method : "POST",
                data : {id: id},
                async : true,
                dataType : 'json',
                success: function(data){
                    $("#jumlah_barang").val(data.total);
                    $('.formmanysp').html(data.data);
                    $('.selectpicker').selectpicker('refresh');

                }
            });
        });

        $('#tipe').change(function() {
            var id = $(this).val();
            if(id == 'RUTIN'){
                // $('.formmany').append(`
                //     <tr>
                //         <td><select class="selectpicker form-control" data-live-search="true" name="nama_barang[]" id="nama_barang" required>
                //             <option value=""></option>
                //             <?php foreach($barang as $l) { ?>
                //                 <option value="<?php echo $l->Id; ?>,<?php echo $l->Nama; ?>,<?php echo $l->NoBarang; ?>,<?php echo $l->Kategori; ?>"><?php echo $l->Nama; ?> - <?php echo $l->Kategori; ?></option>
                //             <?php } ?>
                //         </select></td>
                //         <td><input type="text" name="qty[]" class="form-control" placeholder="Enter Quantity" required></td>
                //         <td><select class="selectpicker form-control" data-live-search="true" name="uom[]" required>
                //             <option value=""></option>
                //             <?php foreach($uom as $l) { ?>
                //                 <option value="<?php echo $l->Nama; ?>"><?php echo $l->Nama; ?></option>
                //             <?php } ?>
                //         </select></td>
                //         <td><button type="button" class="btn btn-primary btn-xs btnaddform">
                //             <i class="material-icons">add</i>
                //         </button></td>
                //     </tr> 
                // `)
                $('.selectpicker').selectpicker('refresh');
                $('#tableconsumable').show();
                $('#tablesp').hide();
                $('#suratpermintaan').hide();
                $('#prno').show();
                $('#no_pr').prop('disabled', false);
                $('#sp').prop('disabled', true);
                $('.selectpicker').selectpicker('refresh');
            }else if (id == 'INVENTARIS' ){
                $('.formmany').empty();
                $('#tableconsumable').hide();
                $('#no_pr').prop('disabled', true);
                $('#sp').prop('disabled', false);
                $('#prno').hide();
                $('#suratpermintaan').show();
                $('#tablesp').show();
                $('.selectpicker').selectpicker('refresh');
            }
        })

        // $('#tipeupdate').change(function() {
        //     var id = $(this).val();
        //     console.log(id);
        //     if(id == 'RUTIN'){
        //         $('#suratpermintaanupdate').hide();
        //         $('#prnoupdate').show();
        //         $('#no_prupdate').prop('disabled', false);
        //         $('#spupdate').prop('disabled', true);

        //     }else if (id == 'INVENTARIS' ){
        //         // $('.formmanyupdate').empty();
        //         $('#no_pr').prop('disabled', true);
        //         $('#spupdate').prop('disabled', false);
        //         $('#prnoupdate').hide();
        //         $('#suratpermintaanupdate').show();
        //         $('.selectpicker').selectpicker('refresh');
        //     }
        // });

        $('#spupdate').change(function(){ 
            var id=$(this).val();
            var barang=$('#barang').val();
            var qty = $('#qty').val();
            $.ajax ({
                url : "<?php echo site_url('transaksi/barang_masuk/get_detail_update');?>",
                method : "POST",
                data : {id: id, barang: barang, Qty:qty },
                async : true,
                dataType : 'json',
                success: function(data){
                    $("#jumlah_barang").val(data.total);
                    $('.formmanyupdate').empty();
                    $('.formmanyupdate').html(data.data);
                    $('.selectpicker').selectpicker('refresh');

                }
            });
        });

        
        
    });

    $(document).on('change', '#tipeupdate', function() {
        var id = $(this).val();
            console.log(id);
            if(id == 'RUTIN'){
                $('#suratpermintaanupdate').hide();
                $('#prnoupdate').show();
                $('#no_prupdate').prop('disabled', false);
                $('#spupdate').prop('disabled', true);
            }else if (id == 'INVENTARIS' ){
                // $('.formmanyupdate').empty();
                $('#no_pr').prop('disabled', true);
                $('#spupdate').prop('disabled', false);
                $('#prnoupdate').hide();
                $('#suratpermintaanupdate').show();
                $('.selectpicker').selectpicker('refresh');
            }
    });

    $(document).on('submit', '#form-update-barang-masuk', function(e){
        var data = $(this).serialize();

        $.ajax({
            method: 'POST',
            url: '<?php echo base_url('transaksi/barang_masuk/edit'); ?>',
            data: data
        })
        .done(function(data) {
            var out = jQuery.parseJSON(data);

            tampilMasuk()
            if (out.status == 'form') {
                $('.form-msg').html(out.msg);
                effect_msg_form();
            } else {
                document.getElementById("form-update-barang-masuk").reset();
                // $('#update-bagian').modal('hide');
                $('.msg').html(out.msg);
                effect_msg();
            }
        })
        
        e.preventDefault();
    });

    $(document).on("click", ".update-dataBarangMasuk", function() {
        var id = $(this).attr("data-id");
        
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('transaksi/barang_masuk/update'); ?>",
            data: "id=" +id
        })
        .done(function(data) {
            $('#tempat-modal').html(data);
            $('#update-barang-masuk').modal('show');
            $('.selectpicker').selectpicker('refresh');
        })
    })
    </script>

</section>