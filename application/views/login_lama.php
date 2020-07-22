<!DOCTYPE html>
<html>

<head>
	<?php
	$data['tittle'] = "Halaman Login";
	$this->load->view('template/head_lg', $data);
	?>
</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-30 p-b-30">
				<form class="login100-form validate-form" method="POST" action="<?= base_url('Login/login'); ?>">
					<span class="login100-form-title p-b-15">
						<img alt="#" src="<?= base_url(); ?>assets_app/img/skul.png"><br>
						SMAN 3 CIMAHI
                    </span>
                    
					<div class="wrap-input100 validate-input m-b-16" data-validate="Masukan Nama Pengguna Anda">
						<input class="input100" type="text" name="username" placeholder="Nama Pengguna">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-user"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Kata Sandi dibutuhkan">
						<input class="input100" id="show_pass" type="password" name="password"  placeholder="Kata Sandi">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
					</div>

					<div class="contact100-form-checkbox m-l-4">
						<input class="input-checkbox100" id="show_checkbox" type="checkbox">
						<label class="label-checkbox100" for="show_checkbox">
							Tampilkan Kata Sandi
						</label>
					</div>
					
					<div class="container-login100-form-btn p-t-35">
						<button class="login100-form-btn" name="submit">
							Masuk
						</button>
					</div>

					<div class="text-center w-full p-t-30">
						<span class="txt1">
							
						</span>

						<a class="txt1 bo1 hov1" href="#">
							
						</a>
					</div>
				</form>
				<font color="waite" size="2">
					<?php 
						echo $this->session->userdata('notif');
						$this->session->sess_destroy(); 
					?>
				</font>
			</div>
		</div>
	</div>
	
	
<?php $this->load->view('template/script_lg'); ?>
<script type="text/javascript">
	$(document).ready(function(){		
		$('#show_checkbox').click(function(){
			if($(this).is(':checked')){
				$('#show_pass').attr('type','text');
			}else{
				$('#show_pass').attr('type','password');
			}
		});
	});
</script>

</body>

</html>