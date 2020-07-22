<?php
	$data['tittle'] = "Data Pengadaan";
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
                    Data Pengadaan
                </h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li>Data Master</li>
                    <li class="active">Data Pengadaan</li>
                </ol> 
            </div>
            
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default"><br>
                            <?php $attr = array('id' => 'regfrom');
                                echo form_open('Master_data/int_pengadaan', $attr); ?>
                            <?= $this->session->userdata('status_insert'); ?>
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 style="font-weight:bold;">Penamaan Aset</h4>
                                        <!-- <hr align="right" color="black"> -->
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="kd_brg">Kode Aset</label>
                                            <input type="text" class="form-control" name="kd_brg" id="kd_brg" >
                                        </div>
                                        <div class="form-group">
                                            <label for="nm_brg">Nama Aset</label>
                                            <input type="text" class="form-control" name="nm_brg" id="nm_brg" >
                                        </div>
                                        <div class="form-group">
                                            <label for="no_reg">No Registrasi</label>
                                            <input type="text" class="form-control" name="no_reg" id="no_reg" >
                                        </div>
                                        <div class="form-group">
                                            <label for="jmlh_brg">Jumlah Aset</label>
                                            <input type="text" class="form-control" name="jmlh_brg" id="jmlh_brg" >
                                        </div>
                                    </div>						
                                </div>   
                            </div>		
                                
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 style="font-weight:bold;">Keterangan Aset</h4>
                                        <!-- <hr align="right" color="black"> -->
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="merk_type">Merek/Type</label>
                                            <input type="text" class="form-control" name="merk_type" id="merk_type" >
                                        </div>
                                        <div class="form-group">
                                            <label for="ukuran_cc">Ukuran/CC</label>
                                            <input type="text" class="form-control" name="ukuran_cc" id="ukuran_cc" >
                                        </div>
                                        <div class="form-group">
                                            <label for="bahan">Bahan</label>
                                            <input type="text" class="form-control" name="bahan" id="bahan" >
                                        </div>
                                        <div class="form-group">
                                            <label for="perolehan">Perolehan</label>
                                            <input type="text" class="form-control" name="perolehan" id="perolehan" >
                                        </div>
                                        <div class="form-group">
                                            <label for="kondisi">Kondisi Aset</label>
                                            <select class="selectbox col-sm-12" name="kondisi" id="kondisi">
                                                <option value="">-- Pilih --</option>
                                                <option value="1">BAIK</option>
                                                <option value="2">TIDAK BAIK</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="dipinjam" name="dipinjam">
                                                <label class="form-check-label" for="dipinjam">Dapat dipinjam</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 style="font-weight:bold;">Pembelian Aset</h4>
                                        <!-- <hr align="right" color="black"> -->
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="harga">Harga Pembelian</label>
                                            <input type="text" class="form-control" name="harga" id="harga" >
                                        </div>
                                        <div class="form-group">
                                            <label for="thn_beli">Tahun Pembelian</label>
                                            <input type="text" class="form-control" name="thn_beli" id="thn_beli" >
                                        </div>
                                        <div class="form-group">
                                            <label for="umr_ekonomis">Umur Ekonomis</label>
                                            <input type="text" class="form-control" name="umr_ekonomis" id="umr_ekonomis" >
                                        </div>
                                        <div class="form-group">
                                            <label for="nli_sisa">Nilai Sisa</label>
                                            <input type="text" class="form-control" name="nli_sisa" id="nli_sisa" >
                                        </div>
                                        <div class="form-group">
                                            <label for="ket">Keterangan</label>
                                            <textarea type="text" rows="2" class="form-control" name="ket" id="ket" ></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="penyusutan" name="penyusutan">
                                                <label class="form-check-label" for="penyusutan">Mengalami Penyusutan Aset</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div style="padding: 20px;">
                                <button type="submit" name="submit" id="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cek_data">Cek Data</button><br><br>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
				<?php $this->load->view('template/copyright') ?>
            </div>

            <!-- Modal data -->
            <div class="modal fade" id="cek_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm" id="brg_tbl">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Aset</th>
                                            <th>Nama Aset</th>
                                            <th>No Registrasi</th>
                                            <th>Umur Ekonomis</th>
                                            <th>Nilai Sisa</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pgdn">

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
            tampil_pengadaan();

            $("#regfrom").submit(function() {
                $.ajax({
                    type: "POST",
                    data: $('#regfrom').serialize(),
                    url: "<?= base_url('Master_data/int_pengadaan') ?>",
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
                        document.getElementById('kd_brg').value = "";
                        document.getElementById('nm_brg').value = "";
                        document.getElementById('no_reg').value = "";
                        document.getElementById('jmlh_brg').value = "";
                        document.getElementById('merk_type').value = "";
                        document.getElementById('ukuran_cc').value = "";
                        document.getElementById('bahan').value = "";
                        document.getElementById('perolehan').value = "";
                        document.getElementById('kondisi').value = "";
                        document.getElementById('harga').value = "";
                        document.getElementById('thn_beli').value = "";
                        document.getElementById('umr_ekonomis').value = "";
                        document.getElementById('dipinjam').value = "";
                        document.getElementById('penyusutan').value = "";
                        document.getElementById('nli_sisa').value = "";
                        document.getElementById('ket').value = "";
                    }
                });
                return false;
            });
        });

        function tampil_pengadaan() {
            $.ajax({
                type: "ajax",
                url: "<?= base_url('Master_data/get_pengadaan') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var pgdn = "";
                    for (h = 0; h < c.length; h++) {
                        pgdn +=
                        '<tr>' + 
                            '<td>' + (h + 1) + '</td>' +
                            '<td>' + c[h].kd_brg + '</td>' +
                            '<td>' + c[h].nm_brg + '</td>' +
                            '<td>' + c[h].no_reg + '</td>' +
                            '<td>' + c[h].umr_ekonomis + '</td>' +
                            '<td style="text-align: right;">' + c[h].nli_sisa + '</td>' +
                            // '<td><button type="button" onclick="edit_pengadaan(\'' + c[h].id_brg + '\', \'' + c[h].kd_brg + '\', \'' + c[h].nm_brg + '\' \'' + c[h].no_reg + '\', \'' + c[h].umr_ekonomis + '\')" class="btn btn-info"><i class="fa fa-trash-o"></i></button></td>' +
                            '<td><button type="button" onclick="delete_pengadaan(\'' + c[h].id_brg + '\')" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>' +
                        '</tr>';
                    }
                    $('#pgdn').html(pgdn);
                }
            });
        }

        // function edit_pengadaan(id_brg) {
            
        // }

        function delete_pengadaan(id_brg) {
            $.ajax({
                type: "POST",
                data: "id_brg=" + id_brg,
                url: "<?= base_url('Master_data/del_pengadaan'); ?>",
                dataType: "JSON",
                success: function(d) {
                    tampil_pengadaan();
                }
            })
        }
    </script>

</body>

</html>