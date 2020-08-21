<?php
	$data['tittle'] = "Data Barang";
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
                <h1 class="page-header">Data Barang</h1>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li class="active">Data Barang</li>
                </ol> 
            </div>
            
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Tambah Data Barang
                                <hr align="right" color="black">
                            </div>
                            <?= form_open('aset/inpt_barang'); ?>
                            <div class="status-berhasil" data-statusberhasil="<?= $this->session->flashdata('statusberhasil'); ?>"></div>
                            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
                            <div class="panel-body">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="kd_brg">Kode Barang</label>
                                            <input type="text" class="form-control" name="kd_brg" id="kd_brg" placeholder="">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nm_brg">Nama Barang</label>
                                            <input type="text" class="form-control" name="nm_brg" id="nm_brg" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="jns_brg">Jenis Barang</label>
                                            <input type="text" class="form-control" name="jns_brg" id="jns_brg" placeholder="">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="jmlh_brg">Jumlah Barang</label>
                                            <input type="text" class="form-control" name="jmlh_brg" id="jmlh_brg" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="satuan_brg">Satuan Barang</label>
                                            <select class="selectbox col-sm-12" name="satuan_brg" id="satuan_brg">
                                                <option value="">-- Pilih --</option>
                                                <option value="1">Buah</option>
                                                <option value="2">Unit</option>
                                                <option value="3">Set</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="harga_brg">Harga Barang</label>
                                            <input type="text" class="form-control" name="harga_brg" id="harga_brg" placeholder="">
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                </form>
                                <?php echo form_close() ?>
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
    const statusberhasil = $('.status-berhasil').data('statusberhasil');
    // console.log(statusberhasil);
    if (statusberhasil) {
        swal({
            title: "Berhasil " + statusberhasil,
            text: "Data Berhasil!",
            type: "success",
            timer: 8000,
            showConfirmButton: false
        });
    }

    const statusgagal = $('.status-gagal').data('statusgagal');
    // console.log(statusgagal);
    if (statusgagal) {
        swal({
            title: "Gagal " + statusgagal,
            text: "Periksa Kembali Data Anda!",
            type: "error",
            timer: 8000,
            showConfirmButton: false
        });
    }

	$(document).ready(function() {
        $(".selectbox").select2();
	});
</script>

</body>

</html>