<?php
$data['tittle'] = "Rekomendasi Penghapusan";
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
                    Rekomendasi Penghapusan
                </h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li class="active">Rekomendasi Penghapusan</li>
                </ol>
            </div>
            <!-- Swetalert Berhasil -->
            <div class="status-insert" data-statusinsert="<?= $this->session->flashdata('statusinsert'); ?>"></div>
            <!-- Swetalert Gagal -->
            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Pengajuan Penghapusan</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <?php
                                $kd_brg = array();
                                $nilai_akhir = array();
                                foreach ($matriks_nilai_while as $m) {
                                    $kd_brg[$m['id_brg']]       = $m['kd_brg'];
                                    $no_reg[$m['id_brg']]       = $m['no_reg'];
                                    $nilai_akhir[$m['id_brg']]  = 0;
                                }
                                // print_r($nm_brg);

                                $bobot = array();
                                foreach ($bbt as $b) {
                                    $bobot[$b['id_bobot']]   = $b['bobot'];
                                }
                                // print_r($bobot);
                                ?>
                                <div class="row">
                                    <div class="form-group col-md-4 mx-sm-3 mb-3">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#data_pop"><i class="fa fa-hand-o-right"></i> Pilih data</button>
                                    </div>
                                </div><br>
                                <table class="table table-striped table-bordered table-hover" id="matriks">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Aset</th>
                                            <th>No Reg</th>
                                            <th>Nama Aset</th>
                                            <th>Kondisi</th>
                                            <th>Nilai Buku</th>
                                            <th>Sisa Umr Ekonomis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($matriks_nilai_while as $mn) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $mn['kd_brg']; ?></td>
                                                <td><?= $mn['no_reg']; ?></td>
                                                <td><?= $mn['nm_brg']; ?></td>
                                                <td style="text-align: center;"><?= $mn['kondisi_brg']; ?></td>
                                                <td style="text-align: center;"><?= $mn['nilai_buku']; ?></td>
                                                <td style="text-align: center;"><?= $mn['sisa_umr_ekonomis']; ?></td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="del_data('<?= $mn['id_matriks'] ?>')"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <?= form_open('Penghapusan_aset/insert_rengking'); ?>
                                <?php
                                $i = 1;
                                $hsl = 999;
                                foreach ($matriks_nilai_while as $mn) { ?>
                                    <input type="hidden" name="kd_rengking[]" value="<?= $kd_rangking ?>">
                                    <input type="hidden" name="id_brg[]" value="<?= $mn['id_brg'] ?>">
                                    <input type="hidden" name="kd_brg[]" value="<?= $mn['kd_brg'] ?>">
                                    <input type="hidden" name="no_reg[]" value="<?= $mn['no_reg'] ?>">
                                    <input type="hidden" name="nm_brg[]" value="<?= $mn['nm_brg'] ?>">
                                    <?php
                                    foreach ($minmax as $xn) {
                                        error_reporting(0);
                                        $selisih_kon_brg            = $xn['kon_brgx'] - $xn['kon_brgn'];
                                        $selisih_nil_bk             = $xn['nil_bukux'] - $xn['nil_bukun'];
                                        $selisih_sisa_umr_ekonomis  = $xn['sisa_umr_ekonomisx'] - $xn['sisa_umr_ekonomisn'];

                                        if ($selisih_kon_brg == "0" or $selisih_nil_bk == "0" or $selisih_sisa_umr_ekonomis == "0") {
                                            error_reporting(0);
                                            $msg = "Nilai Selisih Kosong";
                                        } else {
                                            error_reporting(0);
                                            $msg = "";
                                            // $m_nor_nilai_kondisi_brg        = ($mn['kondisi_brg'] - $xn['kon_brgn']) / ($xn['kon_brgx'] - $xn['kon_brgn']);
                                            // $m_nor_nilai_nilai_buku         = ($mn['nilai_buku'] - $xn['nil_bukun']) / ($xn['nil_bukux'] - $xn['nil_bukun']);
                                            // $m_nor_nilai_sisa_umr_ekonomis  = ($mn['sisa_umr_ekonomis'] - $xn['sisa_umr_ekonomisn']) / ($xn['sisa_umr_ekonomisx'] - $xn['sisa_umr_ekonomisn']);

                                            $m_nor_nilai_kondisi_brg        = ($mn['kondisi_brg'] - $xn['kon_brgn']) / ($xn['kon_brgx'] - $xn['kon_brgn']);
                                            $m_nor_nilai_nilai_buku         = ($mn['nilai_buku'] - $xn['nil_bukun']) / ($xn['nil_bukux'] - $xn['nil_bukun']);
                                            $m_nor_nilai_sisa_umr_ekonomis  = ($mn['sisa_umr_ekonomis'] - $xn['sisa_umr_ekonomisn']) / ($xn['sisa_umr_ekonomisx'] - $xn['sisa_umr_ekonomisn']);

                                            $m_krit_bbt_kondisi_brg         = $m_nor_nilai_kondisi_brg * $bobot[1];
                                            $m_krit_bbt_nilai_buku          = $m_nor_nilai_nilai_buku * $bobot[2];
                                            $m_krit_bbt_sisa_umr_ekonomis   = $m_nor_nilai_sisa_umr_ekonomis * $bobot[3];
                                        }

                                        $nilai_akhir[$mn['id_brg']] = $m_krit_bbt_kondisi_brg + $m_krit_bbt_nilai_buku + $m_krit_bbt_sisa_umr_ekonomis;
                                        $hsl = $nilai_akhir[$mn['id_brg']] = $m_krit_bbt_kondisi_brg + $m_krit_bbt_nilai_buku + $m_krit_bbt_sisa_umr_ekonomis;

                                        // print_r($hsl);
                                    ?>
                                    <?php } ?>
                                    <?php
                                    $i++;
                                }

                                reset($nilai_akhir);
                                arsort($nilai_akhir);
                                // print_r($nilai_akhir);

                                $i = 1;
                                foreach ($nilai_akhir as $k => $v) {
                                    if ($k == 0) { ?>
                                        <input type="hidden" name="rangking[]" value="">
                                        <input type="hidden" name="nilai_akhir[]" value="">
                                    <?php } else { ?>
                                        <input type="hidden" name="rangking[]" value="<?= $i++; ?>">
                                        <input type="hidden" name="nilai_akhir[]" value="<?= $nilai_akhir[$k] ?>">
                                    <?php }
                                }

                                if ($selisih_kon_brg == "0" or $selisih_nil_bk == "0" or $selisih_sisa_umr_ekonomis == "0") { ?>
                                    <h4 style="font-weight: bold;">Keterangan :</h4>
                                    (<span style="color:red;">*</span>) : <span style="font-weight: bold;"><?= $msg ?></span>
                                    <hr align="right" color="black">
                                    <div class="footer">
                                        <button class="btn btn-sm btn-info" disabled name="submit" type="submit"><i class="fa fa-fw fa-floppy-o"></i> Proses</button>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea type="text" rows="1" class="form-control" name="ket[]" required></textarea>
                                    </div>
                                    <hr align="right" color="black">
                                    <?php
                                    if ($matriks_nilai_while) { ?>
                                        <div class="footer">
                                            <button class="btn btn-sm btn-info" name="submit" type="submit"><i class="fa fa-fw fa-floppy-o"></i> Proses</button>
                                        </div>
                                    <?php } else { ?>
                                        <div class="footer">
                                            <button class="btn btn-sm btn-info" disabled name="submit" type="submit"><i class="fa fa-fw fa-floppy-o"></i> Proses</button>
                                        </div>
                                <?php }
                                }
                                ?>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Rangking Penghapusan</h3>
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
            <div class="modal fade" id="data_pop" tabindex="-1" role="dialog" aria-labelledby="data_popLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title" id="data_popLabel">Data Pemeliharaan</h5>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="data_nilai">
                                    <thead>
                                        <th>Kode Aset</th>
                                        <th>No Reg</th>
                                        <th>Nama Aset</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($matriks_nilai as $mnw) { ?>
                                            <tr>
                                                <td><?= $mnw['kd_brg']; ?></td>
                                                <td><?= $mnw['no_reg']; ?></td>
                                                <td><?= $mnw['nm_brg']; ?></td>
                                                <td style="text-align: center;">
                                                    <?php if ($mnw['status'] == 1) { ?>
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="in_data('<?= $mnw['id_matriks'] ?>')"><i class="fa fa-plus"></i></button>
                                                    <?php } elseif ($mnw['status'] == 2) { ?>
                                                        <button type="button" class="btn btn-sm btn-warning" disabled><i class="fa fa-circle-o-notch fa-spin"></i></button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-sm btn-success" disabled><i class="fa fa-check"></i></button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

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

            $('#pelihara').dataTable();
            $('#data_nilai').dataTable();
            $('#reng').dataTable();
            $('#detail').dataTable();
            $('#matriks').dataTable();
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

        function in_data(id_matriks) {
            $.ajax({
                type: "POST",
                data: "id_matriks=" + id_matriks,
                url: "<?= base_url('Penghapusan_aset/in_data_m'); ?>",
                dataType: "JSON",
                success: function(a) {
                    if (a == 1) {
                        location.reload();
                        $("#data_pop").modal('show');

                    } else {
                        swal({
                            title: "Proses gagal!!!",
                            type: "error",
                            timer: 2500,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            location.reload()
                        }, 2500);
                    }
                }
            });
        }

        function del_data(id_matriks) {
            $.ajax({
                type: "POST",
                data: "id_matriks=" + id_matriks,
                url: "<?= base_url('Penghapusan_aset/del_data_m'); ?>",
                dataType: "JSON",
                success: function(a) {
                    if (a == 1) {
                        swal({
                            title: "Berhasil!!!",
                            type: "success",
                            timer: 2500,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            location.reload()
                        }, 2500);
                    } else {
                        swal({
                            title: "Gagal!!!",
                            type: "danger",
                            timer: 2500,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            location.reload()
                        }, 2500);
                    }
                }
            });
        }

        const statusinsert = $('.status-insert').data('statusinsert');
        // console.log(statusinsert);
        if (statusinsert) {
            swal({
                text: "Proses " + statusinsert,
                type: "success",
                timer: 2500,
                showConfirmButton: false
            });
        }

        const statusgagal = $('.status-gagal').data('statusgagal');
        // console.log(statusgagal);
        if (statusgagal) {
            swal({
                text: "Proses " + statusgagal,
                type: "error",
                timer: 2500,
                showConfirmButton: false
            });
        }
    </script>
</body>

</html>