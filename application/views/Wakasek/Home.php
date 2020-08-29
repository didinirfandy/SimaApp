<?php
$data['tittle'] = "Halaman Utama";
$this->load->view('template/head', $data);
?>

<body>
    <div id="wrapper">
        <?php $this->load->view('template/navbar'); ?>
        <!--/. NAV TOP  -->
        <?php $this->load->view('template/menu'); ?>
        <!-- /. NAV SIDE  -->

        <div id="page-wrapper">
            <div class="header">
                <h2 class="page-header">Dashboard</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li>
                        <a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 50, "<br>\n"); ?></a>
                    </li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="board">
                            <div class="panel panel-primary">
                                <div class="number">
                                    <h3>
                                        <h3><?= $jmlh[0]['id'] ?></h3>
                                        <small>Total aset aktif</small>
                                    </h3>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-laptop fa-5x red"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="board">
                            <div class="panel panel-primary">
                                <div class="number">
                                    <h3>
                                        <h3><?= $stts_dipinjam[0]['dipinjam'] ?></h3>
                                        <small>Aset terpinjam</small>
                                    </h3>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-handshake-o fa-5x green"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="board">
                            <div class="panel panel-primary">
                                <div class="number">
                                    <h3>
                                        <h3><?= $stts_dikembalikan[0]['dikembalikan'] ?></h3>
                                        <small>Aset dikembalikan</small>
                                    </h3>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-handshake-o fa-5x blue"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $all = $jmlh[0]['id'];
                $a   = $jns_brg[0]['tot'];
                $b   = $jns_brg[1]['tot'];
                $c   = $jns_brg[2]['tot'];
                $e   = $jns_brg[3]['tot'];

                $tot_a = ($a / $all) * 100;
                $tot_b = ($b / $all) * 100;
                $tot_c = ($c / $all) * 100;
                $tot_e = ($e / $all) * 100;
                ?>
                <div class="row">
                    <div class="col-xs-6 col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body easypiechart-panel">
                                <h4>KIB A</h4>
                                <div class="easypiechart" id="easypiechart-blue" data-percent="<?= ceil($tot_a) ?>"><span class="percent"><?= ceil($tot_a) ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body easypiechart-panel">
                                <h4>KIB B</h4>
                                <div class="easypiechart" id="easypiechart-orange" data-percent="<?= ceil($tot_b) ?>"><span class="percent"><?= ceil($tot_b) ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body easypiechart-panel">
                                <h4>KIB C</h4>
                                <div class="easypiechart" id="easypiechart-teal" data-percent="<?= ceil($tot_c) ?>"><span class="percent"><?= ceil($tot_c) ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body easypiechart-panel">
                                <h4>KIB E</h4>
                                <div class="easypiechart" id="easypiechart-red" data-percent="<?= ceil($tot_e) ?>"><span class="percent"><?= ceil($tot_e) ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.row-->

                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="panel panel-default chartJs">
                            <div class="panel-heading">
                                <div class="card-title">
                                    <div class="title">Jumlah Aset Perkategori</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="asetPerkategori" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="panel panel-default chartJs">
                            <div class="panel-heading">
                                <div class="card-title">
                                    <div class="title">Status Usulan Pengadaan</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="usulanPengadaan" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
                <?php $this->load->view('template/copyright') ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php $this->load->view('template/script') ?>

    <!-- <script src="<?= base_url(); ?>assets_app/js/custom-scripts.js"></script> -->
    <!-- Chart Js -->
    <script type="text/javascript" src="<?= base_url(); ?>assets_app/js/Chart.min.js"></script>
    <script>
        var get_data_aset = '<?= base_url('Aset/get_data_aset') ?>';
        var get_status = '<?= base_url('Aset/get_status') ?>';
    </script>
    <script type="text/javascript" src="<?= base_url(); ?>assets_app/js/chartjs.js"></script>
</body>

</html>