<?php
	$data['tittle'] = "Laporan Penghapusan";
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
                <h2 class="page-header">Laporan Penghapusan</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home"></a>Home</li>
                    <li>Laporan</li>
                    <li class="active">Laporan Penghapusan</li>
                </ol> 
            </div>
            
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Line Chart
                            </div>
                            <div class="panel-body">
                                
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

</body>

</html>