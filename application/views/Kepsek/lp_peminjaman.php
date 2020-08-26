<?php
$data['tittle'] = "Laporan Peminjaman";
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
                <h2 class="page-header">
                    Laporan Peminjaman
                </h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 40, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Laporan</li>
                    <li class="active">Peminjaman</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="font-weight:bold;">Laporan Peminjaman Barang</h4>
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
                                    <table class="table table-striped table-bordered table-hover table-sm" id="lp_peminjaman">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peminjaman</th>
                                                <th>No Hp</th>
                                                <th>Tanggal Peminjaman</th>
                                                <th>Tanggal Pengembalian</th>
                                                <th>Realisasi Pengembalian</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
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
                        <?= form_open('Print_excel/export_peminjaman'); ?>
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
                                        <option value="">-- Pilih --</option>
                                        <option value="all">Semua</option>
                                        <?php
                                        foreach ($pin as $d) { ?>
                                            <option value="<?= $d['kd_brg'] ?>"><?= $d['nm_brg'] ?></option>
                                        <?php }
                                        ?>
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
            tmpl_data();

            $("#lp_peminjaman").dataTable();
        });

        function tmpl_data() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('Laporan/get_dt_peminjaman') ?>",
                async: false,
                dataType: "JSON",
                success: function(a) {
                    var html = "";
                    for (i = 0; i < a.length; i++) {

                        html +=
                            '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + a[i].nm_peminjaman + '</td>' +
                            '<td>' + a[i].nohp_peminjaman + '</td>' +
                            '<td>' + a[i].tgl_peminjaman + '</td>' +
                            '<td>' + a[i].tgl_pengembalian + '</td>' +
                            '<td>' + a[i].realisasi_pengembalian + '</td>' +
                            '<td>' + a[i].kd_brg + '</td>' +
                            '<td>' + a[i].nm_brg + '</td>' +
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