<?php
$data['tittle'] = "Laporan Usulan Pengadaan";
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
                <h2 class="page-header">Laporan Pemeliharaan</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Laporan</li>
                    <li class="active">Laporan Usulan Pengadaan</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Usulan Pengadaan Aset</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-md-4 mx-sm-3 mb-3">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#caritgl"><i class="fa fa-print" aria-hidden="true"></i> Buat Laporan</button>
                                    </div>
                                </div><br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dt_pel">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Aset</th>
                                                <th>Nama Aset</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
                                                <th>Masa Manfaat</th>
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
                        <?= form_open('Print_excel/export_usul_pengadaan'); ?>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="tgl_awal">Pilih Tanggal</label>
                                    <div class="input-group input-daterange">
                                        <input type="date" class="form-control" name="tgl_awal" id="tgl_awal">
                                        <div class="input-group-addon">to</div>
                                        <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="kategori">Pilih Kategori</label><br>
                                    <select class="selectbox col-md-12" style="width: 267px;" name="kategori" id="kategori" required>
                                        <optgroup label="Pilih Nama Barang">
                                            <option value="all">Semua</option>
                                            <?php
                                            foreach ($dt_usul as $d) { ?>
                                                <option value="<?= $d['kd_usulan'] ?>"><?= $d['ket'] ?></option>
                                            <?php }
                                            ?>
                                        </optgroup>
                                    </select>
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
            tampil_dt();
            $('#dt_pel').dataTable();
        });

        function tampil_dt() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('Laporan/get_usul_pengadaan') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var pgdn = "";
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].harga_brg;

                        var reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan = reverse.match(/\d{1,3}/g);
                        harga_brg = ribuan.join('.').split('').reverse().join('');

                        if (c[h].satuan_brg == 1) {
                            satuan_brg = "Buah";
                        } else if (c[h].satuan_brg == 2) {
                            satuan_brg = "Unit";
                        } else if (c[h].satuan_brg == 3) {
                            satuan_brg = "Set";
                        } else {
                            satuan_brg = "-";
                        }

                        pgdn +=
                            '<tr>' +
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].jmlh_brg + '</td>' +
                            '<td>' + satuan_brg + '</td>' +
                            '<td style="text-align: right;">' + harga_brg + '</td>' +
                            '<td style="text-align: right;">' + c[h].masa_manfaat + '</td>' +
                            '<td>' + c[h].ket + '</td>' +
                            '</tr>';
                    }
                    $('#tmpl_data').html(pgdn);

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