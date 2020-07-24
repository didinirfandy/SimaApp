<nav class="navbar-default navbar-side" role="navigation">
    <div class="app-sidebar__user">
        <?php
        $id = $this->session->userdata('user_id');
        $this->load->model('Login_model');
        $profil = $this->Login_model->get_login($id);
        foreach ($profil as $p) { ?>
            <img class="app-sidebar__user-avatar" src="<?= base_url(); ?>assets_app/img/profil/<?= $p['image'] ?>">
        <?php } ?>
        <!-- <img class="app-sidebar__user-avatar" src="<?= base_url(); ?>assets_application/assets/faces/default.jpg"> -->
        <div>
            <span class="app-sidebar__user-name">
                <?php $str = $this->session->userdata('nama_pegawai');
                echo wordwrap($str, 15, "<br>\n"); ?>
            </span>
            <p class="app-sidebar__user-designation" style="padding-top: 0px; font-size: 13px;">
            <?php 
            $role = $this->session->userdata('role');
            if ($role == 1) {
                echo "Bagian Aset";
            } elseif ($role == 2) {
                echo "Waksek Sarana";
            } elseif ($role == 3) {
                echo "Kepala Sekolah";
            }
            ?>
            </p>
        </div>
    </div>
    <div class="sidebar-collapse">
        <?php
        $role = $this->session->userdata('role');
        if ($role == 1) { ?> <!-- Menu Aset -->
            <ul class="nav" id="main-menu">
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "home") { echo "active-menu";} ?>" href="<?=base_url()?>Aset/home"><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <li class="treeview 
                    <?php 
                    if ($this->uri->segment(2) == "data_usulan_pengadaan") { echo "active";}
                    elseif ($this->uri->segment(2) == "data_pengadaan") { echo "active";}
                    elseif ($this->uri->segment(2) == "data_peminjaman") { echo "active";}
                    ?>">
                    <a href="#md"><i class="fa fa-laptop"></i> Data Master<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li id="md">
                            <a class="<?php if ($this->uri->segment(2) == "data_usulan_pengadaan") { echo "active-menu";}?>" href="<?= base_url('Master_data/data_usulan_pengadaan'); ?>"><i class="fa fa-long-arrow-right"></i> Data Usulan Pengadaan</a>
                        </li>
                        <li id="md">
                            <a class="<?php if ($this->uri->segment(2) == "data_pengadaan") { echo "active-menu";}?>" href="<?= base_url('Master_data/data_pengadaan'); ?>"><i class="fa fa-long-arrow-right"></i> Data Pengadaan</a>
                        </li>
                        <li id="md">
                            <a class="<?php if ($this->uri->segment(2) == "data_peminjaman") { echo "active-menu";}?>" href="<?= base_url('Master_data/data_peminjaman'); ?>"><i class="fa fa-long-arrow-right"></i> Data Peminjaman</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview 
                    <?php 
                    if ($this->uri->segment(2) == "kib_a") { echo "active";} 
                    elseif ($this->uri->segment(2) == "kib_b") { echo "active";}
                    elseif ($this->uri->segment(2) == "kib_c") { echo "active";}
                    elseif ($this->uri->segment(2) == "kib_e") { echo "active";}
                    ?>">
                    <a href="#da"><i class="fa fa-barcode"></i> Daftar Aset<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li id="da">
                            <a class="<?php if ($this->uri->segment(2) == "kib_a") { echo "active-menu";}?>" href="<?= base_url('Kib/kib_a'); ?>"><i class="fa fa-long-arrow-right"></i> KIB A</a>
                        </li>
                        <li id="da">
                            <a class="<?php if ($this->uri->segment(2) == "kib_b") { echo "active-menu";}?>" href="<?= base_url('Kib/kib_b'); ?>"><i class="fa fa-long-arrow-right"></i> KIB B</a>
                        </li>
                        <li id="da">
                            <a class="<?php if ($this->uri->segment(2) == "kib_c") { echo "active-menu";}?>" href="<?= base_url('Kib/kib_c'); ?>"><i class="fa fa-long-arrow-right"></i> KIB C</a>
                        </li>
                        <li id="da">
                            <a class="<?php if ($this->uri->segment(2) == "kib_e") { echo "active-menu";}?>" href="<?= base_url('Kib/kib_e'); ?>"><i class="fa fa-long-arrow-right"></i> KIB E</a>
                        </li>
                    </ul>
                </li>
                <!-- <li>
                    <a class="<?php if ($this->uri->segment(2) == "daftar_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Daftar_aset/daftar_aset"><i class="fa fa-barcode"></i> Daftar Aset</a>
                </li> -->
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "pengadaan_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Pengadaan_aset/pengadaan_aset"><i class="fa fa-shopping-cart"></i> Pengadaan Aset</a>
                </li>
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "pemeliharaan_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Pemeliharaan_aset/pemeliharaan_aset"><i class="fa fa-wrench"></i> Pemeliharaan Aset</a>
                </li>
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "penghapusan_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Penghapusan_aset/penghapusan_aset"><i class="fa fa-trash-o"></i> Penghapusan Aset</a>
                </li>
            </ul>
        <?php } elseif ($role == 2) { ?> <!-- Menu Wakepsek -->
            <ul class="nav" id="main-menu">
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "home") { echo "active-menu";} ?>" href="<?=base_url()?>Wakasek/home"><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "daftar_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Daftar_aset/daftar_aset"><i class="fa fa-desktop"></i> Daftar Aset</a>
                </li> 
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "pengadaan_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Pengadaan_aset/pengadaan_aset"><i class="fa fa-barcode"></i> Pengadaan Aset</a>
                </li>
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "penghapusan_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Penghapusan_aset/penghapusan_aset"><i class="fa fa-trash-o"></i> Penghapusan Aset</a>
                </li>
                <li class="treeview 
                    <?php 
                    if ($this->uri->segment(2) == "lp_pengadaan") { echo "active";} 
                    elseif ($this->uri->segment(2) == "lp_peminjaman") { echo "active";}
                    elseif ($this->uri->segment(2) == "lp_pemeliharaan") { echo "active";}
                    elseif ($this->uri->segment(2) == "lp_penghapusan") { echo "active";}
                    ?>">
                    <a href="#lp"><i class="fa fa-file-text-o"></i> Laporan<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li id="lp">
                            <a class="<?php if ($this->uri->segment(2) == "lp_pengadaan") { echo "active-menu";}?>" href="<?=base_url()?>Wakasek/lp_pengadaan">Pengadaan</a>
                        </li>
                        <li id="lp">
                            <a class="<?php if ($this->uri->segment(2) == "lp_peminjaman") { echo "active-menu";}?>" href="<?=base_url()?>Wakasek/lp_peminjaman">Peminjaman</a>
                        </li>
                        <li id="lp">
                            <a class="<?php if ($this->uri->segment(2) == "lp_pemeliharaan") { echo "active-menu";} ?>" href="<?=base_url()?>Wakasek/lp_pemeliharaan">Pemeliharaan</a>
                        </li>
                        <li id="lp">
                            <a class="<?php if ($this->uri->segment(2) == "lp_penghapusan") { echo "active-menu";}?>" href="<?=base_url()?>Wakasek/lp_penghapusan">Penghapusan</a>
                        </li>
                    </ul>
                </li>
            </ul>
        <?php } elseif ($role == 3) { ?> <!-- Menu Kepsek -->
            <ul class="nav" id="main-menu">
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "home") { echo "active-menu";} ?>" href="<?=base_url()?>Kepsek/home"><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "daftar_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Kepsek/daftar_aset"><i class="fa fa-desktop"></i> Daftar Aset</a>
                </li> 
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "pengadaan_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Kepsek/pengadaan_aset"><i class="fa fa-barcode"></i> Pengadaan Aset</a>
                </li>
                <li>
                    <a class="<?php if ($this->uri->segment(2) == "penghapusan_aset") { echo "active-menu";} ?>" href="<?=base_url()?>Kepsek/penghapusan_aset"><i class="fa fa-trash-o"></i> Penghapusan Aset</a>
                </li>
                <li class="treeview 
                    <?php 
                    if ($this->uri->segment(2) == "lp_pengadaan") { echo "active";} 
                    elseif ($this->uri->segment(2) == "lp_peminjaman") { echo "active";}
                    elseif ($this->uri->segment(2) == "lp_pemeliharaan") { echo "active";}
                    elseif ($this->uri->segment(2) == "lp_penghapusan") { echo "active";}
                    ?>">
                    <a href="#lp"><i class="fa fa-file-text-o"></i> Laporan<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li id="lp">
                            <a class="<?php if ($this->uri->segment(2) == "lp_pengadaan") { echo "active-menu";}?>" href="<?=base_url()?>Kepsek/lp_pengadaan"><i class="fa fa-long-arrow-right"></i> Pengadaan</a>
                        </li>
                        <li id="lp">
                            <a class="<?php if ($this->uri->segment(2) == "lp_peminjaman") { echo "active-menu";}?>" href="<?=base_url()?>Kepsek/lp_peminjaman"><i class="fa fa-long-arrow-right"></i> Peminjaman</a>
                        </li>
                        <li id="lp">
                            <a class="<?php if ($this->uri->segment(2) == "lp_pemeliharaan") { echo "active-menu";} ?>" href="<?=base_url()?>Kepsek/lp_pemeliharaan"><i class="fa fa-long-arrow-right"></i> Pemeliharaan</a>
                        </li>
                        <li id="lp">
                            <a class="<?php if ($this->uri->segment(2) == "lp_penghapusan") { echo "active-menu";}?>" href="<?=base_url()?>Kepsek/lp_penghapusan"><i class="fa fa-long-arrow-right"></i> Penghapusan</a>
                        </li>
                    </ul>
                </li>
            </ul>
        <?php } ?>
    </div>
</nav>