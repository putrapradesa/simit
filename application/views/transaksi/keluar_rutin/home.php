<section class="content">
    <div class="row clearfix">
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
                                    <th>Nama Barang</th>
                                    <th>Quantity</th>
                                    <th>Satuan</th>
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
            $.get('<?php echo base_url('transaksi/barang_keluar_rutin/tampil'); ?>', function(data) {
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
                url : "<?php echo site_url('transaksi/barang_keluar_rutin/get_bagian');?>",
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
                        <option value="<?php echo $l->Nama; ?>"><?php echo $l->Nama; ?></option>
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
            
            var data = $(this).serialize();

            $.ajax({
                method: 'POST',
                url: '<?php echo base_url('transaksi/barang_keluar_rutin/add'); ?>',
                data: data
            })
            .done(function(data) {
                var out = jQuery.parseJSON(data);
                
                if (out.status == 'form') {
                    document.getElementById("form-tambah-barangkeluar").reset();
                    $('#divisi').prop('selectedIndex', -1);
                    $('#bagian').empty();
                    $('.formmany').empty();
                    $('.selectpicker').selectpicker('refresh');
                    tampilKeluar();
                    $('.form-msg').html(out.msg);
                    effect_msg_form();
                } else {
                    document.getElementById("form-tambah-barangmasuk").reset();
                    $('#divisi').prop('selectedIndex', -1);
                    $('#bagian').empty();
                    $('.formmany').empty();
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
                url: "<?php echo base_url('transaksi/barang_keluar_rutin/delete'); ?>",
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