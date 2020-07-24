<?php
	$data['tittle'] = "KIB B";
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
                <h2 class="page-header">KARTU INVENTARIS BARANG PERALATAN DAN MESIN ( KIB B )</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li>Daftar Aset</li>
                    <li class="active">KIB B</li>
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
                                    <table class="table table-striped table-bordered table-hover table-sm" id="dt_kib_b">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Kode barang</th>
                                                <th>No Register</th>
                                                <th>Merek/Type</th>
                                                <th>Bahan</th>
                                                <th>Tahun Pembelian</th>
                                                <th>Asal-Usul</th>
                                                <th>Kondisi</th>
                                                <th>Harga</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kib_b">
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
            disply_kib_b();

            $('#dt_kib_b').dataTable();
        })

        function disply_kib_b() {
            $.ajax({
                type: "AJAX",
                url: "<?= base_url('Kib/get_kib_b') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var kib_b = "";
                    
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].harga;
                            
                        var	reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan 	= reverse.match(/\d{1,3}/g);
                            ribuan	= ribuan.join('.').split('').reverse().join('');

                        var bil = c[h].nli_sisa;
                        
                        var	reverse = bil.toString().split('').reverse().join(''),
                            ribu 	= reverse.match(/\d{1,3}/g);
                            ribu	= ribu.join('.').split('').reverse().join('');

                        if (c[h].kondisi == 1) { kondisi = "Baik"; } 
                        else if (c[h].kondisi == 2) { kondisi = "Rusak Ringan"; }
                        else if (c[h].kondisi == 3) { kondisi = "Rusak Berat"; } 
                        else { kondisi = "-"; }

                        if (c[h].merk_type == "") { merk_type = "-"; }
                        if (c[h].bahan == "") { bahan = "-"; }

                        kib_b +=
                        '<tr>' + 
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td style="text-align: right;">' + c[h].no_reg + '</td>' +
                            '<td>' + merk_type + '</td>' +
                            '<td>' + bahan + '</td>' +
                            '<td>' + c[h].thn_beli + '</td>' +
                            '<td>' + c[h].perolehan + '</td>' +
                            '<td>' + kondisi + '</td>' +
                            '<td style="text-align: right;">' + ribuan + '</td>' +
                            '<td style="text-align: right;">' + c[h].umr_ekonomis + '</td>' +
                            '<td style="text-align: right;">' + ribu + '</td>' +
                        '</tr>';
                    }
                    $('#kib_b').html(kib_b);
                }
            });
        }
    </script>

</body>

</html>