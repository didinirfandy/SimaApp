<?php
$data['tittle'] = "Penghapusan Aset";
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
                <h2 class="page-header">Penghapusan Aset</h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li class="active">Penghapusan Aset</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Rengking</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="reng">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Keterangan</th>
                                            <th>Rangking</th>
                                            <th>Tanggal Ditambahkan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tmpl_reng">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
                <?php $this->load->view('template/copyright') ?>
            </div>
            <!-- /. PAGE INNER  -->
            <!-- Modal -->
            <div class="modal fade" id="dtl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Detail Rekomendasi Penghapusan</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm" id="detail">
                                    <thead>
                                        <tr>
                                            <th>Rengking</th>
                                            <th>Kode Aset</th>
                                            <th>No Reg</th>
                                            <th>Nama Aset</th>
                                            <th>Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dtl_brg">
                                    </tbody>
                                </table>
                                <h4 style="font-weight: bold;">Keterangan :</h4>
                                (<span style="color:red;">*</span>) : <span style="font-weight: bold;">Semakin tinggi rengkingnya semakin di rekomendasikan untuk dilakukan penghapusan</span>
                            </div>
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
            tampil_rangking();
            $('#reng').dataTable();
        });

        function tampil_rangking() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('Penghapusan_aset/get_rengking') ?>",
                async: false,
                dataType: "JSON",
                success: function(a) {
                    var html = "";
                    for (i = 0; i < a.length; i++) {
                        var date = new Date(a[i].entry_date);
                        var entry_date = ("00" + date.getDate()).slice(-2) + "/" + ("00" + (date.getMonth() + 1)).slice(-2) + "/" + date.getFullYear() + " " +
                            ("00" + date.getHours()).slice(-2) + ":" + ("00" + date.getMinutes()).slice(-2) + ":" + ("00" + date.getSeconds()).slice(-2);

                        html +=
                            '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + a[i].ket + '</td>' +
                            '<td style="text-align: center;"><button class="btn btn-xs btn-info" onclick="tampil_detail_rangking(' + a[i].kd_rengking + ')" data-toggle="modal" data-target="#dtl"><i class="fa fa-info-circle"></i> Detail</button></td>' +
                            '<td style="text-align: center;">' + entry_date + '</td>' +
                            '</tr>';
                    }
                    $('#tmpl_reng').html(html);
                }
            });
        }

        function tampil_detail_rangking(kd_rengking) {
            $.ajax({
                type: "POST",
                data: "kd_rengking=" + kd_rengking,
                url: "<?= base_url('Penghapusan_aset/get_data_m_kd') ?>",
                async: false,
                dataType: "JSON",
                success: function(b) {
                    var dtl = "";
                    for (j = 0; j < b.length; j++) {
                        dtl +=
                            '<tr>' +
                            '<td style="text-align: center;">' + b[j].rangking + '</td>' +
                            '<td>' + b[j].kd_brg + '</td>' +
                            '<td>' + b[j].no_reg + '</td>' +
                            '<td>' + b[j].nm_brg + '</td>' +
                            '<td style="text-align: center;">' + b[j].nilai_akhir + '</td>' +
                            '</tr>';
                    }
                    $('#dtl_brg').html(dtl);
                }
            });
        }
    </script>

</body>

</html>