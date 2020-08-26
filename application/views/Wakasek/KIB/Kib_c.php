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
                <h3 class="page-header">KARTU INVENTARIS BARANG GEDUNG DAN BANGUNAN ( KIB C )</h3>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?= base_url() ?>Aset/home">Home</a></li>
                    <li>Daftar Aset</li>
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
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" style="padding: 0.3rem;" id="dt_kib_c">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="padding-bottom: 25px;">No</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Nama Barang</th>
                                                <th colspan="2">Nomor</th>
                                                <th rowspan="2" style="padding-bottom: 25px;">Kondisi</th>
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
                                        <tbody>
                                            <?php
                                            if (is_array($kib_c)) {
                                                $i = 1;
                                                foreach ($kib_c as $c) {
                                                    $harga = number_format("$c[harga]", 2, ",", ".");

                                                    if ($c['kondisi'] == 1) {
                                                        $kondisi = "Baik";
                                                    } elseif ($c['kondisi'] == 2) {
                                                        $kondisi = "Rusak Ringan";
                                                    } elseif ($c['kondisi'] == 3) {
                                                        $kondisi = "Rusak Berat";
                                                    } else {
                                                        $kondisi = "-";
                                                    }

                                                    if ($c['bertingkat'] == 1 && $c['beton'] == 1) {
                                                        $bb = "Ya";
                                                    } else if ($c['bertingkat'] == 2 && $c['beton'] == 2) {
                                                        $bb = "Tidak";
                                                    } else {
                                                        $bb = "-";
                                                    }

                                                    if ($c['letak_lokasi'] == "") {
                                                        $letak_lokasi = "-";
                                                    }
                                                    if ($c['dg_tgl'] == "0000-00-00") {
                                                        $dg_tgl = "-";
                                                    }
                                                    if ($c['dg_no'] == "0") {
                                                        $dg_no = "-";
                                                    }
                                                    if ($c['stts_tanah'] == "" or $c['stts_tanah'] == "-") {
                                                        $stts_tanah = "-";
                                                    }

                                                    echo "<tr data-id='$c[id_brg]'>
                                                                <td>$i</td>
                                                                <td>$c[nm_brg]</td>
                                                                <td>$c[kd_brg]</td>
                                                                <td>$c[no_reg]</td>
                                                                <td>$kondisi</td>
                                                                <td>$bb</td>
                                                                <td>$bb</td>
                                                                <td>$c[luas]</td>
                                                                <td>$c[letak_lokasi]</td>
                                                                <td>$dg_tgl</td>
                                                                <td>$dg_no</td>
                                                                <td>$stts_tanah</td>
                                                                <td>$c[perolehan]</td>
                                                                <td style='text-align: right;'>$harga</td>
                                                                <td>$c[no_kd_tanah]</td>
                                                                <td>$c[ket]</td>
                                                            </tr>";
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <h4 style="font-weight: bold;">Keterangan :</h4>
                                (<span style="color:red;">*</span>) : <span style="font-weight: bold;">Inputkan Angka: 1 (Baik), 2 (Rusak Ringan), 3 (Rusak Berat)</span>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dt_kib_c').dataTable();
        })

        $(function() {
            $.ajaxSetup({
                type: "post",
                cache: false,
                dataType: "json"
            })

            $(document).on("click", "td", function() {
                $(this).find("span[class ~='caption']").hide();
                $(this).find("input[class ~='editor']").fadeIn().focus();
            });

            $(document).on("keydown", ".editor", function(e) {
                if (e.keyCode == 13) {
                    var target = $(e.target);
                    var value = target.val();
                    var id = target.attr("data-id");
                    var data = {
                        id: id,
                        value: value
                    };

                    if (target.is(".field-kondisi")) {
                        data.modul = "kondisi";
                    }

                    $.ajax({
                        data: data,
                        url: "<?= base_url('Kib/uptd_kib_c'); ?>",
                        success: function(a) {
                            target.hide();
                            target.siblings("span[class~='caption']").html(value).fadeIn();
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>