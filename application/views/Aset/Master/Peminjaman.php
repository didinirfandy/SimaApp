<?php
$data['tittle'] = "Data Peminjaman";
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
                    Data Peminjaman
                </h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Data Master</li>
                    <li class="active">Data Peminjaman</li>
                </ol>
            </div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="font-weight:bold;">Data Peminjam</h4>
                                <hr align="right" color="black">
                            </div>
                            <?php $attr = array('id' => 'regfrom');
                            echo form_open('Master_data/data_usulan_pengadaan', $attr); ?>
                            <div class="panel-body">
                                <form>
                                    <div class="form-group">
                                        <label for="nm_peminjaman">Nama Peminjam</label>
                                        <input type="text" class="form-control" name="nm_peminjaman" id="nm_peminjaman" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nohp_peminjaman">Nomor untuk dihubungi</label>
                                        <input type="text" class="form-control" name="nohp_peminjaman" id="nohp_peminjaman" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_peminjaman">Tanggal Pinjam dan Kembali</label>
                                        <div class="input-group input-daterange">
                                            <input type="date" class="form-control" name="tgl_peminjaman" id="tgl_peminjaman" required>
                                            <div class="input-group-addon">to</div>
                                            <input type="date" class="form-control" name="tgl_pengembalian" id="tgl_pengembalian" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_brg" id="id_brg">
                                    <div class="form-group">
                                        <label for="kd_brg">Kode Barang</label>
                                        <input type="text" class="form-control" name="kd_brg" id="kd_brg" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nm_brg">Nama Barang</label>
                                        <input type="text" class="form-control" name="nm_brg" id="nm_brg" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea type="text" rows="2" class="form-control" name="ket" id="ket" placeholder="" required></textarea>
                                    </div>
                                    <br>
                                    <button type="submit" name="submit" id="submit" class="btn btn-sm btn-primary">Simpan</button>&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#data_aset">Cek Data</button>
                                    <input type="hidden" name="kd_peminjaman" value="<?= $kd_peminjaman; ?>">
                                </form>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="font-weight:bold;">Data Aset akan Dipinjam</h4>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <input id="kd_peminjaman" type="hidden" value="<?= $kd_peminjaman;  ?>">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="pinjaman">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peminjam</th>
                                                <th>No HP</th>
                                                <th>Kode Aset</th>
                                                <th>Nama Aset</th>
                                                <th>Action</th>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Data Pengembalian</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="dt_brg">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peminjam</th>
                                                <th>No HP</th>
                                                <th>Kode Aset</th>
                                                <th>Nama Aset</th>
                                                <th>Tanggal Peminjaman</th>
                                                <th>Tanggal Pengembalian</th>
                                                <th>Realisasi Pengembalian</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($get_pinjam as $p) {
                                                if ($p['stts_peminjaman'] == "1") {
                                                    $stts_peminjaman = "Dipinjamkan";
                                                    $warna = "danger";
                                                } else {
                                                    $stts_peminjaman = "Dikembalikan";
                                                    $warna = "success";
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $p['nm_peminjaman']; ?></td>
                                                    <td><?= $p['nohp_peminjaman']; ?></td>
                                                    <td><?= $p['kd_brg']; ?></td>
                                                    <td><?= $p['nm_brg']; ?></td>
                                                    <td><?= $p['tgl_peminjaman']; ?></td>
                                                    <td><?= $p['tgl_pengembalian']; ?></td>
                                                    <td><?= $p['realisasi_pengembalian']; ?></td>
                                                    <td><?= $p['ket']; ?></td>
                                                    <td><button type="button" class="btn btn-xs btn-<?= $warna; ?>" disabled> <?= $stts_peminjaman; ?></button></td>
                                                    <td>
                                                        <?php
                                                        if ($p['stts_peminjaman'] == 1) { ?>
                                                            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#data_kmbl<?= $p['id_peminjaman'] ?>"> Kembalikan</button>
                                                        <?php } else { ?>

                                                        <?php }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>
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
            <!-- Modal -->
            <div class="modal fade" id="data_aset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                            <h4 class="modal-title" id="exampleModalLabel">Daftar Aset dapat Dipinjam</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm" id="tbl_popup">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Aset</th>
                                            <th>No Reg</th>
                                            <th>Nama Aset</th>
                                            <th>Kondisi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tmpl_popup">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <?php
            foreach ($get_pinjam as $p) { ?>
                <div class="modal fade" id="data_kmbl<?= $p['id_peminjaman'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                <h4 class="modal-title" id="exampleModalLabel">Pengembalian Aset</h4>
                            </div>
                            <?= form_open('Master_data/pengembalian'); ?>
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="realisasi_pengembalian">Tanggal Pengembalian</label>
                                        <div class="input-group input-daterange">
                                            <input type="date" class="form-control" name="realisasi_pengembalian" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="kondisi">Kondisi Aset</label><br>
                                        <select class="selectbox col-sm-12" name="kondisi">
                                            <option value="1">Baik</option>
                                            <option value="2">Rusak Ringan</option>
                                            <option value="3">Rusak Berat</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="id_peminjaman" value="<?= $p['id_peminjaman'] ?>">
                                <input type="hidden" name="id_brg" value="<?= $p['id_brg'] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary" name="submit"> Simpan</button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php $this->load->view('template/script') ?>
    <script type="text/javascript">
        $(document).ready(function() {
            tampil_data();
            tampil_popup();

            $('#pinjaman').dataTable();
            $('#tbl_popup').dataTable();
            $('#dt_brg').dataTable();

            $("#regfrom").submit(function() {
                $.ajax({
                    type: "POST",
                    data: $('#regfrom').serialize(),
                    url: "<?= base_url('Master_data/inpt_peminjaman') ?>",
                    dataType: "JSON",
                    success: function(berhasil) {
                        tampil_data();
                        document.getElementById('nm_peminjaman').value = "";
                        document.getElementById('nohp_peminjaman').value = "";
                        document.getElementById('tgl_peminjaman').value = "";
                        document.getElementById('tgl_pengembalian').value = "";
                        document.getElementById('kd_brg').value = "";
                        document.getElementById('nm_brg').value = "";
                        document.getElementById('merk_type').value = "";
                        document.getElementById('ket').value = "";
                    }
                });
                return false;
            });
        });

        document.onkeydown = function(e) {
            switch (e.keyCode) {
                // f2
                case 113:
                    $("#data_aset").modal();
                    break;
                    // esc
                case 27:
                    $("#data_aset").modal("hide");
                    break;
            }
        };

        function tampil_data() {
            var kd_peminjaman = $('#kd_peminjaman').val();
            $.ajax({
                type: "POST",
                data: "kd_peminjaman=" + kd_peminjaman,
                url: "<?= base_url('Master_data/get_dt_peminjaman'); ?>",
                dataType: "JSON",
                success: function(a) {
                    var rows = '';
                    for (var i = 0; i < a.length; i++) {
                        rows += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + a[i].nm_peminjaman + '</td>' +
                            '<td>' + a[i].nohp_peminjaman + '</td>' +
                            '<td>' + a[i].kd_brg + '</td>' +
                            '<td>' + a[i].nm_brg + '</td>' +
                            '<td><button type="button" onclick="delete_peminjaman(\'' + a[i].id_peminjaman + '\')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button></td>' +
                            '</tr>';
                    }
                    $('#tmpl_data').html(rows);
                }
            });
        }

        function delete_peminjaman(id_peminjaman) {
            $.ajax({
                type: "POST",
                data: "id_peminjaman=" + id_peminjaman,
                url: "<?= base_url('Master_data/del_peminjaman'); ?>",
                dataType: "JSON",
                success: function(d) {
                    tampil_data();
                }
            })
        }

        function tampil_popup() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('Master_data/get_dt_pengadaan'); ?>",
                async: false,
                dataType: "JSON",
                success: function(b) {
                    var row = '';
                    for (var i = 0; i < b.length; i++) {
                        if (b[i].kondisi == 1) {
                            kondisi = "Baik"
                        } else if (b[i].kondisi == 2) {
                            kondisi = "Rusak ringan";
                        } else {
                            kondisi = "Rusak Berat";
                        }

                        row += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + b[i].kd_brg + '</td>' +
                            '<td>' + b[i].no_reg + '</td>' +
                            '<td>' + b[i].nm_brg + '</td>' +
                            '<td>' + kondisi + '</td>' +
                            '<td style="text-align: center;"><button type="button" onclick="get(\'' + b[i].id_brg + '\', \'' + b[i].kd_brg + '\', \'' + b[i].nm_brg + '\')" class="btn btn-xs btn-info"><i class="fa fa-plus"></i></button></td>' +
                            '</tr>';
                    }
                    $('#tmpl_popup').html(row);
                }
            });
        }

        function get(id_brg, kd_brg, nm_brg) {
            $("#id_brg").val(id_brg);
            $("#kd_brg").val(kd_brg);
            $("#nm_brg").val(nm_brg);
            $("#data_aset").modal("hide");
            // console.log(kd_brg, nm_brg, merk_type);
        }
    </script>

</body>

</html>