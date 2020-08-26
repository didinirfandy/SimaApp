<?php
$data['tittle'] = "Laporan Pengadaan";
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
                <h2 class="page-header">Laporan Pengadaan</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Laporan</li>
                    <li class="active">Pengadaan</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="font-weight:bold;">Laporan Pengadaan Barang</h4>
                                <hr align="right" color="black">
                            </div>
                            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-md-4 mx-sm-3 mb-3">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caritgl"><i class="fa fa-print"></i> Buat Laporan</button>
                                    </div>
                                </div><br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="lp_pengadaan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>No Register</th>
                                                <th>Nama Barang</th>
                                                <th>Merk/Type</th>
                                                <th>No. Sertiikat</th>
                                                <th>Bahan</th>
                                                <th>Perolehan</th>
                                                <th>Tahun Periode</th>
                                                <th>Ukuran Barang</th>
                                                <th>Satuan</th>
                                                <th>Keadaan Barang (B, RR, RB)</th>
                                                <th>Jumlah Barang</th>
                                                <th>Harga</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tmpl_data">
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
            <!-- Modal -->
            <div class="modal fade" id="caritgl" tabindex="-1" role="dialog" aria-labelledby="caritgl" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title" id="caritgl">Filter Laporan</h5>
                        </div>
                        <?= form_open('Print_excel/export_pengadaan'); ?>
                        <div class="modal-body">
                            <div class="panel-body">
                                <div class="form-group row">
                                    <label for="tgl_awal">Pilih Tanggal</label>
                                    <div class="input-group input-daterange">
                                        <input type="date" class="form-control" name="tgl_awal" id="tgl_awal">
                                        <div class="input-group-addon">to</div>
                                        <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kategori">Nama Barang</label><br>
                                    <select class="selectbox col-md-12" style="width: 267px;" name="kategori" id="kategori">
                                        <option value="all">Semua</option>
                                        <?php
                                        foreach ($peng as $d) { ?>
                                            <option value="<?= $d['kd_brg'] ?>"><?= $d['nm_brg'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="kategori">Tahun Beli</label>
                                    <input type="text" class="form-control" name="thn_beli" id="thn_beli" pattern="[0-9]{4}" title="Inputkan Nomor saja dan tidak lebih dari 4 karakter">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary" name="cetak">Cetak</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php $this->load->view('template/script') ?>

    <script type="text/javascript">
        $(document).ready(function() {
            tmpl_data();

            $("#lp_pengadaan").dataTable();
        });

        function tmpl_data() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('Laporan/get_dt_pengadaan') ?>",
                async: false,
                dataType: "JSON",
                success: function(a) {
                    var html = "";
                    for (i = 0; i < a.length; i++) {
                        if (a[i].nli_sisa != "") {
                            var bilangan = a[i].nli_sisa;

                            var reverse = bilangan.toString().split('').reverse().join(''),
                                ribuan = reverse.match(/\d{1,3}/g);
                            nli_sisa = ribuan.join('.').split('').reverse().join('');
                        } else {
                            nli_sisa = "";
                        }

                        if (a[i].harga != "") {
                            var bil = a[i].harga;

                            var reverse = bil.toString().split('').reverse().join(''),
                                ribuan = reverse.match(/\d{1,3}/g);
                            harga = ribuan.join('.').split('').reverse().join('');
                        } else {
                            harga = "";
                        }

                        if (a[i].satuan_brg == 1) {
                            satuan = "Buah";
                        } else if (a[i].satuan_brg == 2) {
                            satuan = "Unit";
                        } else if (a[i].satuan_brg == 3) {
                            satuan = "Set";
                        } else {
                            satuan = "-";
                        }

                        if (a[i].kondisi == 1) {
                            kondisi = "Baik";
                        } else if (a[i].kondisi == 2) {
                            kondisi = "Rusak Ringan";
                        } else if (a[i].kondisi == 3) {
                            kondisi = "Rusak Berat";
                        } else {
                            kondisi = "-";
                        }

                        html +=
                            '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + a[i].kd_brg + '</td>' +
                            '<td>' + a[i].no_reg + '</td>' +
                            '<td>' + a[i].nm_brg + '</td>' +
                            '<td>' + a[i].merk_type + '</td>' +
                            '<td>' + a[i].st_stfkt_no + '</td>' +
                            '<td>' + a[i].bahan + '</td>' +
                            '<td>' + a[i].perolehan + '</td>' +
                            '<td>' + a[i].thn_beli + '</td>' +
                            '<td>' + a[i].ukuran_cc + '</td>' +
                            '<td>' + satuan + '</td>' +
                            '<td>' + kondisi + '</td>' +
                            '<td>' + a[i].jmlh_brg + '</td>' +
                            '<td style="text-align: right;">' + harga + '</td>' +
                            '<td style="text-align: right;">' + a[i].umr_ekonomis + '</td>' +
                            '<td style="text-align: right;">' + nli_sisa + '</td>' +
                            '<td>' + a[i].ket + '</td>' +
                            '</tr>';
                    }
                    $('#tmpl_data').html(html);
                }
            });
        }

        const statusgagal = $('.status-gagal').data('statusgagal');
        // console.log(statusgagal);
        if (statusgagal) {
            swal({
                title: "Data kosong",
                text: "Pilih dan isi kembali filter yang tepat untuk mendapatkan data laporan",
                type: "error",
                timer: 7000,
                showConfirmButton: false
            });
        }
    </script>

</body>

</html>