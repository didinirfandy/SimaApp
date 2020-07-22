<!DOCTYPE html>
<html>

<head>
	<?php
	$data['tittle'] = "Halaman Login";
	$this->load->view('template/head_lg', $data);
	?>
</head>

<body style="background-color: #666666;">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="<?= base_url('Login/login'); ?>">
					<span class="login100-form-title p-b-43">
						<img alt="#" src="<?= base_url(); ?>assets_app/img/skul.png"><br>
						SMAN 3 CIMAHI
                    </span>
                    
					<div class="wrap-input100 validate-input" data-validate="Masukan Username Anda">
						<input class="input100" type="text" name="username">
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password dibutuhkan">
						<input class="input100" id="show_pass" type="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="show_checkbox" type="checkbox">
							<label class="label-checkbox100" for="show_checkbox">
								Tampilkan Kata Sandi
							</label>
						</div>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="submit" id="submit">Masuk</button>
						<button class="login100-form-btn" id="loading" style="display: none;" ><i class="fa fa-circle-o-notch fa-spin"></i> Loading</button>
					</div>

					<div class="flex-sb-m w-full p-t-6 p-b-35">
						<font color="white" size="2">
							<?php 
								echo $this->session->userdata('notif');
								$this->session->sess_destroy(); 
							?>
						</font>
					</div>
				</form>
				
				<div class="login100-more"></div>
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
		
		$('#submit').click(function() {
			var pass = $('#show_pass').val();
			if (pass == "") {
				$('#submit').show();
			} else {	
				$('#submit').hide();
				$('#loading').show();
			}
		});
	});
</script>

</body>

</html>