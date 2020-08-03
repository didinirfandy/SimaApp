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
                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
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
                                    <div class="form-group">
                                        <label for="kd_brg">Kode Barang</label>
                                        <input type="text" class="form-control" name="kd_brg" id="kd_brg" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nm_brg">Nama Barang</label>
                                        <input type="text" class="form-control" name="nm_brg" id="nm_brg" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="merk_type">Merek/Type</label>
                                        <input type="text" class="form-control" name="merk_type" id="merk_type" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea type="text" rows="2" class="form-control" name="ket" id="ket" placeholder="" required></textarea>
                                    </div>
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#data_aset">Cek Data</button>
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
                                                <th>Merek/Type</th>
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
                                <table class="table table-striped table-bordered table-hover table-sm" id="brg_pinjam">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Aset</th>
                                            <th>Nama Aset</th>
                                            <th>Merek/Type</th>
                                            <th>Status</th>
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
            $('#brg_pinjam').dataTable();

            $("#regfrom").submit(function() {
                $.ajax({
                    type: "POST",
                    data: $('#regfrom').serialize(),
                    url: "<?= base_url('Master_data/inpt_peminjaman') ?>",
                    dataType: "JSON",
                    success: function(berhasil) {
                        if (berhasil == "1") {
                            swal({
                                title: "Simpan Berhasil",
                                type: "success",
                                timer: 5000,
                                showConfirmButton: false
                            }); 
                        } else {
                            swal({
                                title: "Simpan Gagal",
                                type: "error",
                                timer: 5000,
                                showConfirmButton: false
                            });
                        }
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
                type: "ajax",
                data: "kd_peminjaman=" + kd_peminjaman,
                url: "<?= base_url('Master_data/get_dt_peminjaman'); ?>",
                async: false,
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
                                    '<td>' + a[i].merk_type + '</td>' +
                                    '<td><button type="button" onclick="delete_peminjaman(\'' + a[i].id_peminjaman + '\')" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>' +
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
                        if (b[i].kondisi == "1") {
                            kondisi = "Rusak ringan";
                        } else {
                            kondisi = "Rusak Berat";
                        }

                        row += '<tr>' + 
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' + b[i].kd_brg + '</td>' +
                                    '<td>' + b[i].nm_brg + '</td>' +
                                    '<td>' + b[i].merk_type + '</td>' +
                                    '<td>' + kondisi + '</td>' +
                                    '<td><button type="button" onclick="get(\'' + b[i].kd_brg + '\', \''+ b[i].nm_brg +'\', \''+ b[i].merk_type +'\')" class="btn btn-info"><i class="fa fa-plus"></i></button></td>' +
                                '</tr>';
                    }
                    $('#tmpl_popup').html(row);
                }
            });
        }

        function get(kd_brg, nm_brg, merk_type) {
            $("#kd_brg").val(kd_brg);
            $("#nm_brg").val(nm_brg);
            $("#merk_type").val(merk_type);
            $("#data_aset").modal("hide");
            // console.log(kd_brg, nm_brg, merk_type);
        }

        
    </script>

</body>

</html>