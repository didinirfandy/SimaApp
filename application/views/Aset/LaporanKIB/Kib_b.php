<?php
$data['tittle'] = "Laporan KIB B";
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
                <h3 class="page-header">LAPORAN KARTU INVENTARIS BARANG PERALATAN DAN MESIN ( KIB B )</h3>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Laporan</li>
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
                            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-md-4 mx-sm-3 mb-3">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caritgl"><i class="fa fa-print" aria-hidden="true"></i> Buat Laporan</button>
                                    </div>
                                </div><br>
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
                                        <tbody id="tampilkan">
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
                        <?= form_open('Print_excel/export_kib_b'); ?>
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
                                    <label for="kategori">Nama Barang</label>
                                    <select class="selectbox col-md-12" style="width: 267px;" name="kategori" id="kategori">
                                        <optgroup label="Pilih Nama Barang">
                                            <option value="">Semua</option>
                                            <?php
                                            foreach ($dt_b as $d) { ?>
                                                <option value="<?= $d['kd_brg'] ?>"><?= $d['nm_brg'] ?></option>
                                            <?php }
                                            ?>
                                        </optgroup>
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
                            <button type="submit" class="btn btn-sm btn-primary" name="cetak_b">Cetak</button>
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
            tampil_data();
            $('#dt_kib_b').dataTable();
        });

        function tampil_data() {
            $.ajax({
                type: "get",
                url: "<?= base_url('LP_kib/lp_get_kib_b') ?>",
                async: false,
                dataType: "json",
                success: function(c) {
                    var kib = "";

                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].nli_sisa;

                        var reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan = reverse.match(/\d{1,3}/g);
                        nli_sisa = ribuan.join('.').split('').reverse().join('');

                        var bil = c[h].harga;

                        var reverse = bil.toString().split('').reverse().join(''),
                            ribuan = reverse.match(/\d{1,3}/g);
                        harga = ribuan.join('.').split('').reverse().join('');

                        if (c[h].kondisi == 1) {
                            kondisi = "Baik";
                        } else if (c[h].kondisi == 2) {
                            kondisi = "Rusak Ringan";
                        } else if (c[h].kondisi == 3) {
                            kondisi = "Rusak Berat";
                        } else {
                            kondisi = "-";
                        }

                        if (c[h].merk_type == "") {
                            merk_type = "-";
                        } else {
                            merk_type = c[h].merk_type;
                        }
                        if (c[h].bahan == "") {
                            bahan = "-";
                        } else {
                            bahan = c[h].bahan;
                        }

                        kib +=
                            '<tr>' +
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td>' + c[h].no_reg + '</td>' +
                            '<td>' + merk_type + '</td>' +
                            '<td>' + bahan + '</td>' +
                            '<td>' + c[h].thn_beli + '</td>' +
                            '<td>' + c[h].perolehan + '</td>' +
                            '<td>' + kondisi + '</td>' +
                            '<td style="text-align: right;">' + harga + '</td>' +
                            '<td style="text-align: right;">' + c[h].umr_ekonomis + '</td>' +
                            '<td style="text-align: right;">' + nli_sisa + '</td>' +

                            '</tr>';
                    }
                    $('#tampilkan').html(kib);
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