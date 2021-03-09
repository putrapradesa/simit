<section class="content">
        <div class="container-fluid">
            <!-- <div class="block-header">
                <h2><?php echo($judul)?></h2>
            </div> -->

            <!-- Widgets -->
                <div class="row clearfix">
                        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                            <div class="card">
                                <div class="info-box bg-pink hover-expand-effect ">
                                    <div class="icon">
                                        <i class="material-icons">computer</i>
                                    </div>
                                    <div class="content">
                                        <div class="text">Garment</div>
                                        <div class="number count-to" data-from="0" data-to=<?php echo $garment->Quantity;?> data-speed="1000" data-fresh-interval="20"></div>   
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box bg-cyan hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">computer</i>
                                </div>
                                <div class="content">
                                    <div class="text">Textile</div>
                                    <div class="number count-to" data-from="0" data-to=<?php echo $textile->Quantity;?> data-speed="1000" data-fresh-interval="20"></div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box bg-light-green hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">local_printshop</i>
                                </div>
                                <div class="content">
                                    <div class="text">Printer</div>
                                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box bg-orange hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">scanner</i>
                                </div>
                                <div class="content">
                                    <div class="text">Scanner</div>
                                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box bg-orange hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">scanner</i>
                                </div>
                                <div class="content">
                                    <div class="text">Scanner</div>
                                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                                </div>
                            </div>
                        </div>
                    
                    
                </div>
        </div>
    </section>

    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script>