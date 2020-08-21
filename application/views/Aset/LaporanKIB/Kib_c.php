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
                <h3 class="page-header">LAPORAN KARTU INVENTARIS BARANG GEDUNG DAN BANGUNAN ( KIB C )</h3>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Laporan</li>
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
                            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-md-4 mx-sm-3 mb-3">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caritgl"><i class="fa fa-print" aria-hidden="true"></i> Buat Laporan</button>
                                    </div>
                                </div><br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" style="padding: 0.3rem;" id="dt_kib_c">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-bottom: 25px;">No</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Nama Barang</th>
                                                <th colspan="2">Nomor</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Kondisi<span style="color:red;">*</span></th>
                                                <th colspan="2">Konstruksi Bangunan</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Luas (m2)</th>
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
                        <?= form_open('Print_excel/export_kib_c'); ?>
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
                                            foreach ($dt_c as $d) { ?>
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
                            <button type="submit" class="btn btn-sm btn-primary" name="cetak_c">Cetak</button>
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
            $('#dt_kib_c').dataTable();
        });

        function tampil_data() {
            $.ajax({
                type: "get",
                url: "<?= base_url('LP_kib/lp_get_kib_c') ?>",
                async: false,
                dataType: "json",
                success: function(c) {
                    var kib = "";
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].harga;

                        var reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan = reverse.match(/\d{1,3}/g);
                        ribuan = ribuan.join('.').split('').reverse().join('');

                        if (c[h].bertingkat == 1 && c[h].beton == 1) {
                            bb = "Ya";
                        } else if (c[h].bertingkat == 2 && c[h].beton == 2) {
                            bb = "Tidak";
                        } else {
                            bb = "-";
                        }

                        if (c[h].luas == 0) {
                            luas = "-";
                        } else {
                            luas = c[h].luas;
                        }

                        if (c[h].letak_lokasi == "") {
                            letak_lokasi = "-";
                        }
                        if (c[h].dg_tgl == "0000-00-00") {
                            dg_tgl = "-";
                        }
                        if (c[h].dg_no == "0") {
                            dg_no = "-";
                        }
                        if (c[h].stts_tanah == "") {
                            stts_tanah = "-";
                        }

                        if (c[h].kondisi == 1) {
                            kondisi = "Baik";
                        } else if (c[h].kondisi == 2) {
                            kondisi = "Rusak Ringan";
                        } else if (c[h].kondisi == 3) {
                            kondisi = "Rusak Berat";
                        } else {
                            kondisi = "-";
                        }

                        kib +=
                            '<tr>' +
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td>' + c[h].no_reg + '</td>' +
                            '<td>' + kondisi + '</td>' +
                            '<td>' + bb + '</td>' +
                            '<td>' + bb + '</td>' +
                            '<td>' + luas + '</td>' +
                            '<td>' + c[h].letak_lokasi + '</td>' +
                            '<td>' + dg_tgl + '</td>' +
                            '<td>' + dg_no + '</td>' +
                            '<td>' + stts_tanah + '</td>' +
                            '<td>' + c[h].perolehan + '</td>' +
                            '<td style="text-align: right;">' + ribuan + '</td>' +
                            '<td>' + c[h].no_kd_tanah + '</td>' +
                            '<td>' + c[h].ket + '</td>' +
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