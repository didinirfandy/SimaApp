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
                                            <label for="kd_brg">Kode Aset <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" name="kd_brg" id="kd_brg" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="nm_brg">Nama Aset</label>
                                            <input type="text" class="form-control" name="nm_brg" id="nm_brg" required readonly>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="no_reg">No Registrasi</label>
                                            <input type="text" class="form-control" name="no_reg" id="no_reg" >
                                        </div> -->
                                        <div class="form-group">
                                            <label for="jmlh_brg">Jumlah Aset</label>
                                            <input type="text" class="form-control" name="jmlh_brg" id="jmlh_brg" required readonly>
                                        </div>
                                        <input type="hidden" name="jns_brg" id="jns_brg">
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
                                        <!-- <div class="form-group">
                                            <label for="kondisi">Kondisi Aset</label>
                                            <select class="selectbox col-sm-12" name="kondisi" id="kondisi">
                                                <option value="">-- Pilih --</option>
                                                <option value="1">BAIK</option>
                                                <option value="2">TIDAK BAIK</option>
                                            </select>
                                        </div> -->
                                        <input type="hidden" name="kondisi" value="1">
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
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cek_usulan">Cek Usulan</button><br><br>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Data Pengadaan</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="dt_brg">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Aset</th>
                                                <th>No Registrasi</th>
                                                <th>Nama Aset</th>
                                                <th>Merk/Type</th>
                                                <th>Ukuran/CC</th>
                                                <th>Perolehan</th>
                                                <th>Bahan</th>
                                                <th>Tahun Beli</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pgdn">
                                        <?php 
                                            if(is_array($pgdn)){
                                                $i=1;
                                                foreach ($pgdn as $a) {
                                                    $nilsisa = number_format("$a[nli_sisa]",2,",",".");
                                                    echo "<tr data-id='$a[id_brg]'>
                                                            <td>$i</td>
                                                            <td>$a[kd_brg]</td>
                                                            <td>$a[no_reg]</td>
                                                            <td>$a[nm_brg]</td>
                                                            <td>
                                                                <span class='span-merktype caption' data-id='$a[id_brg]'>$a[merk_type]</span>
                                                                <input type='text' class='field-merktype form-control editor' style='display: none;' value='$a[merk_type]' data-id='$a[id_brg]' />
                                                            </td>
                                                            <td>
                                                                <span class='span-ukurancc caption' data-id='$a[id_brg]'>$a[ukuran_cc]</span>
                                                                <input type='text' class='field-ukurancc form-control editor' style='display: none;' value='$a[ukuran_cc]' data-id='$a[id_brg]' />
                                                            </td>
                                                            <td>
                                                                <span class='span-perolehan caption' data-id='$a[id_brg]'>$a[perolehan]</span>
                                                                <input type='text' class='field-perolehan form-control editor' style='display: none;' value='$a[perolehan]' data-id='$a[id_brg]' />
                                                            </td>
                                                            <td>
                                                                <span class='span-bahan caption' data-id='$a[id_brg]'>$a[bahan]</span>
                                                                <input type='text' class='field-bahan form-control editor' style='display: none;' value='$a[bahan]' data-id='$a[id_brg]' />
                                                            </td>
                                                            <td>
                                                                <span class='span-thbeli caption' data-id='$a[id_brg]'>$a[thn_beli]</span>
                                                                <input type='text' class='field-thbeli form-control editor' style='display: none;' value='$a[thn_beli]' data-id='$a[id_brg]' />
                                                            </td>
                                                            <td style='text-align: right;'>
                                                                <span class='span-umrek caption' data-id='$a[id_brg]'>$a[umr_ekonomis]</span>
                                                                <input type='text' class='field-umrek form-control editor' style='display: none;' value='$a[umr_ekonomis]' data-id='$a[id_brg]' />
                                                            </td>
                                                            <td style='text-align: right;'>
                                                                <span class='span-nilss caption' data-id='$a[id_brg]'>$nilsisa</span>
                                                                <input type='text' class='field-nilss form-control editor' style='display: none;' value='$a[nli_sisa]' data-id='$a[id_brg]' />
                                                            </td>
                                                            <td><button class='btn btn-xs btn-danger hapus-member' data-id='$a[id_brg]'><i class='fa fa-remove'></i> Hapus</button></td>
                                                            </tr>";
                                                    $i++;
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>						
                        </div>   
                    </div>
                </div>
				<?php $this->load->view('template/copyright') ?>
            </div>

            <!-- Modal usulan -->
            <div class="modal fade" id="cek_usulan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="exampleModalLabel">Data Usulan pengadaan</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="jns_brg_usul" class="col-sm-2">Jenis Aset</label>
                                        <div class="col-md-10">
                                            <select class="selectbox col-sm-12" style="width: 70%;" id="jns_brg_usul">
                                                <option value="">-- Pilih --</option>
                                                <option value="1">KARTU INVENTARIS BARANG TANAH ( KIB A )</option>
                                                <option value="2">KARTU INVENTARIS BARANG PERALATAN DAN MESIN ( KIB B )</option>
                                                <option value="3">KARTU INVENTARIS BARANG GEDUNG DAN BANGUNAN ( KIB C )</option>
                                                <option value="4">KARTU INVENTARIS BARANG JARINGAN ( KIB D )</option>
                                                <option value="5">KARTU INVENTARIS BARANG ASET TETAP LAINNYA ( KIB E )</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr align="right" color="black">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm" id="brg_usulan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Aset</th>
                                            <th>Nama Aset</th>
                                            <th>Jenis Barang</th>
                                            <th>Satuan barang</th>
                                            <th>Jumlah Barang</th>
                                            <th>Harga Barang</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="usulan">

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
            // tampil_pengadaan();
            tampil_data_usulan();

            $('#dt_brg').dataTable();
            $('#brg_usulan').dataTable();

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
                        // document.getElementById('kondisi').value = "";
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


        $(function(){
            $.ajaxSetup({
                type:"post",
                cache:false,
                dataType: "json"
            })


            $(document).on("click","td",function(){
                $(this).find("span[class ~='caption']").hide();
                $(this).find("input[class ~='editor']").fadeIn().focus();
            });

            $(document).on("keydown",".editor",function(e){
                if(e.keyCode==13){
                    var target=$(e.target);
                    var value=target.val();
                    var id=target.attr("data-id");
                    var data={id:id,value:value};
                    
                    if(target.is(".field-merktype")) {
                        data.modul="merk_type";
                    } else if(target.is(".field-ukurancc")) {
                        data.modul="ukuran_cc";
                    } else if(target.is(".field-perolehan")) {
                        data.modul="perolehan";
                    } else if(target.is(".field-bahan")) {
                        data.modul="bahan";
                    } else if(target.is(".field-thbeli")) {
                        data.modul="thbeli";
                    } else if(target.is(".field-umrek")) {
                        data.modul="umr_ekonomis";
                    } else if(target.is(".field-nilss")) {
                        data.modul="nli_sisa";
                    }

                    $.ajax({
                        data:data,
                        url:"<?= base_url('Master_data/updt_pengadaan'); ?>",
                        success: function(a){
                            target.hide();
                            target.siblings("span[class~='caption']").html(value).fadeIn();
                            location.reload();
                        }

                    });

                }

            });

            $(document).on("click",".hapus-member",function(){
                var id=$(this).attr("data-id");
                swal({
                    title:"Hapus Member",
                    text:"Yakin akan menghapus member ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                    closeOnConfirm: true,
                }, function(){
                    $.ajax({
                        url:"<?= base_url('Master_data/delete'); ?>",
                        data:{id:id},
                        success: function(){
                            $("tr[data-id='"+id+"']").fadeOut("fast",function(){
                                $(this).remove();
                            });
                        }
                    });
                });
            });

            
        });

        // function tampil_pengadaan() {
        //     $.ajax({
        //         type: "ajax",
        //         url: "<?= base_url('Master_data/get_pengadaan') ?>",
        //         async: false,
        //         dataType: "JSON",
        //         success: function(c) {
        //             var pgdn = "";
        //             for (h = 0; h < c.length; h++) {
        //                 pgdn +=
        //                 '<tr>' + 
        //                     '<td>' + (h + 1) + '</td>' +
        //                     '<td>' + c[h].kd_brg + '</td>' +
        //                     '<td>' + c[h].no_reg + '</td>' +
        //                     '<td>' + c[h].nm_brg + '</td>' +
        //                     '<td>' + c[h].umr_ekonomis + '</td>' +
        //                     '<td style="text-align: right;">' + c[h].nli_sisa + '</td>' +
        //                     '<td>' + c[h].kondisi + '</td>' +
        //                     // '<td><button type="button" onclick="edit_pengadaan(\'' + c[h].id_brg + '\', \'' + c[h].kd_brg + '\', \'' + c[h].nm_brg + '\' \'' + c[h].no_reg + '\', \'' + c[h].umr_ekonomis + '\')" class="btn btn-info"><i class="fa fa-trash-o"></i></button></td>' +
        //                     '<td><button type="button" onclick="delete_pengadaan(\'' + c[h].id_brg + '\')" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>' +
        //                 '</tr>';
        //             }
        //             $('#pgdn').html(pgdn);
        //         }
        //     });
        // }

        // function edit_pengadaan(id_brg) {
            
        // }


        function tampil_data_usulan() {
            $('#jns_brg_usul').on('change', function() {
                var jns_brg_usul = $('#jns_brg_usul option:selected').attr('value');
                $.ajax({
                    type: "POST",
                    data: "jns_brg_usul=" + jns_brg_usul,
                    url: "<?= base_url('Master_data/get_usulan_jns'); ?>",
                    dataType: "JSON",
                    success: function(a) {
                        var row = '';
                        for (var i = 0; i < a.length; i++) {
                            var bilangan = a[i].harga_brg
                            
                            var	reverse     = bilangan.toString().split('').reverse().join(''),
                                harga_brg 	= reverse.match(/\d{1,3}/g);
                                harga_brg	= harga_brg.join('.').split('').reverse().join('');
    
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
                                        '<td>' + (i + 1) + '</td>' +
                                        '<td>' + a[i].kd_brg + '</td>' +
                                        '<td>' + a[i].nm_brg + '</td>' +
                                        '<td>' + jenis + '</td>' +
                                        '<td>' + a[i].jmlh_brg + '</td>' +
                                        '<td>' + satuan + '</td>' +
                                        '<td style="text-align: right;">' + harga_brg + '</td>' +
                                        '<td><button type="submit" title="Tambah" onclick="get(\'' + a[i].kd_brg + '\', \'' + a[i].nm_brg + '\', \'' + a[i].jns_brg + '\', \'' + a[i].jmlh_brg + '\')" class="btn btn-info"><i class="fa fa-plus"></i></button></td>' +
                                    '</tr>';
                            
                        }
                        $('#usulan').html(row);
                    }
                });
            });
            
        }

        function get(kd_brg, nm_brg, jns_brg, jmlh_brg) {
            $("#kd_brg").val(kd_brg);
            $("#nm_brg").val(nm_brg);
            $("#jns_brg").val(jns_brg);
            $("#jmlh_brg").val(jmlh_brg);
            $("#cek_usulan").modal("hide");
        }

        // function delete_pengadaan(id_brg) {
        //     $.ajax({
        //         type: "POST",
        //         data: "id_brg=" + id_brg,
        //         url: "<?= base_url('Master_data/del_pengadaan'); ?>",
        //         dataType: "JSON",
        //         success: function(d) {
        //             tampil_pengadaan();
        //         }
        //     })
        // }
    </script>

</body>

</html>