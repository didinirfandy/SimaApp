<?php
$data['tittle'] = "Laporan KIB A";
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
                <h3 class="page-header">LAPORAN KARTU INVENTARIS BARANG TANAH ( KIB A )</h3>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Laporan</li>
                    <li class="active">KIB A</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <!-- <h4 style="font-weight:bold;">Data Kartu Inventaris Barang Tanah</h4> -->
                            </div>
                            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-md-4 mx-sm-3 mb-3">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caritgl"><i class="fa fa-print" aria-hidden="true"></i> Buat Laporan</button>
                                    </div>
                                </div><br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="dt_kib_a">
                                        <thead>
                                            <tr>
                                                <th rowspan="3" style="padding-bottom: 45px;">No</th>
                                                <th rowspan="3" style="padding-bottom: 45px;">Nama Barang</th>
                                                <th colspan="2">Nomor</th>
                                                <th rowspan="3" style="padding-bottom: 45px;">Luas (M2)</th>
                                                <th rowspan="3" style="padding-bottom: 45px;">Tahun Pengadaan</th>
                                                <th colspan="3">Status Tanah</th>
                                                <th rowspan="3" style="padding-bottom: 45px;">Asal-Usul</th>
                                                <th rowspan="3" style="padding-bottom: 45px;">Harga</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" style="padding-bottom: 20px;">Kode barang</th>
                                                <th rowspan="2" style="padding-bottom: 20px;">No Register</th>
                                                <th rowspan="2" style="padding-bottom: 20px;">Hak</th>
                                                <th colspan="2">Sertifikat</th>
                                            </tr>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nomor</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kib_a">
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
                        <?= form_open('Print_excel/export_kib_a'); ?>
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
                                            foreach ($dt_a as $d) { ?>
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
                            <button type="submit" class="btn btn-sm btn-primary" name="cetak_a">Cetak</button>
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
            disply_kib_a();

            $('#dt_kib_a').dataTable();
        })

        function disply_kib_a() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('LP_kib/lp_get_kib_a') ?>",
                async: false,
                dataType: "json",
                success: function(c) {
                    var kib_a = "";

                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].harga;

                        var reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan = reverse.match(/\d{1,3}/g);
                        ribuan = ribuan.join('.').split('').reverse().join('');

                        if (c[h].luas == 0) {
                            luas = "-";
                        } else {
                            luas = c[h].luas;
                        }
                        if (c[h].st_stfkt_tgl == "0000-00-00") {
                            st_stfkt_tgl = "-";
                        } else {
                            st_stfkt_tgl = c[h].st_stfkt_tgl
                        }
                        if (c[h].thn_pengadaan == "0000-00-00") {
                            thn_pengadaan = "-";
                        } else {
                            thn_pengadaan = c[h].thn_pengadaan
                        }

                        kib_a +=
                            '<tr>' +
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td style="text-align: right;">' + c[h].no_reg + '</td>' +
                            '<td style="text-align: right;">' + luas + '</td>' +
                            '<td>' + thn_pengadaan + '</td>' +
                            '<td>' + c[h].st_hak + '</td>' +
                            '<td>' + st_stfkt_tgl + '</td>' +
                            '<td>' + c[h].st_stfkt_no + '</td>' +
                            '<td>' + c[h].perolehan + '</td>' +
                            '<td style="text-align: right;">' + ribuan + '</td>' +

                            '</tr>';
                    }
                    $('#kib_a').html(kib_a);
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