<?php
	$data['tittle'] = "Penghapusan Aset";
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
                <h2 class="page-header">Penghapusan Aset</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li class="active">Penghapusan Aset</li>
                </ol> 
            </div>
            
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Rengking</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Rengking</th>
                                            <th>Kode Aset</th>
                                            <th>No Reg</th>
                                            <th>Nama Aset</th>
                                            <th>Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $i = 1;
                                        foreach ($rengking as $r) {?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $r['kd_brg']; ?></td>
                                                <td><?= $r['no_reg']; ?></td>
                                                <td><?= $r['nm_brg']; ?></td>
                                                <td><?= $r['nilai_akhir']; ?></td>
                                            </tr>
                                        <?php
                                        $i++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>					
                        </div>   
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                    
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