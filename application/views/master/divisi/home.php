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
                    <button type="button" class="btn bg-blue waves-effect " data-toggle="modal" data-target="#tambah-divisi"><i class="material-icons">add_box</i> <span>Tambah</span></button>
                    <!-- <a href="<?php echo base_url();?>master/divisi/Excel" class = "btn bg-blue waves-effect" ><i class="material-icons">file_download</i><span>Excel</span></a> -->
                    <!-- <a href="<?php echo base_url();?>master/pt/PDF" class = "btn bg-blue waves-effect" ><i class="material-icons">file_download</i><span>PDF</span></a> -->
                    <!-- <button type="button" class="btn bg-blue waves-effect " data-toggle="modal" data-target="#UploadModal"><i class="material-icons">file_upload</i> <span>Upload CSV</span></button> -->
                </div>
                <div class = "body">
                    <div class="table-responsive">
                        <table id="list-data" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID Divisi</th>
                                    <th>Nama</th>
                                    <th>PT</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody id="data-divisi">
                                 
                             </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

	<?php echo $modal_tambah_divisi; ?>
	
	<div id="tempat-modal"></div>

	<?php show_my_confirm('konfirmasiHapus', 'hapus-dataDivisi', 'Hapus Data Ini?', 'Ya, Hapus Data Ini'); ?>

    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script type="text/javascript">

    window.onload = function() {
		tampilDivisi();
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
    function effect_msg_form() {
		// $('.form-msg').hide();
		$('.form-msg').show(1000);
		setTimeout(function() { $('.form-msg').fadeOut(1000); }, 3000);
	}
    function refresh() {
		MyTable = $('#list-data').dataTable();
	}
	function effect_msg() {
		// $('.msg').hide();
		$('.msg').show(1000);
		setTimeout(function() { $('.msg').fadeOut(1000); }, 3000);
	}

	function tampilDivisi() {
		$.get('<?php echo base_url('master/divisi/tampil'); ?>', function(data) {
			MyTable.fnDestroy();
			$('#data-divisi').html(data);
			refresh();
		});
	}
    $('#form-tambah-divisi').submit(function(e) {
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('master/divisi/add'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilDivisi();
			if (out.status == 'form') {
				document.getElementById("form-tambah-divisi").reset();
				$('#pt').prop('selectedIndex', -1);
				if(document.getElementById('inputmany') != null){
                    document.getElementById('inputmany').remove();
				}
				$('.selectpicker').selectpicker('refresh');
				// $('#tambah-pt').modal('hide');
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-tambah-divisi").reset();
				$('#pt').prop('selectedIndex', -1);
				// document.getElementById("divisi").reset();
				if(document.getElementById('inputmany') != null){
                    document.getElementById('inputmany').remove();
				}
				$('.selectpicker').selectpicker('refresh');
				
				// $('#tambah-divisi').modal('hide');
				$('.msg').html(out.msg);
				
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$('#tambah-pegawai').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	var id_pt;
	$(document).on("click", ".konfirmasiHapus-divisi", function() {
		id_pegawai = $(this).attr("data-id");
	})
	$(document).on("click", ".hapus-dataDivisi", function() {
		var id = id_pegawai;
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('master/divisi/delete'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#konfirmasiHapus').modal('hide');
			tampilDivisi();
			$('.msg').html(data);
			effect_msg();
		})
	})

	$(document).on('submit', '#form-update-divisi', function(e){
		var data = $(this).serialize();

		$.ajax({
			method: 'POST',
			url: '<?php echo base_url('master/divisi/edit'); ?>',
			data: data
		})
		.done(function(data) {
			var out = jQuery.parseJSON(data);

			tampilDivisi()
			if (out.status == 'form') {
				$('.form-msg').html(out.msg);
				effect_msg_form();
			} else {
				document.getElementById("form-update-divisi").reset();
				// $('#update-divisi').modal('hide');
				$('.msg').html(out.msg);
				effect_msg();
			}
		})
		
		e.preventDefault();
	});

	$('#update-pegawai').on('hidden.bs.modal', function () {
	  $('.form-msg').html('');
	})

	$(document).on("click", ".update-dataDivisi", function() {
		var id = $(this).attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('master/divisi/update'); ?>",
			data: "id=" +id
		})
		.done(function(data) {
			$('#tempat-modal').html(data);
			$('#update-divisi').modal('show');
		})
	})

	$(document).ready(function(e) {
		$('.btnaddform').click(function(e){
            e.preventDefault();
            var jumlah = parseInt($("#jumlah-form").val())

                var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya
                
                $('.formmany').append(`
                <tr id="inputmany">
                    <td><input type="text" name="nama_divisi[]" class="form-control" placeholder="Enter Divisi Name" required></td>
                    <td><button type="button" class="btn btn-danger btn-xs btndeleteform">
                        <i class="material-icons">close</i>
                    </button></td>
                </tr>
                `);

                $("#jumlah-form").val(nextform)
        })
	});

	$(document).on('click','.btndeleteform', function(e){
        e.preventDefault();

        $(this).parents('tr').remove();
    })
    </script>