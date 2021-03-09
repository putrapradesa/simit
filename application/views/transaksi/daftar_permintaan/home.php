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
                    <button type="button" class="btn bg-blue waves-effect " data-toggle="modal" data-target="#tambah-permintaan"><i class="material-icons">add_box</i> <span>Tambah</span></button>
                    <!-- <a href="<?php echo base_url();?>transaksi/permintaan/Excel" class = "btn bg-blue waves-effect" ><i class="material-icons">file_download</i><span>Excel</span></a> -->
                    <!-- <a href="<?php echo base_url();?>master/pt/PDF" class = "btn bg-blue waves-effect" ><i class="material-icons">file_download</i><span>PDF</span></a> -->
                    <!-- <button type="button" class="btn bg-blue waves-effect " data-toggle="modal" data-target="#UploadModal"><i class="material-icons">file_upload</i> <span>Upload CSV</span></button> -->
                </div>
                <div class = "body">
                    
                    <div style="padding-left: 81%;">
                        <select class = "selectpicker form-group" id="sortBy" style="padding-left:100px">
                            <option value="">Filter By</option>
                            <option value="Sudah">Diterima</option>
                            <option value="Belum">Belum Diterima</option>
                        </select>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="list-data" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Permintaan</th>
                                    <th>Nama Pemohon</th>
                                    <th>PT</th>
                                    <th>Divisi</th>
                                    <th>Bagian</th>
                                    <th>Keterangan</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody id="data-permintaan">
                                 
                             </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php echo $modal_tambah_daftar_permintaan; ?>

    <div id="tempat-modal"></div>

    <?php show_my_confirm('konfirmasiHapus', 'hapus-datapermintaan', 'Hapus Data Ini?', 'Ya, Hapus Data Ini'); ?>

    <!-- <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script> 
    <script text="javascript">
        window.onload = function() {
        tampilPermintaan();
            <?php
                if ($this->session->flashdata('msg') != '') {
                    echo "effect_msg();";
                }
            ?>
        }
        // var MyTable = $('#list-data').dataTable({
        //     "paging": true,
        //     "lengthChange": true,
        //     "searching": false,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false
        // })
        
        function refresh() {
            MyTable = $('#list-data').DataTable();
        }
        var MyTable;
        // function tampilPermintaan() {
        //     $.get('<?php echo base_url('transaksi/permintaan/tampil'); ?>', function(data) {
        //         MyTable.fnDestroy();
        //         // console.log(data);
        //         $('#data-permintaan').html(data);
        //         refresh();
        //     });
        // }
        function tampilPermintaan() {
            $('#list-data').DataTable().clear().destroy();
            MyTable = $('#list-data').DataTable({
                "processing"    :true,
                "serverSide"    :true,
                "order"         :[],
                "serverMethod"  : 'post',

                "ajax":{
                    "url": "<?php echo base_url('transaksi/permintaan/tampil'); ?>",
                    "data"  : function(data){
                        data.searchName = $('#searchInput').val();
                        data.searchStatus = $('#sortBy').val();
                    }
                },
                "columnDefs": [
                    { 
                        "targets":[0, 3, 4],  
                        "orderable":false,   //set not orderable
                    },
                ],
            })

            // refresh();
            // $.get('<?php echo base_url('transaksi/permintaan/tampil'); ?>', function(data) {
            //     MyTable.fnDestroy();
            //     // console.log(data);
            //     $('#data-permintaan').html(data);
            //     refresh();
            // });
        }
        $(document).ready(function(e) {
        $('.btnaddform').click(function(e){
            e.preventDefault();
            var jumlah = parseInt($("#jumlah-form").val())

                var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya
                
                $('.formmany').append(`
                <tr id="inputmany">
                <td><select class="selectpicker form-control" data-live-search="true" name="nama_barang[]" id="nama_barang">
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
    });

    $(document).on('click','.btndeleteform', function(e){
        e.preventDefault();

        $(this).parents('tr').remove();
    })

    $('#form-tambah-permintaan').submit(function(e) {
        var data = $(this).serialize();

        $.ajax({
            method: 'POST',
            url: '<?php echo base_url('transaksi/permintaan/add'); ?>',
            data: data
        })
        .done(function(data) {
            // console.log(data);
            var out = jQuery.parseJSON(data);
            
            if (out.status == 'form') {
                document.getElementById("form-tambah-permintaan").reset();
                $('#pt').prop('selectedIndex', -1);
                $('#nama_barang').prop('selectedIndex', -1);
                $('#sortBy').prop('selectedIndex', -1);
                $('#qty').prop('selectedIndex', -1);
                if(document.getElementById('inputmany') != null){
                    document.getElementById('inputmany').remove();
                }
                // $('#tambah-pt').modal('hide');
                // console.log(out.msg);
                $('.selectpicker').selectpicker('refresh');
                
                tampilPermintaan();
                $('.form-msg').html(out.msg);
                effect_msg_form();
            } else {
                document.getElementById("form-tambah-permintaan").reset();
                $('#pt').prop('selectedIndex', -1);
                $('#nama_barang').prop('selectedIndex', -1);
                $('#qty').prop('selectedIndex', -1);
                if(document.getElementById('inputmany') != null){
                    document.getElementById('inputmany').remove();
                }
                
                // $('#tambah-bagian').modal('hide');
                tampilPermintaan();
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

    $(document).on("click", ".konfirmasiHapus-daftarpermintaan", function() {
        id_pegawai = $(this).attr("data-id");
    })
    $(document).on("click", ".hapus-datapermintaan", function() {
        var id = id_pegawai;
        
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('transaksi/permintaan/delete'); ?>",
            data: "id=" +id
        })
        .done(function(data) {
            $('#konfirmasiHapus').modal('hide');
            tampilPermintaan();
            $('.msg').html(data);
            effect_msg();
        })
    })
    $(document).ready(function(){
        $('#pt').change(function(){ 
            var id=$(this).val();
            $.ajax ({
                url : "<?php echo site_url('transaksi/permintaan/get_divisi');?>",
                method : "POST",
                data : {id: id},
                async : true,
                dataType : 'json',
                success: function(data){
                    
                    // var html = '';
                    // var i;
                    // for(i=0; i<data.length; i++){
                    //     html += '<option value='+data[i].Id+'>'+data[i].Nama+'</option>';
                    // }
                    // console.log(html)
                    $('#divisi').html(data);
                    $('.selectpicker').selectpicker('refresh');

                }
            });
        });

        $('#divisi').change(function(){ 
            var id=$(this).val();
            $.ajax ({
                url : "<?php echo site_url('transaksi/permintaan/get_bagian');?>",
                method : "POST",
                data : {id: id},
                async : true,
                dataType : 'json',
                success: function(data){
                    
                    // var html = '';
                    // var i;
                    // for(i=0; i<data.length; i++){
                    //     html += '<option value='+data[i].Id+'>'+data[i].Nama+'</option>';
                    // }
                    // console.log(html)
                    $('#bagian').html(data);
                    $('.selectpicker').selectpicker('refresh');

                }
            });
        });

        $('#sortBy').change(function(){
            // $('#list-data').DataTable().clear().destroy();
            tampilPermintaan()
        });
        // MyTable.on('select.dt', () => {           
        //     dt.searchPanes.rebuildPane(0, true);
        // });
    
        // MyTable.on('deselect.dt', () => {
        //     dt.searchPanes.rebuildPane(0, true);
        // });
        
        
    });
    
    </script>
</section>