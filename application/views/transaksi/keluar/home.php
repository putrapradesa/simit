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
                    <button type="button" class="btn bg-blue waves-effect " data-toggle="modal" data-target="#tambah-barangkeluar"><i class="material-icons">add_box</i> <span>Tambah</span></button>
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
                                    <th>Tanggal Keluar</th>
                                    <th>Divisi</th>
                                    <th>Bagian</th>
                                    <th>Surat Permintaan</th>
                                    <th>No Identitas PT</th>
                                    <th>IP Address</th>
                                    <th>Nama Barang</th>
                                    <th>Quantity</th>
                                    <th>Satuan</th>
                                    <th>Tujuan</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody id="data-keluar">
                                 
                             </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php echo $modal_tambah_barang_keluar; ?>

    <div id="tempat-modal"></div>

    <?php show_my_confirm('konfirmasiHapus', 'hapus-datakeluar', 'Hapus Data Ini?', 'Ya, Hapus Data Ini'); ?>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script> 
    <script text="javascript">
        window.onload = function() {
            tampilKeluar();
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
        function tampilKeluar() {
            $.get('<?php echo base_url('transaksi/barang_keluar/tampil'); ?>', function(data) {
                MyTable.fnDestroy();
                // console.log(data);
                $('#data-keluar').html(data);
                refresh();
            });
        }
        $(document).on('click','.btndeleteform', function(e){
            e.preventDefault();

            $(this).parents('tr').remove();
        })
        $(document).on('change','#divisi', function(e){
            var id=$(this).val();
            $.ajax ({
                url : "<?php echo site_url('transaksi/barang_keluar/get_bagian');?>",
                method : "POST",
                data : {id: id},
                async : true,
                dataType : 'json',
                success: function(data){
                    $('#bagian').html(data);
                    $('.selectpicker').selectpicker('refresh');

                }
            });
        })
        $(document).on('change','#sp', function(e){
            var id=$(this).val();
            $.ajax ({
                url : "<?php echo site_url('transaksi/barang_keluar/get_detail_permintaan');?>",
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
        })
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
        $('#form-tambah-barangkeluar').submit(function(e) {
            var jumlah = $('#jumlah_barang').val();
            for (var i = 0; i < jumlah; i++) {
                $('#nama_barang'+i).prop('disabled',false);
                $('#uom'+i).prop('disabled',false);
            }
            
            var data = $(this).serialize();

            $.ajax({
                method: 'POST',
                url: '<?php echo base_url('transaksi/barang_keluar/add_sp'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);
                
                if (out.status == 'form') {
                    document.getElementById("form-tambah-barangkeluar").reset();
                    $('#divisi').prop('selectedIndex', -1);
                    $('#bagian').empty();
                    $('#qty').prop('selectedIndex', -1);
                    $('.formmanysp').empty();
                    $('.selectpicker').selectpicker('refresh');
                    tampilKeluar();
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-barangmasuk").reset();
                    $('#divisi').prop('selectedIndex', -1);
                    $('#bagian').empty();
                    $('#qty').prop('selectedIndex', -1);
                    $('.formmanysp').empty();
                    tampilKeluar();
                    $('.msg').html(out.msg);
                    $('.selectpicker').selectpicker('refresh');
                    effect_msg();
                }
            })
            
            e.preventDefault();
        });

        $(document).on("click", ".konfirmasiHapus-daftarkeluar", function() {
            id_pegawai = $(this).attr("data-id");
        })
        $(document).on("click", ".hapus-datakeluar", function() {
            var id = id_pegawai;
            
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('transaksi/barang_keluar/delete'); ?>",
                data: "id=" +id
            })
            .done(function(data) {
                $('#konfirmasiHapus').modal('hide');
                tampilKeluar();
                $('.msg').html(data);
                effect_msg();
            })
        })
        
    </script>  
</section>