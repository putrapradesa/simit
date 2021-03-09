<section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url(); ?>assets/images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('nama') ?> </div>
                    <div class="level"><?php echo $this->session->userdata('level')?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <!-- <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li> -->
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo base_url().'logout/aksi'?>"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="">
                        <a href="<?php echo base_url(); ?>">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li <?php if ($menu == 'master' && $ses_level == 'admin') { 
                            echo 'class="active"'; 
                        }else if ($ses_level != 'admin'){
                            echo 'style = "display:none"';
                        }?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">list</i>
                            <span>Master</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if ($submenu == 'pt') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>master/pt">
                                    <span>PT</span>
                                </a>
                            </li>
                            <li <?php if ($submenu == 'divisi') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>master/divisi">
                                    <span>Divisi</span>
                                </a>
                            </li>
                            <li <?php if ($submenu == 'bagian') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>master/bagian">
                                    <span>Bagian</span>
                                </a>
                            </li>
                            <li <?php if ($submenu == 'supplier') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>master/supplier">
                                    <span>Supplier</span>
                                </a>
                            </li>
                            <li <?php if ($submenu == 'kategori') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>master/kategori">
                                    <span>Kategori</span>
                                </a>
                            </li>
                            <li <?php if ($submenu == 'barang') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>master/barang">
                                    <span>Barang</span>
                                </a>
                            </li>
                            <li <?php if ($submenu == 'satuan') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>master/uom">
                                    <span>Satuan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if ($menu == 'transaksi' && $ses_level == 'admin') { 
                            echo 'class="active"'; 
                        }else if ($ses_level != 'admin'){
                            echo 'style = "display:none"';
                        }?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">widgets</i>
                            <span>Transaksi</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if ($submenu == 'daftar_permintaan') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>transaksi/permintaan">
                                    <span>Daftar Permintaan</span>
                                </a>
                            </li>
                            <li <?php if ($submenu == 'barang_masuk') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>transaksi/barang_masuk">
                                    <span>Barang Masuk</span>
                                </a>
                            </li>
                            <li <?php if ($submenu == 'barang_keluar') { echo 'class="active"'; }?>>
                                <a href="<?php echo base_url();?>transaksi/barang_keluar">
                                    <span>Barang Keluar</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if ($menu == 'barang_keluar_rutin' && ($ses_level == 'user' || $ses_level == 'admin') ) { 
                            echo 'class="active"'; 
                        }?>>
                        <a href="<?php echo base_url();?>transaksi/barang_keluar_rutin" >
                            <i class="material-icons">widgets</i>
                            <span>Pengambilan Barang</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <!-- <div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div> -->
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside> -->
        <!-- #END# Right Sidebar -->
    </section>