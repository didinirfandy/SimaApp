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
                <h1 class="page-header">
                    Penghapusan Aset
                </h1>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li class="active">Penghapusan Aset</li>
                </ol> 
            </div>
            <!-- Swetalert Berhasil -->
            <div class="status-insert" data-statusinsert="<?= $this->session->flashdata('statusinsert'); ?>"></div>
            <!-- Swetalert Gagal -->
            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
            <div id="page-inner">
                <!-- /. ROW  -->
                <?php 
                    $nilai_akhir = array();
                    foreach ($matriks_nilai as $m) {
                        $nilai_akhir[$m['kd_brg']][$m['no_reg']]  = 0;
                    }
                    // print_r($nm_brg);

                    $bobot = array();
                    foreach ($bbt as $b) {
                        $bobot[$b['id_bobot']]   = $b['bobot'];
                    }
                    // print_r($bobot);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Pengajuan Penghapusan</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <!-- <th></th> -->
                                            <th>Kode Aset</th>
                                            <th>No Reg</th>
                                            <th>Nama Aset</th>
                                            <th>Kondisi</th>
                                            <th>Nilai Buku</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $i = 1;
                                        foreach ($matriks_nilai as $mn) {?>
                                            <tr>
                                                <!-- <td><?= $i; ?></td> -->
                                                <td><?= $mn['kd_brg']; ?></td>
                                                <td><?= $mn['no_reg']; ?></td>
                                                <td><?= $mn['nm_brg']; ?></td>
                                                <td><?= $mn['kondisi_brg']; ?></td>
                                                <td><?= $mn['nilai_buku']; ?></td>
                                                <td><?= $mn['sisa_umr_ekonomis']; ?></td>
                                            </tr>
                                        <?php
                                        $i++;
                                        }
                                    ?>
                                    </tbody>
                                </table>

                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Aset</th>
                                            <th>No Reg</th>
                                            <th>Nama Aset</th>
                                            <th>Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <?= form_open('Penghapusan_aset/insert_rengking'); ?>
                                    <tbody>
                                    <?php 
                                        $i = 1;
                                        foreach ($matriks_nilai as $mn) { ?>
                                            <tr>
                                                <input type="hidden" name="id_brg[]" value="<?= $mn['id_brg'] ?>">
                                                <input type="hidden" name="kd_brg[]" value="<?= $mn['kd_brg'] ?>">
                                                <input type="hidden" name="no_reg[]" value="<?= $mn['no_reg'] ?>">
                                                <input type="hidden" name="nm_brg[]" value="<?= $mn['nm_brg'] ?>">
                                                <td><?= $i; ?></td>
                                                <td><?= $mn['kd_brg']; ?></td>
                                                <td><?= $mn['no_reg']; ?></td>
                                                <td><?= $mn['nm_brg']; ?></td>
                                            <?php 
                                            foreach ($minmax as $xn ) { 
                                                $selisih_kon_brg            = $xn['kon_brgx'] - $xn['kon_brgn'];
                                                $selisih_nil_bk             = $xn['nil_bukux'] - $xn['nil_bukun'];
                                                $selisih_sisa_umr_ekonomis  = $xn['sisa_umr_ekonomisx'] - $xn['sisa_umr_ekonomisn'];

                                                $m_nor_nilai_kondisi_brg        = ($mn['kondisi_brg'] - $xn['kon_brgn']) / $selisih_kon_brg;
                                                $m_nor_nilai_nilai_buku         = ($mn['nilai_buku'] - $xn['nil_bukun']) / $selisih_nil_bk;
                                                $m_nor_nilai_sisa_umr_ekonomis  = ($mn['sisa_umr_ekonomis'] - $xn['sisa_umr_ekonomisn']) / $selisih_sisa_umr_ekonomis;

                                                $m_krit_bbt_kondisi_brg         = $m_nor_nilai_kondisi_brg * $bobot[1];
                                                $m_krit_bbt_nilai_buku          = $m_nor_nilai_nilai_buku * $bobot[2];
                                                $m_krit_bbt_sisa_umr_ekonomis   = $m_nor_nilai_sisa_umr_ekonomis * $bobot[3];

                                                $nilai_akhir[$mn['kd_brg']][$mn['no_reg']] = $m_krit_bbt_kondisi_brg + $m_krit_bbt_nilai_buku + $m_krit_bbt_sisa_umr_ekonomis;
                                                
                                                ?>
                                                <input type="hidden" name="nilai_akhir[]" value="<?= $nilai_akhir[$mn['kd_brg']][$mn['no_reg']]; ?>">
                                                <td><?= $nilai_akhir[$mn['kd_brg']][$mn['no_reg']]; ?></td>
                                            <?php } 
                                            ?>
                                            </tr>
                                        <?php
                                        $i++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <hr align="right" color="black">
                                <div class="footer">
                                    <button class="btn btn-primary" name="submit" type="submit"><i class="fa fa-fw fa-floppy-o"></i> Proses</button>
                                </div>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>		
                </div>
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
                <!-- /. ROW  -->
				<?php $this->load->view('template/copyright') ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php $this->load->view('template/script') ?>
    <script type="text/javascript">
        $(document).ready(function() {
            // tampil_pelihara();

            $('#pelihara').dataTable();
        });

        const statusinsert = $('.status-insert').data('statusinsert');
        // console.log(statusinsert);
        if (statusinsert) {
            swal({
                text: "Proses " + statusinsert,
                type: "success",
                timer: 2500,
                showConfirmButton: false
            });
        }

        const statusgagal = $('.status-gagal').data('statusgagal');
        // console.log(statusgagal);
        if (statusgagal) {
            swal({
                text: "Proses " + statusgagal,
                type: "error",
                timer: 2500,
                showConfirmButton: false
            });
        }

        
    </script>
</body>

</html>