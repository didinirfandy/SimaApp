<?php
$data['tittle'] = "KIB E";
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
                <h3 class="page-header">KARTU INVENTARIS BARANG ASET TETAP LAINNYA ( KIB E )</h3>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 40, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Daftar Aset</li>
                    <li class="active">KIB E</li>
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
                                    <table class="table table-striped table-bordered table-hover table-sm" style="padding: 0.3rem;" id="dt_kib_e">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-bottom: 40px;">No</th>
                                                <th rowspan="2" style="padding-bottom: 40px;">Nama Barang</th>
                                                <th colspan="2" style="padding-bottom: 15px;">Nomor</th>
                                                <th colspan="2" style="padding-bottom: 15px;">Buku/Perpustakaan</th>
                                                <th colspan="3">Barang Bercorak Kesenian/Kebudayaan</th>
                                                <th colspan="2">Hewan/Ternak dan Tumbuhan</th>
                                                <th rowspan="2" style="padding-bottom: 40px;">Jumlah</th>
                                                <th rowspan="2" style="padding-bottom: 40px;">Tahun Cetak/Pembeli</th>
                                                <th rowspan="2" style="padding-bottom: 40px;">Asal-Usul</th>
                                                <th rowspan="2" style="padding-bottom: 40px;">Harga</th>
                                            </tr>
                                            <tr>
                                                <th>Kode barang</th>
                                                <th>No Register</th>
                                                <th>Judul/Pencipta</th>
                                                <th>Spesifikasi</th>
                                                <th>Asal Daerah</th>
                                                <th>Pencipta</th>
                                                <th>Bahan</th>
                                                <th>Jenis</th>
                                                <th>Ukuran</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kib_e">
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
            disply_kib_e();

            $('#dt_kib_e').dataTable();
        })

        function disply_kib_e() {
            $.ajax({
                type: "AJAX",
                url: "<?= base_url('Kib/get_kib_e') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var kib_e = "";

                    for (h = 0; h < c.length; h++) {
                        if (c[h].harga != "") {
                            var bilangan = c[h].harga;

                            var reverse = bilangan.toString().split('').reverse().join(''),
                                harga = reverse.match(/\d{1,3}/g);
                            harga = harga.join('.').split('').reverse().join('');
                        } else {
                            harga = "";
                        }

                        kib_e +=
                            '<tr>' +
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td style="text-align: right;">' + c[h].no_reg + '</td>' +
                            '<td>' + c[h].bp_jp + '</td>' +
                            '<td>' + c[h].bp_s + '</td>' +
                            '<td>' + c[h].bbkk_ad + '</td>' +
                            '<td>' + c[h].bbkk_p + '</td>' +
                            '<td>' + c[h].bbkk_b + '</td>' +
                            '<td>' + c[h].htt_j + '</td>' +
                            '<td>' + c[h].htt_u + '</td>' +
                            '<td>' + c[h].jmlh_brg + '</td>' +
                            '<td>' + c[h].thn_beli + '</td>' +
                            '<td>' + c[h].perolehan + '</td>' +
                            '<td style="text-align: right;">' + harga + '</td>' +
                            '</tr>';
                    }
                    $('#kib_e').html(kib_e);
                }
            });
        }
    </script>

</body>

</html>