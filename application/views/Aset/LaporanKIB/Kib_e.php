<?php
$data['tittle'] = "Laporan KIB E";
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
                <h3 class="page-header">LAPORAN KARTU INVENTARIS BARANG ASET TETAP LAINNYA ( KIB E )</h3>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Laporan</li>
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
                            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-md-4 mx-sm-3 mb-3">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caritgl"><i class="fa fa-print" aria-hidden="true"></i> Buat Laporan</button>
                                    </div>
                                </div><br>
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
            <!-- Modal -->
            <div class="modal fade" id="caritgl" tabindex="-1" role="dialog" aria-labelledby="caritgl" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title" id="caritgl">Filter Laporan</h5>
                        </div>
                        <?= form_open('Print_excel/export_kib_e'); ?>
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
                                            foreach ($dt_e as $d) { ?>
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
                            <button type="submit" class="btn btn-sm btn-primary" name="cetak_e">Cetak</button>
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
            disply_kib_e();
            $('#dt_kib_e').dataTable();
        })

        function disply_kib_e() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('Kib/get_kib_e') ?>",
                async: false,
                dataType: "json",
                success: function(c) {
                    var kib_e = "";

                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].harga;

                        var reverse = bilangan.toString().split('').reverse().join(''),
                            harga = reverse.match(/\d{1,3}/g);
                        harga = harga.join('.').split('').reverse().join('');

                        if (c[h].bp_s == "") {
                            bp_s = "-";
                        }
                        if (c[h].bbkk_ad == "") {
                            bbkk_ad = "-";
                        }
                        if (c[h].bbkk_b == "") {
                            bbkk_b = "-";
                        }
                        if (c[h].htt_j == "") {
                            htt_j = "-";
                        }
                        if (c[h].htt_u == "") {
                            htt_u = "-";
                        }
                        if (c[h].jmlh_brg == "0") {
                            jmlh_brg = "-";
                        }

                        kib_e +=
                            '<tr>' +
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td style="text-align: right;">' + c[h].no_reg + '</td>' +
                            '<td>' + c[h].bp_jp + '</td>' +
                            '<td>' + bp_s + '</td>' +
                            '<td>' + bbkk_ad + '</td>' +
                            '<td>' + c[h].bbkk_p + '</td>' +
                            '<td>' + bbkk_b + '</td>' +
                            '<td>' + htt_j + '</td>' +
                            '<td>' + htt_u + '</td>' +
                            '<td>' + jmlh_brg + '</td>' +
                            '<td>' + c[h].thn_beli + '</td>' +
                            '<td>' + c[h].perolehan + '</td>' +
                            '<td style="text-align: right;">' + harga + '</td>' +
                            '</tr>';
                    }
                    $('#kib_e').html(kib_e);
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