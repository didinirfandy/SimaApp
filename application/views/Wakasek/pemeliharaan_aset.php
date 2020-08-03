<?php
	$data['tittle'] = "Pemeliharaan Aset";
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
                    Pemeliharaan Aset
                </h1>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li class="active">Pemeliharaan Aset</li>
                </ol> 
            </div>
            
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Pemeliharaan Aset</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="plihara">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Aset</th>
                                                <th>No Reg</th>
                                                <th>Nama Aset</th>
                                                <th>Merek/Type</th>
                                                <th>Kondisi</th>
                                                <th>Harga</th>
                                                <th>Tahun Beli</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Sisa Umr Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                                <th>Nilai Buku</th>
                                                <th>Keterangan</th>
                                                <th>Jenis Pemeliharaan</th>
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
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Pemeliharaan Aset Internal</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="internal">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Aset</th>
                                                <th>No Reg</th>
                                                <th>Nama Aset</th>
                                                <th>Merek/Type</th>
                                                <th>Kondisi</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dt_internal">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Pemeliharaan Aset External</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="external">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Aset</th>
                                                <th>No Reg</th>
                                                <th>Nama Aset</th>
                                                <th>Merek/Type</th>
                                                <th>Kondisi</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dt_external">
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
    <script type="text/javascript">
        $(document).ready(function() {
            tampil_pengadaan();
            tampil_internal();
            tampil_external();

            $('#plihara').dataTable();
            $('#internal').dataTable();
            $('#external').dataTable();
        })

        function tampil_pengadaan() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('Pemeliharaan_aset/get_data_pelihara') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var pgdn = "";
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].nli_sisa;
                            
                        var	reverse  = bilangan.toString().split('').reverse().join(''),
                            ribuan 	 = reverse.match(/\d{1,3}/g);
                            nli_sisa = ribuan.join('.').split('').reverse().join('');

                        var bil = c[h].harga;
                        
                        var	reverse = bil.toString().split('').reverse().join(''),
                            ribuan 	= reverse.match(/\d{1,3}/g);
                            harga	= ribuan.join('.').split('').reverse().join('');

                        var nilai_n         = (c[h].harga - c[h].nli_sisa) / c[h].umr_ekonomis;
                        var dateMonth = new Date();
                        var nilai_buku_bln  = Math.ceil(nilai_n / 12 * dateMonth.getMonth() + 1);
                        var	reverse         = nilai_buku_bln.toString().split('').reverse().join(''),
                            ribuan_bln      = reverse.match(/\d{1,3}/g);
                            buku_bulat_bln  = ribuan_bln.join('.').split('').reverse().join('');
                        var sisa_umr_ekonomis = c[h].sisa_umr_ekonomis;

                        internal  = "2";
                        eksternal = "3";

                        if (c[h].stts_approval == 1) {
                            tmbh = "";
                            hps = "info";
                            btl = "";
                            aksi1 = "";
                            aksi2 = "display: none;";
                            aksi3 = "display: none;";
                        } else if (c[h].stts_approval == 2) {
                            tmbh = "disabled";
                            hps = "success";
                            btl = "";
                            aksi1 = "display: none;";
                            aksi2 = "";
                            aksi3 = "display: none;";
                        } else if(c[h].stts_approval == 3) {
                            tmbh = "disabled";
                            hps = "success";
                            btl = "";
                            aksi1 = "display: none;";
                            aksi2 = "";
                            aksi3 = "display: none;";
                        } else if(c[h].stts_approval == 4) {
                            tmbh = "disabled";
                            hps = "success";
                            btl = "disabled";
                            aksi1 = "display: none;";
                            aksi2 = "display: none;";
                            aksi3 = "";
                        } else if(c[h].stts_approval == 5) {
                            tmbh = "disabled";
                            hps = "success";
                            btl = "disabled";
                            aksi1 = "display: none;";
                            aksi2 = "display: none;";
                            aksi3 = "";
                        } else {
                            btl = "disabled";
                            tmbh = "";
                            hps = "primary";
                            aksi1 = "display: none;";
                            aksi2 = "display: none;";
                            aksi3 = "display: none;";
                        }

                        if (c[h].kondisi_brg == 1) {
                            kondisi_brg = "baik";
                        } else if (c[h].kondisi_brg == 2) {
                            kondisi_brg = "Rusak Ringan";
                        } else if(c[h].kondisi_brg == 3) {
                            kondisi_brg = "Rusak Berat";
                        } else {
                            kondisi_brg = "-";
                        }

                        pgdn +=
                            '<tr>' + 
                                '<td>' + (h + 1) + '</td>' +
                                '<td>' + c[h].kd_brg + '</td>' +
                                '<td style="text-align: center;">' + c[h].no_reg + '</td>' +
                                '<td>' + c[h].nm_brg + '</td>' +
                                '<td>' + c[h].merk_type + '</td>' +
                                '<td>' + kondisi_brg + '</td>' +
                                '<td style="text-align: right;">' + harga + '</td>' +
                                '<td style="text-align: right;">' + c[h].thn_beli + '</td>' +
                                '<td style="text-align: right;">' + c[h].umr_ekonomis + '</td>' +
                                '<td style="text-align: right;">' + sisa_umr_ekonomis + '</td>' +
                                '<td style="text-align: right;">' + nli_sisa + '</td>' +
                                '<td style="text-align: right;">' + buku_bulat_bln + '</td>' +
                                '<td>' + c[h].ket + '</td>' +
                                '<td style="text-align: center;">' + 
                                '<button style="'+ aksi3 +'" type="button" class="btn btn-sm btn-success" disabled><i class="fa fa-check"></i> Selesai</button>' +
                                '<button style="'+ aksi1 +'" type="submit" '+ tmbh +' title="Internal" onclick="set_pelihara(\'' + c[h].id_pemeliharaan + '\', \'' + c[h].id_brg + '\', \'' + internal + '\', \'' + nilai_buku_bln + '\', \'' + sisa_umr_ekonomis + '\')" class="btn btn-sm btn-'+ hps +'"><i class="fa fa-level-down"></i> Internal</button> &nbsp;'+
                                '<button style="'+ aksi1 +'" type="submit" '+ tmbh +' title="Eksternal" onclick="set_pelihara(\'' + c[h].id_pemeliharaan + '\', \'' + c[h].id_brg + '\', \'' + eksternal + '\', \'' + nilai_buku_bln + '\', \'' + sisa_umr_ekonomis + '\')" class="btn btn-sm btn-'+ hps +'"><i class="fa fa-level-up"></i> Eksternal</button>'+
                                '<button style="'+ aksi2 +'"type="submit" '+ btl +' title="Batal" onclick="set_pelihara_batal(\'' + c[h].id_pemeliharaan + '\', \'' + c[h].id_brg + '\')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Batal</button>'+
                                '</td>' +
                            '</tr>';
                    }
                    $('#tmpl_data').html(pgdn);
                    
                }
            });
        }

        function set_pelihara(id_pemeliharaan, id_brg, stts_approval, nilai_buku_bln, sisa_umr_ekonomis) {
            $.ajax({
                type: "POST",
                data: { id_pemeliharaan:id_pemeliharaan, id_brg:id_brg, stts_approval:stts_approval, nilai_buku_bln:nilai_buku_bln ,sisa_umr_ekonomis:sisa_umr_ekonomis },
                url: "<?= base_url('Pemeliharaan_aset/set_pelihara') ?>",
                async: false,
                dataType: "JSON",
                success: function(a) {
                    if (stts_approval == 2) {
                        stts = "Internal";
                    } else if(stts_approval == 3) {
                        stts = "External";
                    } else {
                        stts = "-";
                    }
                    swal({
                        text: "Berhasil Menyetujui Pemeliharaan "+ stts +" !!!",
                        icon: "success",
                        timer: 2500,
                        showConfirmButton: false
                    })
                    // location.reload();
                    setTimeout(function(){location.reload()}, 2500);
                }
            });
        }

        function set_pelihara_batal(id_pemeliharaan, id_brg) {
            $.ajax({
                type: "POST",
                data: { id_pemeliharaan:id_pemeliharaan, id_brg:id_brg },
                url: "<?= base_url('Pemeliharaan_aset/set_pelihara_batal') ?>",
                async: false,
                dataType: "JSON",
                success: function(a) {
                    swal({
                        text: "Berhasil ditolak!",
                        icon: "success",
                        timer: 5000,
                        showConfirmButton: false
                    })
                    location.reload();
                }
            });
        }

        function tampil_internal() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('Pemeliharaan_aset/get_pelihara_aset_internal') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var pgdn = "";
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].nli_sisa;
                            
                        var	reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan 	= reverse.match(/\d{1,3}/g);
                            ribuan	= ribuan.join('.').split('').reverse().join('');

                        if (c[h].stts_approval == 4) {
                            text = "Selesai";
                            stts = "success";
                            icon = "check";
                        } else {
                            text = "Proses";
                            stts = "info";
                            icon = "cog";
                        }

                        if (c[h].kondisi_brg == 2) {
                            kondisi_brg = "Rusak Ringan";
                        } else if(c[h].kondisi_brg == 3){
                            kondisi_brg = "Rusak Berat";
                        } else {
                            kondisi_brg = "Baik";
                        }

                        pgdn +=
                            '<tr>' + 
                                '<td>' + (h + 1) + '</td>' +
                                '<td>' + c[h].kd_brg + '</td>' +
                                '<td style="text-align: center;">' + c[h].no_reg + '</td>' +
                                '<td>' + c[h].nm_brg + '</td>' +
                                '<td>' + c[h].merk_type + '</td>' +
                                '<td>' + kondisi_brg + '</td>' +
                                '<td style="text-align: right;">' + c[h].umr_ekonomis + '</td>' +
                                '<td style="text-align: right;">' + ribuan + '</td>' +
                                '<td style="text-align: center;"><button type="button" disabled title="Selesai" class="btn btn-sm btn-'+stts+'"><i class="fa fa-'+icon+'"></i> '+text+'</button></td>' +
                            '</tr>';
                    }
                    $('#dt_internal').html(pgdn);
                    
                }
            });
        }

        function tampil_external() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('Pemeliharaan_aset/get_pelihara_aset_external') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var pgdn = "";
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].nli_sisa;
                            
                        var	reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan 	= reverse.match(/\d{1,3}/g);
                            ribuan	= ribuan.join('.').split('').reverse().join('');

                        if (c[h].stts_approval == 5) {
                            text = "Selesai";
                            stts = "success";
                            icon = "check";
                        } else {
                            text = "Proses";
                            stts = "info";
                            icon = "cog";
                        }

                        if (c[h].kondisi_brg == 2) {
                            kondisi_brg = "Rusak Ringan";
                        } else if(c[h].kondisi_brg == 3){
                            kondisi_brg = "Rusak Berat";
                        } else {
                            kondisi_brg = "Baik";
                        }

                        pgdn +=
                            '<tr>' + 
                                '<td>' + (h + 1) + '</td>' +
                                '<td>' + c[h].kd_brg + '</td>' +
                                '<td style="text-align: center;">' + c[h].no_reg + '</td>' +
                                '<td>' + c[h].nm_brg + '</td>' +
                                '<td>' + c[h].merk_type + '</td>' +
                                '<td>' + kondisi_brg + '</td>' +
                                '<td style="text-align: right;">' + c[h].umr_ekonomis + '</td>' +
                                '<td style="text-align: right;">' + ribuan + '</td>' +
                                '<td style="text-align: right;"><button type="button" disabled title="Selesai" class="btn btn-sm btn-'+stts+'"><i class="fa fa-'+icon+'"></i> '+text+'</button></td>' +
                            '</tr>';
                    }
                    $('#dt_external').html(pgdn);
                    
                }
            });
        }
    </script>

</body>

</html>