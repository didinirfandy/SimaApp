<?php
	$data['tittle'] = "KIB B";
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
                <h3 class="page-header">KARTU INVENTARIS BARANG PERALATAN DAN MESIN ( KIB B )</h3>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 30, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li>Daftar Aset</li>
                    <li class="active">KIB B</li>
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
                                    <table class="table table-striped table-bordered table-hover table-sm" id="dt_kib_b">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Kode barang</th>
                                                <th>No Register</th>
                                                <th>Merek/Type</th>
                                                <th>Bahan</th>
                                                <th>Tahun Pembelian</th>
                                                <th>Asal-Usul</th>
                                                <th>Kondisi</th>
                                                <th>Harga</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if (is_array($kib_b)) {
                                                    $i=1;
                                                    foreach ($kib_b as $b ) {
                                                        $harga = number_format("$b[harga]",2,",",".");
                                                        $nilsisa = number_format("$b[nli_sisa]",2,",",".");

                                                        if ($b['kondisi'] == 1) { 
                                                            $kondisi = "Baik"; 
                                                        } elseif ($b['kondisi'] == 2) { 
                                                            $kondisi = "Rusak Ringan"; 
                                                        } elseif ($b['kondisi'] == 3) { 
                                                            $kondisi = "Rusak Berat"; 
                                                        } else { 
                                                            $kondisi = "-"; 
                                                        }

                                                        if ($b['merk_type'] == "") { $merk_type = "-"; }
                                                        if ($b['bahan'] == "") { $bahan = "-"; }

                                                        echo "<tr data-id='$b[id_brg]'>
                                                                <td>$i</td>
                                                                <td>$b[nm_brg]</td>
                                                                <td>$b[kd_brg]</td>
                                                                <td>$b[no_reg]</td>
                                                                <td>$b[merk_type]</td>
                                                                <td>$b[bahan]</td>
                                                                <td>$b[thn_beli]</td>
                                                                <td>$b[perolehan]</td>
                                                                <td>$kondisi</td>
                                                                <td style='text-align: right;'>$harga</td>
                                                                <td style='text-align: right;'>$b[umr_ekonomis]</td>
                                                                <td style='text-align: right;'>$nilsisa</td>
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
            $('#dt_kib_b').dataTable();
        })

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

            $(document).on("keydown",".editor",function(e) {
                if(e.keyCode==13) {
                    var target = $(e.target);
                    var value = target.val();
                    var id = target.attr("data-id");
                    var data = {id:id,value:value};
                    
                    if(target.is(".field-kondisi")) {
                        data.modul="kondisi";
                    } 

                    $.ajax({
                        data:data,
                        url:"<?= base_url('Kib/uptd_kib_b'); ?>",
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