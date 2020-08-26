<?php
$data['tittle'] = "Setting";
$this->load->view('template/head', $data);
?>

<body>
    <div id="wrapper">
        <?php $this->load->view('template/navbar'); ?>
        <!--/. NAV TOP  -->
        <?php $this->load->view('template/menu'); ?>
        <!-- /. NAV SIDE  -->

        <div id="page-wrapper">
            <div class="header1">
                <div class="page-header1">
                    <div class="user">
                        <div class="profile">
                            <div class="info">
                                <?php
                                foreach ($pro as $p) { ?>
                                    <img class="user-img" src="<?= base_url(); ?>assets_app/img/profil/<?= $p['image'] ?>">
                                <?php } ?>
                                <h4><?php $str = $this->session->userdata('nama_pegawai');
                                    echo wordwrap($str, 30, "<br>\n"); ?></h4>
                                <p>
                                    <?php
                                    $role = $this->session->userdata('role');
                                    if ($role == 1) {
                                        echo "Tenaga Administrasi Aset";
                                    } elseif ($role == 2) {
                                        echo "Wakasek Sarana";
                                    } elseif ($role == 3) {
                                        echo "Kepala Sekolah";
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="cover-image"></div>
                        </div>
                    </div>
                </div>
            </div>

            <?= $this->session->flashdata('msg') ?>
            <?= $this->session->flashdata('gagal') ?>
            <!-- Swetalert Berhasil -->
            <div class="status-ok" data-statusok="<?= $this->session->flashdata('statusok'); ?>"></div>
            <!-- Swetalert Berhasil -->
            <div class="status-insert" data-statusinsert="<?= $this->session->flashdata('statusinsert'); ?>"></div>
            <!-- Swetalert Gagal -->
            <div class="status-gagal" data-statusgagal="<?= $this->session->flashdata('statusgagal'); ?>"></div>
            <div class="status-lama" data-statuslama="<?= $this->session->flashdata('statuslama'); ?>"></div>

            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="font-weight:bold;">Data Pengguna</h4>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <?php
                                foreach ($pro as $lg) { ?>
                                    <?= form_open_multipart('Kepsek/edt_dt_user'); ?>
                                    <form class="form-horizontal">
                                        <input type="hidden" name="user_id" value="<?= $lg['user_id'] ?>">
                                        <div class="form-group row">
                                            <label for="nama_pegawai" class="control-label col-md-2 text-right">Nama</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="<?= $lg['nama_pegawai'] ?>" name="nama_pegawai" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nik" class="control-label col-md-2 text-right">NIP</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="<?= $lg['nik'] ?>" name="nik" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="ktp" class="control-label col-md-2 text-right">No KTP</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="<?= $lg['ktp'] ?>" name="ktp" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="username" class="control-label col-md-2 text-right">Username</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="<?= $lg['username'] ?>" name="username" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pass" class="control-label col-md-2 text-right">Password Lama</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="password" name="password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="new_password" class="control-label col-md-2 text-right">Password Baru</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="password" name="new_password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="confirm_password" class="control-label col-md-2 text-right">Konfimasi Password</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="password" name="confirm_password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="image" class="control-label col-md-2 text-right">Image</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php } ?>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('template/copyright') ?>
                <!-- /. ROW  -->
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php $this->load->view('template/script') ?>
    <script type="text/javascript">
        const statusok = $('.status-ok').data('statusok');
        // console.log(statusok);
        if (statusok) {
            swal({
                title: "Berhasil " + statusok,
                text: "Data Berhasil Di Input",
                type: "success",
                timer: 7000,
                showConfirmButton: false
            });
        }

        const statusinsert = $('.status-insert').data('statusinsert');
        // console.log(statusinsert);
        if (statusinsert) {
            swal({
                title: "Berhasil " + statusinsert,
                text: "Data Berhasil Di Input",
                type: "success",
                timer: 7000,
                showConfirmButton: false
            });
        }

        const statusgagal = $('.status-gagal').data('statusgagal');
        // console.log(statusgagal);
        if (statusgagal) {
            swal({
                title: "Gagal " + statusgagal,
                text: "EDIT KEMBALI DATA ANDA DENGAN BENAR",
                type: "error",
                timer: 7000,
                showConfirmButton: false
            });
        }

        const statuslama = $('.status-lama').data('statuslama');
        // console.log(statuslama);
        if (statuslama) {
            swal({
                title: "lama " + statuslama,
                text: "EDIT KEMBALI DATA ANDA DENGAN BENAR",
                type: "error",
                timer: 7000,
                showConfirmButton: false
            });
        }
    </script>

</body>

</html>