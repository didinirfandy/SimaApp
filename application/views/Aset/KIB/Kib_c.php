<?php
	$data['tittle'] = "KIB C";
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
                <h2 class="page-header">KARTU INVENTARIS BARANG GEDUNG DAN BANGUNAN ( KIB C )</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li>Daftar Aset</li>
                    <li class="active">KIB C</li>
                </ol> 
            </div>
            
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <!-- <h4 style="font-weight:bold;">Data Kartu Inventaris Peralatan dan Mesin</h4> -->
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" style="padding: 0.3rem;" id="dt_kib_c">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-bottom: 25px;">No</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Nama Barang</th>
                                                <th colspan="2">Nomor</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Kondisi</th>
                                                <th colspan="2">Konstruksi Bangunan</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Luas</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Letak/Lokasi Alamat</th>
                                                <th colspan="2">Dokumen Gedung</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Status Tanah</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Asal-Usul</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Harga</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">No Kode Tanah</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Keterangan</th>
                                            </tr>
                                            <tr>
                                                <th>Kode barang</th>
                                                <th>No Register</th>
                                                <th>Bertingkat</th>
                                                <th>Beton</th>
                                                <th>Tanggal</th>
                                                <th>Nomor</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kib_c">
                                        </tbody>
                                    </table>
                                </div>
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
            disply_kib_c();

            $('#dt_kib_c').dataTable();
        })

        function disply_kib_c() {
            $.ajax({
                type: "AJAX",
                url: "<?= base_url('Kib/get_kib_c') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var kib_c = "";
                    
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].harga;
                            
                        var	reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan 	= reverse.match(/\d{1,3}/g);
                            ribuan	= ribuan.join('.').split('').reverse().join('');

                        if (c[h].kondisi == 1) { kondisi = "Baik"; } 
                        else if (c[h].kondisi == 2) { kondisi = "Rusak Ringan"; }
                        else if (c[h].kondisi == 3) { kondisi = "Rusak Berat"; } 
                        else { kondisi = "-"; }

                        if (c[h].bertingkat == 1 && c[h].beton == 1) { bb = "Ya"; } 
                        else if (c[h].bertingkat == 2 && c[h].beton == 2) { bb = "Tidak"; }
                        else { bb = "-"; }

                        if (c[h].letak_lokasi == "") { letak_lokasi = "-"; }
                        if (c[h].dg_tgl == "0000-00-00") { dg_tgl = "-"; }
                        if (c[h].dg_no == "0") { dg_no = "-"; }
                        if (c[h].stts_tanah == "") { stts_tanah = "-"; }

                        kib_c +=
                        '<tr>' + 
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td style="text-align: right;">' + c[h].no_reg + '</td>' +
                            '<td >' + kondisi + '</td>' +
                            '<td>' + bb + '</td>' +
                            '<td>' + bb + '</td>' +
                            '<td style="text-align: right;">' + c[h].luas + '</td>' +
                            '<td>' + c[h].letak_lokasi + '</td>' +
                            '<td>' + dg_tgl + '</td>' +
                            '<td>' + dg_no + '</td>' +
                            '<td>' + stts_tanah + '</td>' +
                            '<td style="text-align: right;">' + c[h].perolehan + '</td>' +
                            '<td style="text-align: right;">' + ribuan + '</td>' +
                            '<td style="text-align: right;">' + c[h].no_kd_tanah + '</td>' +
                            '<td style="text-align: right;">' + c[h].ket + '</td>' +
                        '</tr>';
                    }
                    $('#kib_c').html(kib_c);
                }
            });
        }
    </script>

</body>

</html>