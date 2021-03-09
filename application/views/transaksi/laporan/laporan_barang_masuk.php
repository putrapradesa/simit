
<section class="content">
	<form id="form-laporan-barangmasuk" method="POST">
	<div class="row clearfix">
		<div class="col-lg-12 col-md-11 col-sm-11 col-xs-12">
			<div class="card col-lg-12 col-md-11 col-sm-11 col-xs-12 align-self-center">
				<div class="header">
					<h1><?php echo($Judul)?></h1>
				</div>
				<div class = "header">
					<div class="row clearfix" id="date_start">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="date_start">Tanggal Awal</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" id="start_date" name="start_date" placeholder="Please choose a date..." required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix" id="date_to">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="date_to">Tanggal Akhir</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" id="date_to" name="date_to" placeholder="Please choose a date..." required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Cari</button>
                            <button type="button" class="btn btn-primary m-t-15 waves-effect">Excel</button>
                        </div>
                    </div>
                </div>
                <div class="body">
                	<div class="table-responsive">
                        <table id="list-data" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Supplier</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                </tr>
                             </thead>
                             <tbody id="data-laporan-masuk">
                                 <td>index</td>
                                 <td>CreateUtc</td>
                                 <td>NamaBarang</td>
                                 <td>Jumlah</td>
                             </tbody>
                        </table>
                    </div>
                </div>
			</div>
		</div>
	</div>
</form>
	<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script> 
    <script type="text/javascript">
    	
    </script>
</section>