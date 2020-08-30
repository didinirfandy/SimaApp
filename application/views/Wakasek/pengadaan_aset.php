<?php
$data['tittle'] = "Pengadaan Aset";
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
                <h2 class="page-header">Pengadaan Aset</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li class="active">Pengadaan Aset</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Usulan Pengadaan</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="usulan_brg_tbl">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Keterangan</th>
                                                <th>Barang Usulan</th>
                                                <th>Tanggal Ditambahkan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="usulan_brg">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Daftar Pengadaan</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="bft_pengadaan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Aset</th>
                                                <th>No Registrasi</th>
                                                <th>Nama Aset</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pgdn">

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
            <div class="modal fade" id="dtl" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Detail aset yang diusulkan</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-bordered table-hover table-sm" id="detail">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Barang Usulan</th>
                                        <th>Jenis Barang</th>
                                        <th>Satuan barang</th>
                                        <th>Jumlah Barang</th>
                                        <th>Harga Barang</th>
                                    </tr>
                                </thead>
                                <tbody id="dtl_brg">
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
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
            tampil_barang_usulan();
            tampil_detail_barang();
            tampil_pengadaan();

            $('#usulan_brg_tbl').dataTable();
            $('#detail').dataTable();
            $('#bft_pengadaan').dataTable();
        })

        function tampil_barang_usulan() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('Pengadaan_aset/get_usulan_group') ?>",
                async: false,
                dataType: "JSON",
                success: function(a) {
                    var html = "";
                    for (i = 0; i < a.length; i++) {
                        setuju = "2";
                        tolak = "3";

                        if (a[i].stts_approval_wk == 1) {
                            aksi1 = "";
                            aksi2 = "display: none;";
                            aksi3 = "display: none;";
                        } else if (a[i].stts_approval_wk == 2) {
                            aksi1 = "display: none;";
                            aksi2 = "";
                            aksi3 = "display: none;";
                        } else if (a[i].stts_approval_wk == 3) {
                            tmbh = "disabled";
                            hps = "success";
                            btl = "";
                            aksi1 = "display: none;";
                            aksi2 = "display: none;";
                            aksi3 = "";
                        } else {
                            aksi1 = "display: none;";
                            aksi2 = "display: none;";
                            aksi3 = "display: none;";
                        }
                        html +=
                            '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + a[i].ket + '</td>' +
                            '<td style="text-align: center;"><button class="btn btn-xs btn-info" onclick="tampil_detail_barang(\'' + a[i].kd_usulan + '\')" data-toggle="modal" data-target="#dtl"><i class="fa fa-info-circle"></i> Detail</button></td>' +
                            '<td>' + a[i].entry_date + '</td>' +
                            '<td style="text-align: center;">' +
                            '<button style="' + aksi1 + '" class="btn btn-xs btn-info" onclick="aksi_usulan_wk(\'' + a[i].kd_usulan + '\', \'' + setuju + '\' )"><i class="fa fa-check"></i> Validasi</button> &nbsp;' +
                            // '<button style="'+ aksi1 +'" class="btn btn-xs btn-danger" onclick="aksi_usulan_wk(\'' + a[i].kd_usulan + '\', \'' + tolak + '\')"><i class="fa fa-times"></i> Tolak</button>' +
                            '<button style="' + aksi2 + '" type="button" class="btn btn-xs btn-success" disabled><i class="fa fa-check"></i> Validasi</button>' +
                            // '<button style="'+ aksi3 +'" type="button" class="btn btn-xs btn-danger" disabled><i class="fa fa-times"></i> Ditolak</button>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#usulan_brg').html(html);
                }
            });
        }

        function aksi_usulan_wk(kd_usulan, stts_approval) {
            $.ajax({
                type: "POST",
                data: {
                    kd_usulan: kd_usulan,
                    stts_approval: stts_approval
                },
                url: "<?= base_url('Pengadaan_aset/aksi_usulan_wk') ?>",
                async: false,
                dataType: "JSON",
                success: function(a) {
                    swal({
                        title: "Berhasil Verifikasi",
                        type: "success",
                        timer: 5000,
                        showConfirmButton: false
                    });
                    location.reload();
                }
            });
        }

        function tampil_detail_barang(kd_usulan) {
            $.ajax({
                type: "POST",
                data: "kd_usulan=" + kd_usulan,
                url: "<?= base_url('Pengadaan_aset/get_dtl_brg') ?>",
                async: false,
                dataType: "JSON",
                success: function(b) {
                    var dtl = "";
                    for (j = 0; j < b.length; j++) {
                        var bilangan = b[j].harga_brg

                        var reverse = bilangan.toString().split('').reverse().join(''),
                            harga_brg = reverse.match(/\d{1,3}/g);
                        harga_brg = harga_brg.join('.').split('').reverse().join('');

                        if (b[j].jns_brg == 1) {
                            jenis = "KIB A";
                        } else if (b[j].jns_brg == 2) {
                            jenis = "KIB B";
                        } else if (b[j].jns_brg == 3) {
                            jenis = "KIB C";
                        } else if (b[j].jns_brg == 4) {
                            jenis = "KIB D";
                        } else if (b[j].jns_brg == 5) {
                            jenis = "KIB E";
                        } else {
                            jenis = "-";
                        }

                        if (b[j].satuan_brg == 1) {
                            satuan = "Buah";
                        } else if (b[j].satuan_brg == 2) {
                            satuan = "Unit";
                        } else if (b[j].satuan_brg == 3) {
                            satuan = "Set";
                        } else {
                            satuan = "-";
                        }

                        dtl +=
                            '<tr>' +
                            '<td>' + (j + 1) + '</td>' +
                            '<td>' + b[j].nm_brg + '</td>' +
                            '<td>' + jenis + '</td>' +
                            '<td>' + satuan + '</td>' +
                            '<td style="text-align: right;">' + b[j].jmlh_brg + '</td>' +
                            '<td style="text-align: right;">' + harga_brg + '</td>' +
                            '</tr>';
                    }
                    $('#dtl_brg').html(dtl);
                }
            });
        }

        function tampil_pengadaan() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('Pengadaan_aset/get_pengadaan') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var pgdn = "";
                    for (h = 0; h < c.length; h++) {
                        if (c[h].nli_sisa != "") {
                            var bilangan = c[h].nli_sisa;

                            var reverse = bilangan.toString().split('').reverse().join(''),
                                ribuan = reverse.match(/\d{1,3}/g);
                            ribuan = ribuan.join('.').split('').reverse().join('');
                        } else {
                            ribuan = "";
                        }

                        pgdn +=
                            '<tr>' +
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td style="text-align: center;">' + c[h].no_reg + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td style="text-align: right;">' + c[h].umr_ekonomis + '</td>' +
                            '<td style="text-align: right;">' + ribuan + '</td>' +
                            '</tr>';
                    }
                    $('#pgdn').html(pgdn);
                }
            });
        }
    </script>

</body>

</html>