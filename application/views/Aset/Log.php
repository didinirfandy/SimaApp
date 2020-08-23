<?php
$data['tittle'] = "Log";
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
                <h1 class="page-header">
                    Log
                </h1>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li class="active">Log</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="font-weight:bold;">Data Log Pengguna</h4>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="log">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>User</th>
                                                <th>Menu</th>
                                                <th>Tipe Aksi</th>
                                                <th>Keterangan</th>
                                                <th>Tujuan</th>
                                                <th>Aksi</th>
                                                <th>Tanggal</th>
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
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php $this->load->view('template/script') ?>
    <script>
        $(document).ready(function() {
            tampil_data();

            $('#log').dataTable();
        });

        function tampil_data() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('Aset/get_log'); ?>",
                async: false,
                dataType: "JSON",
                success: function(a) {
                    var rows = '';
                    for (var i = 0; i < a.length; i++) {
                        var date = new Date(a[i].log_time);
                        var log_time = ("00" + date.getDate()).slice(-2) + "/" + ("00" + (date.getMonth() + 1)).slice(-2) + "/" + date.getFullYear() + " " +
                            ("00" + date.getHours()).slice(-2) + ":" + ("00" + date.getMinutes()).slice(-2) + ":" + ("00" + date.getSeconds()).slice(-2);
                        rows +=
                            '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + a[i].log_user + '</td>' +
                            '<td>' + a[i].log_menu + '</td>' +
                            '<td>' + a[i].log_aksi + '</td>' +
                            '<td>' + a[i].log_item + '</td>' +
                            '<td>' + a[i].log_assign_to + '</td>' +
                            '<td>' + a[i].log_assign_type + '</td>' +
                            '<td>' + log_time + '</td>' +
                            '</tr>';
                    }
                    $('#tmpl_data').html(rows);
                }
            });
        }
    </script>

</body>

</html>