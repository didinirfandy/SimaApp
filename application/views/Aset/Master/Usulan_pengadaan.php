<?php
	$data['tittle'] = "Data Usulan Pengadaan";
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
                    Data Usulan Pengadaan
                </h2>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li>Data Master</li>
                    <li class="active">Data Usulan Pengadaan</li>
                </ol> 
            </div>
            
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <!-- Swetalert Berhasil -->
                            <div class="status-insert" data-statusinsert="<?= $this->session->flashdata('statusinsert'); ?>"></div>
                            <!-- Swetalert Gagal -->
                            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
                            <!-- Swetalert Danger -->
                            <div class="status-danger" data-statusdanger="<?= $this->session->flashdata('statusdanger'); ?>"></div>
                            <div class="panel-heading">
                                <h4 style="font-weight:bold;">Tambah Usulan Pengadaan</h4>
                                <hr align="right" color="black">
                            </div>
                            <?php $attr = array('id' => 'regfrom');
                                echo form_open('Master_data/data_usulan_pengadaan', $attr); ?>
                            <?= $this->session->userdata('status_insert'); ?>
                            <div class="panel-body">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="kd_brg">Kode Barang</label>
                                            <input type="text" class="form-control" name="kd_brg" id="kd_brg" placeholder="" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nm_brg">Nama Barang</label>
                                            <input type="text" class="form-control" name="nm_brg" id="nm_brg" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="jns_brg">Jenis Barang</label>
                                            <select class="selectbox col-sm-12" name="jns_brg" id="jns_brg" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="1">KARTU INVENTARIS BARANG TANAH ( KIB A )</option>
                                                <option value="2">KARTU INVENTARIS BARANG PERALATAN DAN MESIN ( KIB B )</option>
                                                <option value="3">KARTU INVENTARIS BARANG GEDUNG DAN BANGUNAN ( KIB C )</option>
                                                <option value="4">KARTU INVENTARIS BARANG JARINGAN ( KIB D )</option>
                                                <option value="5">KARTU INVENTARIS BARANG ASET TETAP LAINNYA ( KIB E )</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="jmlh_brg">Jumlah Barang</label>
                                            <input type="text" class="form-control" name="jmlh_brg" id="jmlh_brg" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="harga_brg">Harga Barang</label>
                                            <input type="text" class="form-control" name="harga_brg" id="harga_brg" placeholder="" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="satuan_brg">Satuan Barang</label>
                                            <select class="selectbox col-sm-12" name="satuan_brg" id="satuan_brg" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="1">Buah</option>
                                                <option value="2">Unit</option>
                                                <option value="3">Set</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea type="text" rows="2" class="form-control" name="ket" id="ket" placeholder="" required></textarea>
                                    </div>
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">Simpan</button>
                                    <input type="hidden" name="kd_usulan" value="<?= $kd_usulan; ?>">
                                </form>
                                <?= form_close() ?>
                            </div>						
                        </div>   
                    </div>
                    <div class="col-md-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="font-weight:bold;">Data Usulan yang ditujukan</h4>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <input id="kd_usulan" type="hidden" value="<?= $kd_usulan;  ?>">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="brg_tbl">
                                        <thead>
                                            <tr>
                                                <th>Kode barang</th>
                                                <th>Nama barang</th>
                                                <th>Jenis barang</th>
                                                <th>Jumlah barang</th>
                                                <th>Satuan barang</th>
                                                <th>Harga barang</th>
                                                <th>Jumlah Barang</th>
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
        tampil_data();

        $(document).ready(function() {
            $("#regfrom").submit(function() {
                $.ajax({
                    type: "POST",
                    data: $('#regfrom').serialize(),
                    url: "<?= base_url('Master_data/inpt_usulan') ?>",
                    dataType: "JSON",
                    success: function(berhasil) {
                        tampil_data();
                        document.getElementById('kd_brg').value = "";
                        document.getElementById('nm_brg').value = "";
                        document.getElementById('jns_brg').value = "";
                        document.getElementById('jmlh_brg').value = "";
                        document.getElementById('satuan_brg').value = "";
                        document.getElementById('harga_brg').value = "";
                        // document.getElementById('ket').value = "";
                    }
                });
                return false;
            });
        });

        function tampil_data() {
            var kd_usulan = $('#kd_usulan').val();
            $.ajax({
                type: "POST",
                data: "kd_usulan=" + kd_usulan,
                url: "<?= base_url('Master_data/get_usulan'); ?>",
                dataType: "JSON",
                success: function(a) {
                    var row = '';
                    for (var i = 0; i < a.length; i++) {

                        if (a[i].jns_brg == 1) { jenis = "KIB A"; } 
                        else if (a[i].jns_brg == 2) { jenis = "KIB B"; } 
                        else if (a[i].jns_brg == 3) { jenis = "KIB C"; } 
                        else if (a[i].jns_brg == 4) { jenis = "KIB D"; } 
                        else if (a[i].jns_brg == 5) { jenis = "KIB E"; } 
                        else { jenis = "-"; }

                        if (a[i].satuan_brg == 1) { satuan = "Buah"; } 
                        else if (a[i].satuan_brg == 2) { satuan = "Unit"; }
                        else if (a[i].satuan_brg == 3) { satuan = "Set"; } 
                        else { satuan = "-"; }

                        row += '<tr>' + 
                                    '<td>' + a[i].kd_brg + '</td>' +
                                    '<td>' + a[i].nm_brg + '</td>' +
                                    '<td>' + jenis + '</td>' +
                                    '<td>' + a[i].jmlh_brg + '</td>' +
                                    '<td>' + satuan + '</td>' +
                                    '<td>' + a[i].harga_brg + '</td>' +
                                    '<td>' + a[i].jmlh_brg + '</td>' +
                                    '<td><button type="submit" title="Hapus" onclick="delete_usulan(\'' + a[i].id_usulan + '\')" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>' +
                                '</tr>';
                        
                    }
                    $('#tmpl_data').html(row);
                }
            });
        }

        function delete_usulan(id_usulan) {
            $.ajax({
                type: "POST",
                data: "id_usulan=" + id_usulan,
                url: "<?= base_url('Master_data/del_usulan'); ?>",
                dataType: "JSON",
                success: function(a) {
                    tampil_data();
                }
            })
        }

        const statusinsert = $('.status-insert').data('statusinsert');
        // console.log(statusinsert);
        if (statusinsert) {
            swal({
                title: "Berhasil " + statusinsert,
                text: "Menunggu karyawan untuk menyetujui lembur",
                type: "success",
                timer: 5000,
                showConfirmButton: false
            });
        }

        const statusgagal = $('.status-gagal').data('statusgagal');
        // console.log(statusgagal);
        if (statusgagal) {
            swal({
                title: "Gagal " + statusgagal,
                text: "Periksa kembali inputan Anda",
                type: "error",
                timer: 5000,
                showConfirmButton: false
            });
        }

        const statusdanger = $('.status-danger').data('statusdanger');
        // console.log(statusdanger);
        if (statusdanger) {
            swal({
                title: "Gagal " + statusdanger,
                text: "Karyawan Anda sedang menjalankan cuti",
                type: "warning",
                timer: 5000,
                showConfirmButton: false
            });
        }
    </script>

</body>

</html>